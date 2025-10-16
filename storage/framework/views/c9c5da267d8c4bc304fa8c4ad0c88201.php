<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card account-card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3>Welcome back, <?php echo e($user->name); ?>!</h3>
                            <p class="text-muted">Here's your financial summary</p>
                            
                            <!-- NEW: Transfer Limits Display -->
                        <?php if($user->has_transfer_limits): ?>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <small class="text-muted">Daily Transfer Limit</small>
                                <div class="progress mb-2" style="height: 8px;">
                                    <div class="progress-bar bg-<?php echo e(($user->daily_transferred / $user->daily_limit * 100) > 80 ? 'danger' : 'warning'); ?>" 
                                        style="width: <?php echo e(min(100, ($user->daily_transferred / $user->daily_limit) * 100)); ?>%">
                                    </div>
                                </div>
                                <small>
                                    Used: $<?php echo e(number_format($user->daily_transferred, 2)); ?> of 
                                    $<?php echo e(number_format($user->daily_limit, 2)); ?>

                                </small>
                            </div>
                            <div class="col-md-6">
                                <small class="text-muted">Max per Transaction</small>
                                <div class="mt-1">
                                    <small>$<?php echo e(number_format($user->max_transaction, 2)); ?></small>
                                </div>
                            </div>
                        </div>
                        <?php else: ?>
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="alert alert-info py-2 mb-0">
                                    <small><i class="fas fa-crown me-1"></i> <strong>Admin Account:</strong> Unlimited transfer limits</small>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="balance-display"><?php echo e($user->formatted_balance); ?></div>
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
                            <td><?php echo e($user->account_number); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Routing Number:</strong></td>
                            <td><?php echo e($user->routing_number ?? '021000021'); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Account Type:</strong></td>
                            <td><?php echo e(ucfirst($user->account_type)); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Status:</strong></td>
                            <td><span class="badge bg-success"><?php echo e(ucfirst($user->status)); ?></span></td>
                        </tr>
                        <!-- NEW: Transfer Limits in Account Details -->
                        <tr>
                            <td><strong>Daily Limit:</strong></td>
                            <td>$<?php echo e(number_format($user->daily_limit, 2)); ?></td>
                        </tr>
                        <tr>
                            <td><strong>Used Today:</strong></td>
                            <td>$<?php echo e(number_format($user->daily_transferred, 2)); ?></td>
                        </tr>
                        <!-- Add this to your Account Details section -->
                        <tr>
                            <td><strong>Last Login:</strong></td>
                            <td>
                                <?php if(auth()->user()->last_activity_at): ?>
                                    <?php echo e(auth()->user()->last_activity_at->diffForHumans()); ?>

                                    <br><small class="text-muted">from <?php echo e(auth()->user()->last_login_ip); ?></small>
                                <?php else: ?>
                                    <span class="text-muted">Never</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Session Timeout:</strong></td>
                            <td><span class="badge bg-warning">30 minutes</span></td>
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
                            <a href="<?php echo e(route('transfer.create')); ?>" class="quick-action text-decoration-none">
                                <i class="fas fa-exchange-alt fa-2x mb-2"></i>
                                <div>Transfer Money</div>
                            </a>
                        </div>
                        <div class="col-6 mb-3">
                            <a href="<?php echo e(route('transactions')); ?>" class="quick-action text-decoration-none">
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
                            <a href="<?php echo e(route('profile.show')); ?>" class="quick-action text-decoration-none">
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
                    <?php if($recentTransactions->count() > 0): ?>
                        <div class="list-group list-group-flush">
                            <?php $__currentLoopData = $recentTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="list-group-item d-flex justify-content-between align-items-center">
                                <div>
                                    <h6 class="mb-1"><?php echo e($transaction->description); ?></h6>
                                    <small class="text-muted"><?php echo e($transaction->created_at->format('M d, Y - h:i A')); ?></small>
                                    <span class="badge bg-<?php echo e($transaction->status == 'completed' ? 'success' : 'warning'); ?> ms-2">
                                        <?php echo e(ucfirst($transaction->status)); ?>

                                    </span>
                                </div>
                                <div class="text-end">
                                    <strong class="<?php echo e($transaction->type == 'deposit' ? 'text-success' : 'text-danger'); ?>">
                                        <?php echo e($transaction->type == 'deposit' ? '+' : '-'); ?><?php echo e($transaction->formatted_amount); ?>

                                    </strong>
                                    <br>
                                    <small class="text-muted">Ref: <?php echo e($transaction->transaction_ref); ?></small>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="text-center mt-3">
                            <a href="<?php echo e(route('transactions')); ?>" class="btn btn-outline-primary">View All Transactions</a>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-receipt fa-3x text-muted mb-3"></i>
                            <p class="text-muted">No transactions yet. Make your first transfer to get started!</p>
                            <a href="<?php echo e(route('transfer.create')); ?>" class="btn btn-primary">Make a Transfer</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home2/molpsgco/public_html/oarkard/resources/views/dashboard.blade.php ENDPATH**/ ?>