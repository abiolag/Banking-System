@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card account-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3>Transaction History</h3>
                            <p class="text-muted">View your account transactions and transfers</p>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="balance-display">{{ $user->formatted_balance }}</div>
                            <small class="text-muted">Current Balance</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="card account-card mb-4">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filter Transactions</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('transactions.filter') }}" method="GET">
                <div class="row">
                    <div class="col-md-3">
                        <label for="type" class="form-label">Transaction Type</label>
                        <select class="form-control" id="type" name="type">
                            <option value="all">All Types</option>
                            <option value="transfer">Transfers</option>
                            <option value="deposit">Deposits</option>
                            <option value="withdrawal">Withdrawals</option>
                            <option value="wire_transfer">Wire Transfers</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-control" id="status" name="status">
                            <option value="all">All Statuses</option>
                            <option value="completed">Completed</option>
                            <option value="pending">Pending</option>
                            <option value="failed">Failed</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date">
                    </div>
                    <div class="col-md-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date">
                    </div>
                </div>
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary">Apply Filters</button>
                    <a href="{{ route('transactions') }}" class="btn btn-outline-secondary">Clear Filters</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Transactions List -->
    <div class="card account-card">
        <div class="card-header">
            <h5 class="mb-0"><i class="fas fa-list me-2"></i>Recent Transactions</h5>
        </div>
        <div class="card-body">
            @if($transactions->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Description</th>
                                <th>Type</th>
                                <th>Amount</th>
                                <th>Status</th>
                                <th>Reference</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->created_at->format('M d, Y') }}</td>
                                <td>
                                    <div class="fw-bold">{{ $transaction->description }}</div>
                                    @if($transaction->narration)
                                        <small class="text-muted">{{ $transaction->narration }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="badge bg-info text-dark text-capitalize">
                                        {{ str_replace('_', ' ', $transaction->type) }}
                                    </span>
                                </td>
                                <td class="{{ $transaction->type == 'deposit' ? 'text-success' : 'text-danger' }} fw-bold">
                                    {{ $transaction->type == 'deposit' ? '+' : '-' }}{{ $transaction->formatted_amount }}
                                </td>
                                <td>
                                    <span class="badge bg-{{ $transaction->status == 'completed' ? 'success' : ($transaction->status == 'pending' ? 'warning' : 'danger') }}">
                                        {{ ucfirst($transaction->status) }}
                                    </span>
                                </td>
                                <td>
                                    <small class="text-muted">{{ $transaction->transaction_ref }}</small>
                                </td>
                                <td>
                                    <a href="{{ route('transactions.show', $transaction->id) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="d-flex justify-content-center mt-4">
                    {{ $transactions->links() }}
                </div>
            @else
                <div class="text-center py-5">
                    <i class="fas fa-receipt fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">No Transactions Found</h4>
                    <p class="text-muted">You haven't made any transactions yet.</p>
                    <a href="{{ route('transfer.create') }}" class="btn btn-primary">Make Your First Transfer</a>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection