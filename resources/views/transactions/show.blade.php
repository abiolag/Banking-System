@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card account-card">
                <div class="card-header">
                    <h4 class="mb-0"><i class="fas fa-receipt me-2"></i>Transaction Details</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5 class="text-success">{{ $transaction->formatted_amount }}</h5>
                            <p class="text-muted mb-0">Amount</p>
                        </div>
                        <div class="col-md-6 text-end">
                            <span class="badge bg-{{ $transaction->status == 'completed' ? 'success' : ($transaction->status == 'pending' ? 'warning' : 'danger') }} fs-6">
                                {{ ucfirst($transaction->status) }}
                            </span>
                            <p class="text-muted mb-0 mt-1">Status</p>
                        </div>
                    </div>

                    <div class="transaction-details">
                        <table class="table table-borderless">
                            <tr>
                                <td width="30%"><strong>Reference:</strong></td>
                                <td>{{ $transaction->transaction_ref }}</td>
                            </tr>
                            <tr>
                                <td><strong>Description:</strong></td>
                                <td>{{ $transaction->description }}</td>
                            </tr>
                            <tr>
                                <td><strong>Type:</strong></td>
                                <td>
                                    <span class="badge bg-info text-dark text-capitalize">
                                        {{ str_replace('_', ' ', $transaction->type) }}
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td><strong>Date & Time:</strong></td>
                                <td>{{ $transaction->created_at->format('F d, Y - h:i A') }}</td>
                            </tr>
                            <tr>
                                <td><strong>Balance Before:</strong></td>
                                <td>${{ number_format($transaction->balance_before, 2) }}</td>
                            </tr>
                            <tr>
                                <td><strong>Balance After:</strong></td>
                                <td>${{ number_format($transaction->balance_after, 2) }}</td>
                            </tr>
                            
                            @if($transaction->isTransfer() || $transaction->isWireTransfer())
                                <tr>
                                    <td colspan="2" class="pt-3"><h6>Recipient Details</h6></td>
                                </tr>
                                <tr>
                                    <td><strong>Recipient Name:</strong></td>
                                    <td>{{ $transaction->recipient_name }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Account Number:</strong></td>
                                    <td>{{ $transaction->recipient_account_number }}</td>
                                </tr>
                                <tr>
                                    <td><strong>Bank Name:</strong></td>
                                    <td>{{ $transaction->recipient_bank_name }}</td>
                                </tr>
                                @if($transaction->recipient_routing_number)
                                <tr>
                                    <td><strong>Routing Number:</strong></td>
                                    <td>{{ $transaction->recipient_routing_number }}</td>
                                </tr>
                                @endif
                                @if($transaction->swift_code)
                                <tr>
                                    <td><strong>SWIFT Code:</strong></td>
                                    <td>{{ $transaction->swift_code }}</td>
                                </tr>
                                @endif
                            @endif
                            
                            @if($transaction->narration)
                                <tr>
                                    <td><strong>Narration:</strong></td>
                                    <td>{{ $transaction->narration }}</td>
                                </tr>
                            @endif
                        </table>
                    </div>

                    <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                        <a href="{{ route('transactions') }}" class="btn btn-outline-primary">
                            <i class="fas fa-arrow-left me-1"></i>Back to Transactions
                        </a>
                        <button onclick="window.print()" class="btn btn-primary">
                            <i class="fas fa-print me-1"></i>Print Receipt
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
@media print {
    .navbar, .footer, .btn {
        display: none !important;
    }
    .card {
        border: none !important;
        box-shadow: none !important;
    }
}
</style>
@endsection