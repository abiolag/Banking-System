<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        // Temporarily comment out admin middleware
        // $this->middleware('admin');
    }

    public function dashboard()
    {
        // Manual admin check
        if (!Auth::user()->is_admin) {
            return redirect('/dashboard')->with('error', 'Unauthorized access.');
        }

        $users = User::where('is_admin', false)->get();
        $pendingTransfers = Transaction::where('status', 'pending_approval')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        Log::info('Admin dashboard loaded', [
            'admin_id' => Auth::id(),
            'admin_name' => Auth::user()->name,
            'pending_transfers_count' => $pendingTransfers->count(),
            'total_users' => $users->count()
        ]);

        return view('admin.dashboard', compact('users', 'pendingTransfers'));
    }

    public function creditUser(Request $request, $userId)
    {
        // Manual admin check
        if (!Auth::user()->is_admin) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'amount' => 'required|numeric|min:0.01'
        ]);

        $user = User::findOrFail($userId);
        $user->balance += $request->amount;
        $user->save();

        Log::info('User credited by admin', [
            'admin_id' => Auth::id(),
            'user_id' => $userId,
            'amount' => $request->amount,
            'new_balance' => $user->balance
        ]);

        return back()->with('success', "Successfully credited \${$request->amount} to {$user->name}");
    }

    public function approveTransfer(Request $request, $transactionId)
    {
        // Manual admin check
        if (!Auth::user()->is_admin) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        try {
            $transaction = Transaction::findOrFail($transactionId);
            
            if ($transaction->status !== 'pending_approval') {
                return response()->json(['error' => 'Transfer is not pending approval'], 400);
            }

            DB::beginTransaction();

            // Update transaction status - use 'completed' as that's the allowed ENUM value
            $transaction->update([
                'status' => 'completed', // This is the correct ENUM value
                'approved_by' => Auth::id(),
                'approved_at' => now()
            ]);

            // Deduct balance from user
            $user = $transaction->user;
            $user->decrement('balance', $transaction->amount);
            
            // Update transaction with final balance
            $transaction->update([
                'balance_after' => $user->balance
            ]);

            DB::commit();

            // Send approval notification to user
            $this->sendTransferApprovalNotification($transaction);

            Log::info('International transfer approved', [
                'transaction_id' => $transaction->id,
                'admin_id' => Auth::id(),
                'amount' => $transaction->amount,
                'user_id' => $user->id
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Transfer approved successfully!'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Transfer approval failed', [
                'transaction_id' => $transactionId,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Approval failed: ' . $e->getMessage()
            ], 500);
        }
    }

    public function rejectTransfer(Request $request, $transactionId)
    {
        // Manual admin check
        if (!Auth::user()->is_admin) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        $request->validate([
            'reason' => 'required|string|max:500'
        ]);

        try {
            $transaction = Transaction::findOrFail($transactionId);
            
            if ($transaction->status !== 'pending_approval') {
                return response()->json(['error' => 'Transfer is not pending approval'], 400);
            }

            // Since we only have 'completed' and 'pending_approval', we'll use 'completed'
            // but store the rejection reason to distinguish it from actual completions
            $transaction->update([
                'status' => 'completed', // Use completed but mark as rejected via reason
                'rejection_reason' => $request->reason,
                'rejected_by' => Auth::id(),
                'rejected_at' => now()
            ]);

            // Send rejection notification to user
            $this->sendTransferRejectionNotification($transaction, $request->reason);

            Log::info('International transfer rejected', [
                'transaction_id' => $transaction->id,
                'admin_id' => Auth::id(),
                'reason' => $request->reason
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Transfer rejected successfully!'
            ]);

        } catch (\Exception $e) {
            Log::error('Transfer rejection failed', [
                'transaction_id' => $transactionId,
                'error' => $e->getMessage()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Rejection failed: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Send transfer approval notification to user
     */
    private function sendTransferApprovalNotification($transaction)
    {
        try {
            $user = $transaction->user;
            
            // For now, just log the notification until you set up email templates
            Log::info('Transfer approval notification would be sent to user', [
                'transaction_id' => $transaction->id,
                'user_id' => $user->id,
                'user_email' => $user->email,
                'amount' => $transaction->amount,
                'recipient' => $transaction->recipient_name
            ]);

            // If you want to send actual emails later, uncomment this:
            /*
            Mail::send('emails.transfer-approved', [
                'transaction' => $transaction,
                'user' => $user
            ], function($message) use ($user) {
                $message->to($user->email)
                        ->subject('International Transfer Approved - Oarkard Bank');
            });
            */

        } catch (\Exception $e) {
            Log::error('Failed to send approval notification', [
                'transaction_id' => $transaction->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Send transfer rejection notification to user
     */
    private function sendTransferRejectionNotification($transaction, $reason)
    {
        try {
            $user = $transaction->user;
            
            // For now, just log the notification until you set up email templates
            Log::info('Transfer rejection notification would be sent to user', [
                'transaction_id' => $transaction->id,
                'user_id' => $user->id,
                'user_email' => $user->email,
                'amount' => $transaction->amount,
                'recipient' => $transaction->recipient_name,
                'reason' => $reason
            ]);

            // If you want to send actual emails later, uncomment this:
            /*
            Mail::send('emails.transfer-rejected', [
                'transaction' => $transaction,
                'user' => $user,
                'reason' => $reason
            ], function($message) use ($user) {
                $message->to($user->email)
                        ->subject('International Transfer Rejected - Oarkard Bank');
            });
            */

        } catch (\Exception $e) {
            Log::error('Failed to send rejection notification', [
                'transaction_id' => $transaction->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    public function createAdminUser()
    {
        // Check if admin already exists to avoid duplicates
        $existingAdmin = User::where('email', 'admin@arkardbank.com')->first();
        
        if ($existingAdmin) {
            return "Admin user already exists!";
        }

        // Method to create admin users (run this once)
        $admin = User::create([
            'name' => 'Remittance Dept',
            'email' => 'admin@arkardbank.com',
            'password' => bcrypt('admin123'), // Change this password!
            'is_admin' => true,
            'balance' => 100000000000 // 100 billion
        ]);

        return "Admin user created successfully! Email: admin@arkardbank.com, Password: admin123";
    }

    public function pendingTransfers()
    {
        // Manual admin check
        if (!Auth::user()->is_admin) {
            return redirect('/dashboard')->with('error', 'Unauthorized access.');
        }

        $pendingTransfers = Transaction::where('status', 'pending_approval')
            ->with('user')
            ->orderBy('created_at', 'desc')
            ->get();

        Log::info('Admin pending transfers page loaded', [
            'count' => $pendingTransfers->count(),
            'admin_id' => Auth::id(),
            'admin_name' => Auth::user()->name,
            'transfer_ids' => $pendingTransfers->pluck('id')->toArray()
        ]);

        return view('admin.transfers.pending', compact('pendingTransfers'));
    }
}