<?php $__env->startSection('title', 'Page Not Found - Oarkard'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid py-5" style="background: linear-gradient(135deg, #00D54B 0%, #00B140 100%); min-height: 100vh; display: flex; align-items: center;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 text-center text-white">
                <div class="mb-5">
                    <i class="fas fa-exclamation-triangle fa-5x mb-4" style="opacity: 0.8;"></i>
                    <h1 class="display-1 fw-bold mb-3">404</h1>
                    <h2 class="h3 mb-4">Page Not Found</h2>
                    <p class="lead mb-5" style="opacity: 0.9;">
                        The page you're looking for doesn't exist or has been moved.
                    </p>
                    
                    <div class="d-flex flex-column flex-sm-row justify-content-center gap-3">
                        <a href="<?php echo e(url('/')); ?>" class="btn btn-light btn-lg px-4 py-2">
                            <i class="fas fa-home me-2"></i>Go Home
                        </a>
                        <a href="javascript:history.back()" class="btn btn-outline-light btn-lg px-4 py-2">
                            <i class="fas fa-arrow-left me-2"></i>Go Back
                        </a>
                    </div>
                </div>
                
                <div class="mt-5" style="opacity: 0.7;">
                    <p>If you believe this is an error, please contact our support team.</p>
                    <div class="mt-3">
                        <a href="<?php echo e(url('/')); ?>" class="text-white text-decoration-underline me-3">Home</a>
                        <a href="#" class="text-white text-decoration-underline me-3">Support</a>
                        <a href="#" class="text-white text-decoration-underline">Contact</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home2/molpsgco/public_html/oarkard/resources/views/errors/404.blade.php ENDPATH**/ ?>