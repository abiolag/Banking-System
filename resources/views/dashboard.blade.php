@extends('layouts.app')

@section('title', 'Dashboard - Oarkard')

@section('content')
<div class="container-fluid py-4">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3 class="mb-2">Welcome back, {{ $user->name }}! 👋</h3>
                            <p class="text-muted mb-3">Here's your financial summary</p>
                            
                            <!-- Transfer Limits -->
                            @if($user->has_transfer_limits)
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <small class="text-muted d-block mb-2">DAILY TRANSFER LIMIT</small>
                                    <div class="progress mb-2">
                                        <div class="progress-bar" 
                                             style="width: {{ min(100, ($user->daily_transferred / $user->daily_limit) * 100) }}%">
                                        </div>
                                    </div>
                                    <small class="text-muted">
                                        ${{ number_format($user->daily_transferred, 2) }} of 
                                        ${{ number_format($user->daily_limit, 2) }} used
                                    </small>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted d-block mb-2">MAX PER TRANSACTION</small>
                                    <div class="fw-bold">${{ number_format($user->max_transaction, 2) }}</div>
                                </div>
                            </div>
                            @else
                            <div class="alert alert-light border-0 mb-0 mt-3">
                                <i class="fas fa-crown text-warning me-2"></i>
                                <strong>Admin Account:</strong> Unlimited transfer limits
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

    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-number">{{ $recentTransactions->count() }}</div>
                <div class="text-muted">Recent Transactions</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-number">${{ number_format($user->daily_limit, 0) }}</div>
                <div class="text-muted">Daily Limit</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-number">{{ $user->account_number }}</div>
                <div class="text-muted">Account Number</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-number">{{ ucfirst($user->status) }}</div>
                <div class="text-muted">Account Status</div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Account Details & Quick Actions -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Account Details</span>
                    <i class="fas fa-wallet text-muted"></i>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 mb-3">
                            <small class="text-muted d-block">ACCOUNT NUMBER</small>
                            <div class="fw-bold">{{ $user->account_number }}</div>
                        </div>
                        <div class="col-6 mb-3">
                            <small class="text-muted d-block">ROUTING NUMBER</small>
                            <div class="fw-bold">{{ $user->routing_number ?? '021000021' }}</div>
                        </div>
                        <div class="col-6 mb-3">
                            <small class="text-muted d-block">ACCOUNT TYPE</small>
                            <div class="fw-bold">{{ ucfirst($user->account_type) }}</div>
                        </div>
                        <div class="col-6 mb-3">
                            <small class="text-muted d-block">LAST LOGIN</small>
                            <div class="fw-bold">
                                @if(auth()->user()->last_activity_at)
                                    {{ auth()->user()->last_activity_at->diffForHumans() }}
                                @else
                                    Never
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Quick Actions</span>
                    <i class="fas fa-bolt text-muted"></i>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-6">
                            <a href="{{ route('transfer.create') }}" class="quick-action">
                                <i class="fas fa-exchange-alt fa-2x mb-3"></i>
                                <div class="fw-bold">Transfer</div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('transactions') }}" class="quick-action">
                                <i class="fas fa-history fa-2x mb-3"></i>
                                <div class="fw-bold">History</div>
                            </a>
                        </div>
                        <div class="col-6">
                            <div class="quick-action">
                                <i class="fas fa-bill fa-2x mb-3"></i>
                                <div class="fw-bold">Pay Bills</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <a href="{{ route('profile.show') }}" class="quick-action">
                                <i class="fas fa-cog fa-2x mb-3"></i>
                                <div class="fw-bold">Settings</div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Transactions -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span>Recent Transactions</span>
                    <i class="fas fa-list text-muted"></i>
                </div>
                <div class="card-body">
                    @if($recentTransactions->count() > 0)
                        <div class="transaction-list">
                            @foreach($recentTransactions as $transaction)
                            <div class="transaction-item d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="transaction-icon me-3">
                                        <i class="fas fa-{{ $transaction->type == 'deposit' ? 'arrow-down text-success' : 'arrow-up text-danger' }} fa-lg"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold">{{ $transaction->description }}</div>
                                        <small class="text-muted">{{ $transaction->created_at->format('M d, Y') }}</small>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold {{ $transaction->type == 'deposit' ? 'text-success' : 'text-danger' }}">
                                        {{ $transaction->type == 'deposit' ? '+' : '-' }}{{ $transaction->formatted_amount }}
                                    </div>
                                    <small class="text-muted">{{ $transaction->status }}</small>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        <div class="text-center mt-4">
                            <a href="{{ route('transactions') }}" class="btn btn-outline-primary">View All Transactions</a>
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-receipt fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-3">No transactions yet</p>
                            <a href="{{ route('transfer.create') }}" class="btn btn-primary">Make Your First Transfer</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection