@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card account-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3>Welcome back, {{ $user->name }}!</h3>
                            <p class="text-muted">Here's your financial summary</p>
                            
                            <!-- NEW: Transfer Limits Display -->
                        @if($user->has_transfer_limits)
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <small class="text-muted">Daily Transfer Limit</small>
                                <div class="progress mb-2" style="height: 8px;">
                                    <div class="progress-bar bg-{{ ($user->daily_transferred / $user->daily_limit * 100) > 80 ? 'danger' : 'warning' }}" 
                                        style="width: {{ min(100, ($user->daily_transferred / $user->daily_limit) * 100) }}%">
                                    </div>
                                </div>
                                <small>
                                    Used: ${{ number_format($user->daily_transferred, 2) }} of 
                                    ${{ number_format($user->daily_limit, 2) }}
                                </small>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted">Max per Transaction</small>
                                <div class="mt-1">
                                    <small>${{ number_format($user->max_transaction, 2) }}</small>
                                </div>
                            </div>
                        </div>
                        @else
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="alert alert-info py-2 mb-0">
                                    <small><i class="fas fa-crown me-1"></i> <strong>Admin Account:</strong> Unlimited transfer limits</small>
                                </div>
                            </div>
                        </div>
                        @endif
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="balance-display">{{ $user->formatted_balance }}</div>
                            <small class="text-muted">Available Balance</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Account Details -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card account-card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="fas fa-wallet me-2"></i>Account Details</h5>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td><strong>Account Number:</strong></td>
                            <td>{{ $user->account_number }}</td>
                        </tr>
                        <tr>
                            <td><strong>Routing Number:</strong></td>
                            <td>{{ $user->routing_number ?? '021000021' }}</td>
                        </tr>
                        <tr>
                            <td><strong>Account Type:</strong></td>
                            <td>{{ ucfirst($user->account_type) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td><span class="badge bg-success">{{ ucfirst($user->status) }}</span></td>
                        </tr>
                        <!-- NEW: Transfer Limits in Account Details -->
                        <tr>
                            <td><strong>Daily Limit:</strong></td>
                            <td>${{ number_format($user->daily_limit, 2) }}</td>
                        </tr>
                        <tr>
                            <td><strong>Used Today:</strong></td>
                            <td>${{ number_format($user->daily_transferred, 2) }}</td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card account-card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0"><i class="fas fa-bolt me-2"></i>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6 mb-3">
                            <a href="{{ route('transfer.create') }}" class="quick-action text-decoration-none">
                                <i class="fas fa-exchange-alt fa-2x mb-2"></i>
                                <div>Transfer Money</div>
                            </a>
                        </div>
                        <div class="col-6 mb-3">
                            <a href="{{ route('transactions') }}" class="quick-action text-decoration-none">
                                <i class="fas fa-history fa-2x mb-2"></i>
                                <div>Transaction History</div>
                            </a>
                        </div>
                        <div class="col-6">
                            <div class="quick-action">
                                <i class="fas fa-bill fa-2x mb-2"></i>
                                <div>Pay Bills</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('profile.show') }}" class="quick-action text-decoration-none">
                                <i class="fas fa-cog fa-2x mb-2"></i>
                                <div>Account Settings</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="row">
        <div class="col-12">
            <div class="card account-card">
                <div class="card-header">
                    <h5 class="mb-0"><i class="fas fa-list me-2"></i>Recent Transactions</h5>
                </div>
                <div class="card-body">
                    @if($recentTransactions->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($recentTransactions as $transaction)
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1">{{ $transaction->description }}</h6>
                                    <small class="text-muted">{{ $transaction->created_at->format('M d, Y - h:i A') }}</small>
                                    <span class="badge bg-{{ $transaction->status == 'completed' ? 'success' : 'warning' }} ms-2">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                </div>
                                <div class="text-end">
                                    <strong class="{{ $transaction->type == 'deposit' ? 'text-success' : 'text-danger' }}">
                                        {{ $transaction->type == 'deposit' ? '+' : '-' }}{{ $transaction->formatted_amount }}
                                    </strong>
                                    <br>
                                    <small class="text-muted">Ref: {{ $transaction->transaction_ref }}</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="text-center mt-3">
                            <a href="{{ route('transactions') }}" class="btn btn-outline-primary">View All Transactions</a>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-receipt fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No transactions yet. Make your first transfer to get started!</p>
                            <a href="{{ route('transfer.create') }}" class="btn btn-primary">Make a Transfer</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection