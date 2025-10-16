<?php $__env->startSection('content'); ?>
<div class="container py-4">
    <div class="row">
        <div class="col-12">
            <div class="card account-card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0"><i class="fas fa-users me-2"></i>Arkard Bank Users</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>
                        Use these account details to test transfers between Arkard Bank users.
                    </div>
                    
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Account Number</th>
                                    <th>Account Type</th>
                                    <th>Routing Number</th>
                                    <th>Bank Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($user->name); ?></td>
                                    <td><code><?php echo e($user->account_number); ?></code></td>
                                    <td><?php echo e(ucfirst($user->account_type)); ?></td>
                                    <td><code>021000021</code></td>
                                    <td>Arkard Bank</td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-3">
                        <a href="<?php echo e(route('transfer.create')); ?>" class="btn btn-primary">
                            <i class="fas fa-exchange-alt me-2"></i>Make a Transfer
                        </a>
                        <a href="<?php echo e(route('dashboard')); ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Dashboard
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home2/molpsgco/public_html/oarkard/resources/views/users/index.blade.php ENDPATH**/ ?>