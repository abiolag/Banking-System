@extends('layouts.email')

@section('content')
<h2>International Transfer Submitted</h2>
<p>Hello {{ $user->name }},</p>

<p>Your international transfer has been submitted and is <strong>pending admin approval</strong>.</p>

<div style="background: #f8f9fa; padding: 15px; border-radius: 5px; margin: 20px 0;">
    <h3 style="margin: 0 0 10px 0; color: #333;">Transfer Details</h3>
    <p><strong>Reference:</strong> {{ $transaction->transaction_ref }}</p>
    <p><strong>Amount:</strong> ${{ number_format($transaction->amount, 2) }}</p>
    <p><strong>Recipient:</strong> {{ $transaction->recipient_name }}</p>
    <p><strong>Bank:</strong> {{ $transaction->bank_name }}, {{ $transaction->bank_country }}</p>
    <p><strong>Account:</strong> {{ $transaction->iban }}</p>
</div>

<p>Your transfer is now in the approval queue and will be processed shortly. You will receive another email once it's approved or if additional information is required.</p>

<p><strong>Note:</strong> No funds have been deducted from your account yet. The amount will be deducted once the transfer is approved.</p>

<p>Thank you for banking with Oarkard Bank!</p>
@endsection