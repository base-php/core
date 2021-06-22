 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.layout-dashboard','data' => ['title' => 'Crear usuario','active' => 'users']]); ?>
<?php $component->withName('layout-dashboard'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes(['title' => 'Crear usuario','active' => 'users']); ?>
	<form action="/dashboard/users/store" enctype="multipart/form-data" method="POST">
		<div class="row p-2">
			<div class="col-md-4">
				<h3>Información del perfil</h3>
				<p>Asigne la foto y la dirección de correo electrónico de tu cuenta.</p>
			</div>

			<div class="col-md-8">
				<div class="card">
					<div class="card-body pe-3 ps-3">
						<div>
							<label for="photo">Foto</label>
							<div>
								<img class="img-profile img-profile-edit" src="<?php echo e(asset('img/app/user.png')); ?>" alt="">
							</div>

							<button type="button" class="btn btn-light btn-photo mt-3">Seleccione una foto</button>

							<input class="input-file" type="file" name="photo">
						</div>

						<div class="form-group mt-5">
							<label for="name">Nombre</label>
							<input type="text" class="form-control" name="name" value="<?php echo e(old('name')); ?>" required>
						</div>

						<div class="form-group mt-3">
							<label for="email">Correo electrónico</label>
							<input type="email" class="form-control" name="email" value="<?php echo e(old('email')); ?>" required>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="row p-2 mt-5">
			<div class="col-md-4">
				<h3>Contraseña</h3>
				<p>Asegure su cuenta utilizando una contraseña larga y aleatoria, luego guardela en un lugar seguro.</p>
			</div>

			<div class="col-md-8">
				<div class="card">
					<div class="card-body pe-3 ps-3">
						<div class="form-group mt-5">
							<label for="password">Contraseña</label>
							<div class="input-group">
                                <input type="password" name="password" class="form-control" required>
                                <button type="button" class="btn btn-light show-password" data-input="password">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
						</div>

						<div class="form-group mt-5">
							<div class="input-group">
                                <input type="password" name="confirm_password" class="form-control" required>
                                <button type="button" class="btn btn-light show-password" data-input="confirm_password">
                                    <i class="fa fa-eye"></i>
                                </button>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<div class="mt-5 float-end">
			<button type="submit" class="btn btn-primary">
				<i class="fa fa-save"></i> Guardar
			</button>

			<a href="/dashboard/users" class="btn btn-danger">
				<span class="fa fa-times"></span> Cancelar
			</a>
		</div>
	</form>
 <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 
<?php /**PATH C:\Users\Nisa Delgado\Downloads\base\vendor\nisadelgado\framework\cache/ef94a48e5e50fd950b628e127158746ae0cf2ef0.blade.php ENDPATH**/ ?>