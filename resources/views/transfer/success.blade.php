@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card account-card">
                <div class="card-body text-center py-5">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                    </div>
                    <h2 class="text-success mb-3">Transfer Successful!</h2>
                    <p class="lead">Your transfer has been processed successfully.</p>

                    <div class="alert alert-light text-start mb-4">
                        <h6>Transaction Details:</h6>
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>Reference:</strong></td>
                                <td>{{ $transaction->transaction_ref }}</td>
                            </tr>
                            <tr>
                                <td><strong>Amount:</strong></td>
                                <td>{{ $transaction->formatted_amount }}</td>
                            </tr>
                            <tr>
                                <td><strong>Recipient:</strong></td>
                                <td>{{ $transaction->recipient_name }}</td>
                            </tr>
                            <tr>
                                <td><strong>Bank:</strong></td>
                                <td>{{ $transaction->recipient_bank_name ?? 'Oarkard Bank' }}</td>
                            </tr>
                            <tr>
                                <td><strong>Date:</strong></td>
                                <td>{{ $transaction->created_at->format('M d, Y - h:i A') }}</td>
                            </tr>
                        </table>
                    </div>

                    <div class="d-grid gap-2 d-md-block">
                        <a href="{{ route('dashboard') }}" class="btn btn-primary me-2">
                            <i class="fas fa-home me-1"></i>Back to Dashboard
                        </a>
                        <a href="{{ route('transfer.create') }}" class="btn btn-outline-primary">
                            <i class="fas fa-exchange-alt me-1"></i>New Transfer
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
