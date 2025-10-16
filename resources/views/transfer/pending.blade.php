<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Transfers - Admin | Oarkard Bank</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
        }
        .badge-pending {
            background-color: #ffc107;
            color: #000;
        }
        .transfer-row:hover {
            background-color: #f8f9fa;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <i class="fas fa-university"></i> Oarkard Bank - Admin
            </a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="{{ route('admin.dashboard') }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a class="nav-link active" href="{{ route('admin.pending.transfers') }}">
                    <i class="fas fa-clock"></i> Pending Transfers
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
        <div class="row">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1>
                        <i class="fas fa-clock text-warning"></i> 
                        Pending Transfers for Approval
                    </h1>
                    <span class="badge bg-primary fs-6">Total: {{ $pendingTransfers->count() }}</span>
                </div>

                <!-- Debug Information -->
                <div class="alert alert-info mb-4">
                    <h5><i class="fas fa-info-circle"></i> Debug Information</h5>
                    <div class="row">
                        <div class="col-md-6">
                            <strong>Admin:</strong> {{ auth()->user()->name }}<br>
                            <strong>Admin ID:</strong> {{ auth()->id() }}<br>
                            <strong>Is Admin:</strong> <span class="badge bg-success">Yes</span>
                        </div>
                        <div class="col-md-6">
                            <strong>Pending Count:</strong> {{ $pendingTransfers->count() }}<br>
                            <strong>Page Loaded:</strong> {{ now()->format('M j, Y g:i A') }}
                        </div>
                    </div>
                </div>

                @if($pendingTransfers->count() > 0)
                    <div class="card">
                        <div class="card-header bg-warning text-dark">
                            <h5 class="mb-0">
                                <i class="fas fa-exclamation-triangle"></i>
                                {{ $pendingTransfers->count() }} Transfers Awaiting Approval
                            </h5>
                        </div>
                        <div class="card-body p-0">
                            <div class="table-responsive">
                                <table class="table table-hover table-striped mb-0">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>ID</th>
                                            <th>Reference</th>
                                            <th>Amount</th>
                                            <th>User</th>
                                            <th>Type</th>
                                            <th>Recipient</th>
                                            <th>Created</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pendingTransfers as $transfer)
                                        <tr class="transfer-row">
                                            <td><strong>#{{ $transfer->id }}</strong></td>
                                            <td>
                                                <small class="text-muted">{{ $transfer->transaction_ref }}</small>
                                            </td>
                                            <td>
                                                <span class="fw-bold text-success">
                                                    ${{ number_format($transfer->amount, 2) }}
                                                </span>
                                            </td>
                                            <td>
                                                {{ $transfer->user->name }}<br>
                                                <small class="text-muted">{{ $transfer->user->email }}</small>
                                            </td>
                                            <td>
                                                <span class="badge bg-info text-capitalize">
                                                    {{ $transfer->transfer_type }}
                                                </span>
                                            </td>
                                            <td>
                                                {{ $transfer->recipient_name }}<br>
                                                <small class="text-muted">{{ $transfer->recipient_account_number }}</small>
                                            </td>
                                            <td>
                                                {{ $transfer->created_at->format('M j, Y') }}<br>
                                                <small class="text-muted">{{ $transfer->created_at->format('g:i A') }}</small>
                                            </td>
                                            <td>
                                                <span class="badge badge-pending">
                                                    <i class="fas fa-clock"></i> {{ $transfer->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm">
                                                    <button class="btn btn-success approve-btn" 
                                                            data-transfer-id="{{ $transfer->id }}"
                                                            data-transfer-ref="{{ $transfer->transaction_ref }}">
                                                        <i class="fas fa-check"></i> Approve
                                                    </button>
                                                    <button class="btn btn-danger reject-btn" 
                                                            data-transfer-id="{{ $transfer->id }}"
                                                            data-transfer-ref="{{ $transfer->transaction_ref }}">
                                                        <i class="fas fa-times"></i> Reject
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card">
                        <div class="card-body text-center py-5">
                            <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                            <h3 class="text-success">No Pending Transfers</h3>
                            <p class="text-muted">All transfers have been processed. Great job!</p>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-primary">
                                <i class="fas fa-tachometer-alt"></i> Back to Dashboard
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Reject Modal -->
    <div class="modal fade" id="rejectModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Reject Transfer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>You are about to reject transfer: <strong id="reject-transfer-ref"></strong></p>
                    <form id="reject-form">
                        @csrf
                        <input type="hidden" name="transfer_id" id="reject-transfer-id">
                        <div class="mb-3">
                            <label for="rejection-reason" class="form-label">Reason for rejection:</label>
                            <textarea class="form-control" id="rejection-reason" name="reason" rows="3" required 
                                      placeholder="Please provide a reason for rejecting this transfer..."></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirm-reject">Reject Transfer</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Approve buttons
            document.querySelectorAll('.approve-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const transferId = this.dataset.transferId;
                    const transferRef = this.dataset.transferRef;
                    
                    if (confirm(`Are you sure you want to approve transfer ${transferRef}?`)) {
                        approveTransfer(transferId);
                    }
                });
            });

            // Reject buttons
            document.querySelectorAll('.reject-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const transferId = this.dataset.transferId;
                    const transferRef = this.dataset.transferRef;
                    
                    document.getElementById('reject-transfer-id').value = transferId;
                    document.getElementById('reject-transfer-ref').textContent = transferRef;
                    
                    const modal = new bootstrap.Modal(document.getElementById('rejectModal'));
                    modal.show();
                });
            });

            // Confirm reject
            document.getElementById('confirm-reject').addEventListener('click', function() {
                const transferId = document.getElementById('reject-transfer-id').value;
                const reason = document.getElementById('rejection-reason').value;
                
                if (!reason.trim()) {
                    alert('Please provide a reason for rejection.');
                    return;
                }
                
                rejectTransfer(transferId, reason);
            });

            function approveTransfer(transferId) {
                const button = document.querySelector(`.approve-btn[data-transfer-id="${transferId}"]`);
                button.disabled = true;
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Approving...';

                fetch(`/admin/transfers/${transferId}/approve`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Transfer approved successfully!');
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                        button.disabled = false;
                        button.innerHTML = '<i class="fas fa-check"></i> Approve';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while approving the transfer.');
                    button.disabled = false;
                    button.innerHTML = '<i class="fas fa-check"></i> Approve';
                });
            }

            function rejectTransfer(transferId, reason) {
                const button = document.querySelector(`.reject-btn[data-transfer-id="${transferId}"]`);
                button.disabled = true;
                button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Rejecting...';

                fetch(`/admin/transfers/${transferId}/reject`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ reason: reason })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Transfer rejected successfully!');
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                        button.disabled = false;
                        button.innerHTML = '<i class="fas fa-times"></i> Reject';
                    bootstrap.Modal.getInstance(document.getElementById('rejectModal')).hide();
                    document.getElementById('rejection-reason').value = '';
                    document.getElementById('reject-transfer-id').value = '';
                    document.getElementById('reject-transfer-ref').textContent = '';
                }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred while rejecting the transfer.');
                    button.disabled = false;
                    button.innerHTML = '<i class="fas fa-times"></i> Reject';
                    bootstrap.Modal.getInstance(document.getElementById('rejectModal')).hide();
                    document.getElementById('rejection-reason').value = '';
                    document.getElementById('reject-transfer-id').value = '';
                    document.getElementById('reject-transfer-ref').textContent = '';
                });
            }
        });
    </script>
</body>
</html>