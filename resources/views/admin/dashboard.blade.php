<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | Oarkard Bank</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-university"></i> Oarkard Bank - Admin
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link active" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a class="nav-link" href="{{ route('admin.pending.transfers') }}">
                    <i class="fas fa-clock"></i> Pending Transfers
                </a>
                <a class="nav-link" href="{{ route('dashboard') }}">
                    <i class="fas fa-arrow-left"></i> User Dashboard
                </a>
                <a class="nav-link" href="{{ route('logout') }}" 
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Dashboard Stats -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card text-white bg-primary">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4>{{ $users->count() }}</h4>
                                <p class="mb-0">Total Users</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-users fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-warning">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4>{{ $pendingTransfers->count() }}</h4>
                                <p class="mb-0">Pending Transfers</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-clock fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card text-white bg-info">
                    <div class="card-body">
                        <div class="d-flex justify-content-between">
                            <div>
                                <h4>${{ number_format($users->sum('balance'), 2) }}</h4>
                                <p class="mb-0">Total Bank Balance</p>
                            </div>
                            <div class="align-self-center">
                                <i class="fas fa-dollar-sign fa-2x"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Pending Transfers Section -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header bg-warning text-dark">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">
                                <i class="fas fa-clock"></i> Pending Transfers for Approval
                                <span class="badge bg-danger ms-2">{{ $pendingTransfers->count() }}</span>
                            </h5>
                            <a href="{{ route('admin.pending.transfers') }}" class="btn btn-sm btn-dark">
                                View All <i class="fas fa-arrow-right"></i>
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        @if($pendingTransfers->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-sm table-hover">
                                    <thead>
                                        <tr>
                                            <th>Ref</th>
                                            <th>Amount</th>
                                            <th>User</th>
                                            <th>Recipient</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pendingTransfers->take(5) as $transfer)
                                        <tr>
                                            <td>
                                                <small class="text-muted">{{ Str::limit($transfer->transaction_ref, 10) }}</small>
                                            </td>
                                            <td>
                                                <span class="fw-bold text-success">${{ number_format($transfer->amount, 2) }}</span>
                                            </td>
                                            <td>{{ $transfer->user->name }}</td>
                                            <td>{{ $transfer->recipient_name }}</td>
                                            <td>
                                                <a href="{{ route('admin.pending.transfers') }}" class="btn btn-sm btn-outline-primary">
                                                    Review
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                @if($pendingTransfers->count() > 5)
                                    <div class="text-center mt-2">
                                        <small class="text-muted">
                                            Showing 5 of {{ $pendingTransfers->count() }} pending transfers
                                        </small>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                                <h5 class="text-success">No Pending Transfers</h5>
                                <p class="text-muted">All transfers have been processed.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Quick Actions & User Management -->
            <div class="col-md-4">
                <!-- Quick Actions -->
                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="fas fa-bolt"></i> Quick Actions</h5>
                    </div>
                    <div class="card-body">
                        <div class="d-grid gap-2">
                            <a href="{{ route('admin.pending.transfers') }}" class="btn btn-warning">
                                <i class="fas fa-clock"></i> Review Pending Transfers
                            </a>
                            <a href="{{ route('users.index') }}" class="btn btn-info">
                                <i class="fas fa-users"></i> Manage Users
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Recent Users -->
                <div class="card">
                    <div class="card-header bg-success text-white">
                        <h5 class="mb-0"><i class="fas fa-user-plus"></i> Recent Users</h5>
                    </div>
                    <div class="card-body">
                        @if($users->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach($users->take(5) as $user)
                                <div class="list-group-item d-flex justify-content-between align-items-center">
                                    <div>
                                        <h6 class="mb-1">{{ $user->name }}</h6>
                                        <small class="text-muted">{{ $user->email }}</small>
                                    </div>
                                    <span class="badge bg-primary">${{ number_format($user->balance, 2) }}</span>
                                </div>
                                @endforeach
                            </div>
                            @if($users->count() > 5)
                                <div class="text-center mt-2">
                                    <small class="text-muted">
                                        Showing 5 of {{ $users->count() }} users
                                    </small>
                                </div>
                            @endif
                        @else
                            <p class="text-muted text-center mb-0">No users found.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>