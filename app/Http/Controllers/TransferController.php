<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransferController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $remainingLimit = $user->remaining_daily_limit;
        
        return view('transfer.create', compact('remainingLimit'));
    }

    public function store(Request $request)
    {
        Log::info('=== TRANSFER PROCESS STARTED ===', $request->all());

        // Enhanced validation for both local and international transfers
        $request->validate([
            'transfer_type' => 'required|in:local,international',
            'recipient_account_number' => 'required_if:transfer_type,local',
            'amount' => 'required|numeric|min:0.01',
            'recipient_name' => 'required',
            'description' => 'nullable|string|max:255',
            // International transfer fields
            'bank_name' => 'required_if:transfer_type,international',
            'bank_country' => 'required_if:transfer_type,international',
            'bank_address' => 'required_if:transfer_type,international',
            'swift_code' => 'required_if:transfer_type,international',
            'iban' => 'required_if:transfer_type,international',
            'intermediary_bank' => 'nullable|string|max:255',
        ]);

        $user = Auth::user();
        $amount = $request->amount;

        Log::info('User and amount details', [
            'user_id' => $user->id,
            'user_balance' => $user->balance,
            'is_admin' => $user->is_admin,
            'transfer_amount' => $amount,
            'has_sufficient_balance' => $user->balance >= $amount
        ]);

        // NEW: Check transfer limits and balance (admins are exempt)
        if (!$user->is_admin) {
            $canTransfer = $user->canTransfer($amount);
            if (!$canTransfer['success']) {
                Log::warning('Transfer limit exceeded', [
                    'user_id' => $user->id,
                    'amount' => $amount,
                    'daily_limit' => $user->daily_limit,
                    'daily_transferred' => $user->daily_transferred,
                    'max_transaction' => $user->max_transaction,
                    'message' => $canTransfer['message']
                ]);
                return back()->with('error', $canTransfer['message']);
            }
        }

        // Check if user has enough balance
        if ($user->balance < $amount) {
            Log::warning('Insufficient balance for transfer', [
                'user_id' => $user->id, 
                'current_balance' => $user->balance,
                'requested_amount' => $amount
            ]);
            return back()->with('error', 'Insufficient balance for this transfer.');
        }

        DB::beginTransaction();
        Log::info('Database transaction begun');

        try {
            // Generate transaction reference
            $transactionRef = 'TXN' . date('YmdHis') . rand(1000, 9999);
            Log::info('Generated transaction reference', ['transaction_ref' => $transactionRef]);

            if ($request->transfer_type === 'local') {
                Log::info('Processing LOCAL transfer');
                
                // LOCAL TRANSFER LOGIC
                $recipient = User::where('account_number', $request->recipient_account_number)
                                ->where('status', 'active')
                                ->first();

                if (!$recipient) {
                    Log::warning('Recipient account not found or inactive', [
                        'searched_account' => $request->recipient_account_number
                    ]);
                    return back()->with('error', 'Recipient account not found or inactive.');
                }

                // Prevent self-transfer
                if ($recipient->id === $user->id) {
                    Log::warning('User attempted self-transfer', [
                        'user_id' => $user->id,
                        'user_account' => $user->account_number
                    ]);
                    return back()->with('error', 'You cannot transfer money to your own account.');
                }

                Log::info('Recipient validated', [
                    'recipient_id' => $recipient->id,
                    'recipient_name' => $recipient->name,
                    'recipient_account' => $recipient->account_number
                ]);

                // Record transaction for sender
                $transactionData = [
                    'transaction_ref' => $transactionRef,
                    'user_id' => $user->id,
                    'type' => 'transfer',
                    'amount' => $amount,
                    'balance_before' => $user->balance,
                    'balance_after' => $user->balance - $amount,
                    'description' => $request->description ?: "Transfer to {$recipient->name}",
                    'status' => 'completed',
                    'recipient_account_number' => $recipient->account_number,
                    'recipient_name' => $recipient->name,
                    'transfer_type' => 'local',
                ];

                Log::info('Creating sender transaction', $transactionData);
                $transaction = Transaction::create($transactionData);
                Log::info('Sender transaction created', ['transaction_id' => $transaction->id]);

                // Update sender's balance and transfer stats (admins are exempt from stats)
                $user->decrement('balance', $amount);
                $user->updateTransferStats($amount); // This method now handles admin exemption
                Log::info('Sender balance updated', [
                    'previous_balance' => $user->balance + $amount,
                    'new_balance' => $user->balance,
                    'daily_transferred' => $user->daily_transferred,
                    'is_admin' => $user->is_admin
                ]);

                // Update recipient's balance
                $recipient->increment('balance', $amount);
                Log::info('Recipient balance updated', [
                    'recipient_id' => $recipient->id,
                    'previous_balance' => $recipient->balance - $amount,
                    'new_balance' => $recipient->balance
                ]);

                // Record transaction for recipient
                $recipientTransactionData = [
                    'transaction_ref' => $transactionRef . 'R',
                    'user_id' => $recipient->id,
                    'type' => 'deposit',
                    'amount' => $amount,
                    'balance_before' => $recipient->balance - $amount,
                    'balance_after' => $recipient->balance,
                    'description' => "Transfer from {$user->name}",
                    'status' => 'completed',
                    'recipient_account_number' => $user->account_number,
                    'recipient_name' => $user->name,
                    'transfer_type' => 'local',
                ];

                Log::info('Creating recipient transaction', $recipientTransactionData);
                Transaction::create($recipientTransactionData);
                Log::info('Recipient transaction created');

                DB::commit();
                Log::info('LOCAL transfer completed successfully');

                return redirect()->route('transfer.success', $transaction->id)
                    ->with('success', 'Transfer completed successfully!');

            } else {
                Log::info('Processing INTERNATIONAL transfer');
                
                // NEW: For international transfers, we still check limits but don't update stats until completion
                if (!$user->is_admin) {
                    $canTransfer = $user->canTransfer($amount);
                    if (!$canTransfer['success']) {
                        return back()->with('error', $canTransfer['message']);
                    }
                }

                // Generate token for international transfer
                $token = $this->generateToken();
                $tokenExpiresAt = now()->addMinutes(30);

                // INTERNATIONAL TRANSFER LOGIC
                $transactionData = [
                    'transaction_ref' => $transactionRef,
                    'user_id' => $user->id,
                    'type' => 'wire_transfer',
                    'amount' => $amount,
                    'balance_before' => $user->balance,
                    'balance_after' => $user->balance,
                    'description' => $request->description ?: "Wire transfer to {$request->recipient_name}",
                    'status' => 'pending_approval',
                    'recipient_account_number' => $request->iban,
                    'recipient_name' => $request->recipient_name,
                    'transfer_type' => 'international',
                    'bank_name' => $request->bank_name,
                    'bank_country' => $request->bank_country,
                    'bank_address' => $request->bank_address,
                    'swift_code' => $request->swift_code,
                    'iban' => $request->iban,
                    'intermediary_bank' => $request->intermediary_bank,
                    // Add token fields
                    'token' => $token,
                    'token_expires_at' => $tokenExpiresAt,
                ];

                Log::info('Creating international transaction', $transactionData);
                $transaction = Transaction::create($transactionData);
                Log::info('International transaction created', ['transaction_id' => $transaction->id]);

                // Log the token for demo purposes
                Log::info('Transfer token generated', [
                    'transaction_id' => $transaction->id,
                    'token' => $token,
                    'expires_at' => $tokenExpiresAt
                ]);

                DB::commit();
                Log::info('INTERNATIONAL transfer processed successfully - redirecting to pending page');

                return redirect()->route('transfer.pending', $transaction->id)
                    ->with('success', 'International transfer submitted. Please enter the verification token to complete.');
            }

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('=== TRANSFER FAILED CRITICALLY ===', [
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'error_trace' => $e->getTraceAsString(),
                'user_id' => $user->id,
                'transfer_type' => $request->transfer_type ?? 'unknown',
                'amount' => $amount,
                'request_data' => $request->all()
            ]);
            return back()->with('error', 'Transfer failed. Please try again.');
        }
    }

    // Token verification method (updated for international transfers)
    public function verifyToken(Request $request, Transaction $transaction)
    {
        $request->validate([
            'token' => 'required|string|size:6'
        ]);

        $user = Auth::user();
        $enteredToken = strtoupper($request->token);

        // Check if token matches and is not expired
        if ($transaction->token === $enteredToken) {
            
            if ($transaction->token_expires_at && $transaction->token_expires_at->isPast()) {
                return response()->json([
                    'success' => false, 
                    'message' => 'Token has expired. Please request a new one.'
                ], 422);
            }

            DB::beginTransaction();
            try {
                // Update user balance and transfer stats for international transfer
                $user->decrement('balance', $transaction->amount);
                $user->updateTransferStats($transaction->amount); // NEW: Update daily transfer stats

                // Update transaction status and clear token
                $transaction->update([
                    'status' => 'completed',
                    'balance_after' => $user->balance,
                    'token' => null,
                    'token_expires_at' => null
                ]);

                DB::commit();

                Log::info('International transfer token verified successfully', [
                    'transaction_id' => $transaction->id,
                    'user_id' => $user->id,
                    'amount' => $transaction->amount
                ]);

                return response()->json([
                    'success' => true, 
                    'message' => 'Transfer completed successfully!',
                    'redirect_url' => route('transfer.success', $transaction->id)
                ]);

            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Token verification failed', [
                    'transaction_id' => $transaction->id,
                    'error' => $e->getMessage()
                ]);
                return response()->json([
                    'success' => false, 
                    'message' => 'Transfer failed. Please try again.'
                ], 500);
            }

        } else {
            Log::warning('Invalid token attempt', [
                'transaction_id' => $transaction->id,
                'entered_token' => $enteredToken,
                'expected_token' => $transaction->token,
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'success' => false, 
                'message' => 'Invalid token. Please check and try again.'
            ], 422);
        }
    }

    // Token resend method
    public function resendToken(Transaction $transaction)
    {
        // Generate new token
        $newToken = $this->generateToken();
        $newExpiresAt = now()->addMinutes(30);

        // Update transaction with new token
        $transaction->update([
            'token' => $newToken,
            'token_expires_at' => $newExpiresAt
        ]);

        Log::info('Token resent', [
            'transaction_id' => $transaction->id,
            'new_token' => $newToken,
            'user_id' => Auth::id()
        ]);

        return response()->json([
            'success' => true,
            'message' => 'New token has been generated. Check your records for the new code.',
            'token' => $newToken // Remove this in production - only for demo
        ]);
    }

    // Helper method to generate tokens
    private function generateToken()
    {
        return strtoupper(substr(md5(uniqid(mt_rand(), true)), 0, 6));
    }

    public function success(Transaction $transaction)
    {
        Log::info('Transfer success page accessed', [
            'transaction_id' => $transaction->id,
            'user_id' => Auth::id()
        ]);
        return view('transfer.success', compact('transaction'));
    }

    public function pending(Transaction $transaction)
    {
        Log::info('Transfer pending page accessed', [
            'transaction_id' => $transaction->id,
            'user_id' => Auth::id(),
            'transaction_status' => $transaction->status
        ]);
        return view('transfer.pending', compact('transaction'));
    }

    public function validateAccount(Request $request)
    {
        Log::info('Account validation request', [
            'account_number' => $request->account_number,
            'user_id' => Auth::id()
        ]);

        $request->validate([
            'account_number' => 'required'
        ]);

        $user = User::where('account_number', $request->account_number)
            ->where('status', 'active')
            ->first();

        if ($user) {
            Log::info('Account validation successful', [
                'account_number' => $request->account_number,
                'account_name' => $user->name
            ]);
            return response()->json([
                'account_name' => $user->name,
                'bank_name' => 'Oarkard Bank'
            ]);
        } else {
            Log::warning('Account validation failed', [
                'account_number' => $request->account_number
            ]);
            return response()->json([
                'error' => 'Account not found'
            ], 404);
        }
    }

    public function getExchangeRate(Request $request)
    {
        Log::info('Exchange rate request', [
            'from_currency' => $request->from_currency,
            'to_currency' => $request->to_currency,
            'user_id' => Auth::id()
        ]);

        // Simple mock exchange rates
        $rates = [
            'USD_EUR' => 0.85,
            'USD_GBP' => 0.73,
            'USD_JPY' => 110.50,
            'USD_CAD' => 1.25,
            'USD_AUD' => 1.35,
            'USD_NGN' => 410.50,
        ];

        $key = $request->from_currency . '_' . $request->to_currency;
        
        if (isset($rates[$key])) {
            return response()->json([
                'rate' => $rates[$key],
                'from' => $request->from_currency,
                'to' => $request->to_currency
            ]);
        }

        return response()->json(['error' => 'Exchange rate not available'], 404);
    }
}