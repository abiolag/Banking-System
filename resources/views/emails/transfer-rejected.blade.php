@extends('layouts.email')

@section('content')
<h2>International Transfer Rejected</h2>
<p>Hello {{ $user->name }},</p>

<p>Your international transfer has been <strong>rejected</strong>.</p>

<div style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0;">
    <h3 style="margin: 0 0 10px 0; color: #333;">Transfer Details</h3>
    <p><strong>Reference:</strong> {{ $transaction->transaction_ref }}</p>
    <p><strong>Amount:</strong> ${{ number_format($transaction->amount, 2) }}</p>
    <p><strong>Recipient:</strong> {{ $transaction->recipient_name }}</p>
    <p><strong>Bank:</strong> {{ $transaction->bank_name }}, {{ $transaction->bank_country }}</p>
</div>

<div style="background: #fff3cd; padding: 15px; border-radius: 5px; margin: 20px 0;">
    <h4 style="margin: 0 0 10px 0; color: #856404;">Reason for Rejection</h4>
    <p style="margin: 0; color: #856404;">{{ $reason }}</p>
</div>

<p>No funds have been deducted from your account. If you believe this is an error, please contact our support team.</p>

<p>Thank you for banking with Oarkard Bank!</p>
@endsection