 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.layout-dashboard','data' => ['active' => 'users']]); ?>
<?php $component->withName('layout-dashboard'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['active' => 'users']); ?>
	 <?php $__env->slot('title'); ?> 
		Usuarios

		<a data-bs-toggle="tooltip" data-bs-placement="top" title="Agregar nuevo usuario" href="/dashboard/users/create" class="float-end mt-1">
			<i class="fa fa-plus"></i>
		</a>
	 <?php $__env->endSlot(); ?>

	<?php if($users->count()): ?>
		<table class="datatable table">
			<thead>
				<tr>
					<th>ID</th>
					<th>Foto</th>
					<th>Nombre</th>
					<th>Correo electrónico</th>
					<th></th>
				</tr>
			</thead>

			<tbody>
				<?php $__currentLoopData = $users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
					<tr>
						<td><?php echo e($user->id); ?></td>
						<td><img class="img-profile-list" src="<?php echo e($user->photo); ?>" alt=""></td>
						<td><?php echo e($user->name); ?></td>
						<td><?php echo e($user->email); ?></td>
						<td>
							<a data-bs-toggle="tooltip" data-bs-placement="top" title="Editar usuario" href="<?php echo e('/dashboard/users/edit/' . $user->id); ?>">
								<span class="far fa-edit"></span>
							</a>

							<a data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar usuario" class="confirm" data-text="¿Está seguro que desea eliminar este elemento?" href="<?php echo e('/dashboard/users/delete/' . $user->id); ?>">
								<i class="ms-2 fa fa-trash-alt"></i>
							</a>
						</td>
					</tr>
				<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
			</tbody>
		</table>
	<?php else: ?>
		<div class="alert alert-info">No se han registrado usuarios</div>
	<?php endif; ?>
 <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> <?php /**PATH C:\Users\Nisa Delgado\Downloads\base\vendor\nisadelgado\framework\cache/8bffd8c20f1ce585e781a8160938f965be8beb98.blade.php ENDPATH**/ ?>