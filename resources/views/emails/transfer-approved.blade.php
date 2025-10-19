@extends('layouts.email')

@section('content')
<h2>International Transfer Approved</h2>
<p>Hello {{ $user->name }},</p>

<p>Your international transfer has been <strong>approved</strong> and processed successfully.</p>

<div style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0;">
    <h3 style="margin: 0 0 10px 0; color: #333;">Transfer Details</h3>
    <p><strong>Reference:</strong> {{ $transaction->transaction_ref }}</p>
    <p><strong>Amount:</strong> ${{ number_format($transaction->amount, 2) }}</p>
    <p><strong>Recipient:</strong> {{ $transaction->recipient_name }}</p>
    <p><strong>Bank:</strong> {{ $transaction->bank_name }}, {{ $transaction->bank_country }}</p>
    <p><strong>Account:</strong> {{ $transaction->iban }}</p>
</div>

<p>The funds have been deducted from your account and the transfer is being processed.</p>

<p>Thank you for banking with Oarkard Bank!</p>
@endsection