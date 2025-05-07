<?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>
<?php if(session()->has('message')): ?>
    <div class="alert alert-success alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
        <?php echo e(session()->get('message')); ?>

    </div>
<?php endif; ?>
<div class="alert alert-danger savedisabled" style="display: none">
    <ul>
        <li>To edit this record, go to edit screen</li>
    </ul>
</div>
<?php /**PATH D:\xampp\htdocs\village\resources\views/common/error.blade.php ENDPATH**/ ?>