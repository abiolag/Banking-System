<?php $__env->startSection('content'); ?>
<?php
    // Additional security check in the view
    if (Auth::id() !== $transaction->user_id) {
        abort(403, 'Unauthorized access.');
    }
?>

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
                                <td><?php echo e($transaction->transaction_ref); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Amount:</strong></td>
                                <td><?php echo e($transaction->formatted_amount); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Recipient:</strong></td>
                                <td><?php echo e($transaction->recipient_name); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Bank:</strong></td>
                                <td><?php echo e($transaction->recipient_bank_name ?? 'Oarkard Bank'); ?></td>
                            </tr>
                            <tr>
                                <td><strong>Date:</strong></td>
                                <td><?php echo e($transaction->created_at->format('M d, Y - h:i A')); ?></td>
                            </tr>
                        </table>
                    </div>

                    <div class="d-grid gap-2 d-md-block">
                        <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-primary me-2">
                            <i class="fas fa-home me-1"></i>Back to Dashboard
                        </a>
                        <a href="<?php echo e(route('transfer.create')); ?>" class="btn btn-outline-primary">
                            <i class="fas fa-exchange-alt me-1"></i>New Transfer
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\ilesa\Herd\Banking-System\resources\views/transfer/success.blade.php ENDPATH**/ ?>