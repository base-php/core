<?php if(errors()): ?>
	<div class="alert alert-danger">
		<?php $__currentLoopData = errors(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
			<li><?php echo e(error($error)); ?></li>
		<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
	</div>
<?php else: ?>
	<?php if(messages('error')): ?>
	    <div class="alert alert-danger text-center"><?php echo e(message('error')); ?></div>
	<?php endif; ?>

	<?php if(messages('info')): ?>
	    <div class="alert alert-success text-center"><?php echo e(message('info')); ?></div>
	<?php endif; ?>
<?php endif; ?><?php /**PATH C:\Users\Nisa Delgado\Downloads\base\resources\views/components/alert.blade.php ENDPATH**/ ?>