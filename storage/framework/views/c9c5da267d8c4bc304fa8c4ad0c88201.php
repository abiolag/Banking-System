<?php $__env->startSection('title', 'Dashboard - Oarkard'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-4">
    <!-- Welcome Section -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h3 class="mb-2">Welcome back, <?php echo e($user->name); ?>! 👋</h3>
                            <p class="text-muted mb-3">Here's your financial summary</p>
                            
                            <!-- Transfer Limits -->
                            <?php if($user->has_transfer_limits): ?>
                            <div class="row mt-4">
                                <div class="col-md-6">
                                    <small class="text-muted d-block mb-2">DAILY TRANSFER LIMIT</small>
                                    <div class="progress mb-2">
                                        <div class="progress-bar" 
                                             style="width: <?php echo e(min(100, ($user->daily_transferred / $user->daily_limit) * 100)); ?>%">
                                        </div>
                                    </div>
                                    <small class="text-muted">
                                        $<?php echo e(number_format($user->daily_transferred, 2)); ?> of 
                                        $<?php echo e(number_format($user->daily_limit, 2)); ?> used
                                    </small>
                                </div>
                                <div class="col-md-6">
                                    <small class="text-muted d-block mb-2">MAX PER TRANSACTION</small>
                                    <div class="fw-bold">$<?php echo e(number_format($user->max_transaction, 2)); ?></div>
                                </div>
                            </div>
                            <?php else: ?>
                            <div class="alert alert-light border-0 mb-0 mt-3">
                                <i class="fas fa-crown text-warning me-2"></i>
                                <strong>Admin Account:</strong> Unlimited transfer limits
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

    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-number"><?php echo e($recentTransactions->count()); ?></div>
                <div class="text-muted">Recent Transactions</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-number">$<?php echo e(number_format($user->daily_limit, 0)); ?></div>
                <div class="text-muted">Daily Limit</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-number"><?php echo e($user->account_number); ?></div>
                <div class="text-muted">Account Number</div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="stat-card">
                <div class="stat-number"><?php echo e(ucfirst($user->status)); ?></div>
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
                            <div class="fw-bold"><?php echo e($user->account_number); ?></div>
                        </div>
                        <div class="col-6 mb-3">
                            <small class="text-muted d-block">ROUTING NUMBER</small>
                            <div class="fw-bold"><?php echo e($user->routing_number ?? '021000021'); ?></div>
                        </div>
                        <div class="col-6 mb-3">
                            <small class="text-muted d-block">ACCOUNT TYPE</small>
                            <div class="fw-bold"><?php echo e(ucfirst($user->account_type)); ?></div>
                        </div>
                        <div class="col-6 mb-3">
                            <small class="text-muted d-block">LAST LOGIN</small>
                            <div class="fw-bold">
                                <?php if(auth()->user()->last_activity_at): ?>
                                    <?php echo e(auth()->user()->last_activity_at->diffForHumans()); ?>

                                <?php else: ?>
                                    Never
                                <?php endif; ?>
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
                            <a href="<?php echo e(route('transfer.create')); ?>" class="quick-action">
                                <i class="fas fa-exchange-alt fa-2x mb-3"></i>
                                <div class="fw-bold">Transfer</div>
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="<?php echo e(route('transactions')); ?>" class="quick-action">
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
                            <a href="<?php echo e(route('profile.show')); ?>" class="quick-action">
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
                    <?php if($recentTransactions->count() > 0): ?>
                        <div class="transaction-list">
                            <?php $__currentLoopData = $recentTransactions; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $transaction): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="transaction-item d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <div class="transaction-icon me-3">
                                        <i class="fas fa-<?php echo e($transaction->type == 'deposit' ? 'arrow-down text-success' : 'arrow-up text-danger'); ?> fa-lg"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold"><?php echo e($transaction->description); ?></div>
                                        <small class="text-muted"><?php echo e($transaction->created_at->format('M d, Y')); ?></small>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <div class="fw-bold <?php echo e($transaction->type == 'deposit' ? 'text-success' : 'text-danger'); ?>">
                                        <?php echo e($transaction->type == 'deposit' ? '+' : '-'); ?><?php echo e($transaction->formatted_amount); ?>

                                    </div>
                                    <small class="text-muted"><?php echo e($transaction->status); ?></small>
                                </div>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                        <div class="text-center mt-4">
                            <a href="<?php echo e(route('transactions')); ?>" class="btn btn-outline-primary">View All Transactions</a>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-receipt fa-3x text-muted mb-3"></i>
                            <p class="text-muted mb-3">No transactions yet</p>
                            <a href="<?php echo e(route('transfer.create')); ?>" class="btn btn-primary">Make Your First Transfer</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home2/molpsgco/public_html/oarkard/resources/views/dashboard.blade.php ENDPATH**/ ?>