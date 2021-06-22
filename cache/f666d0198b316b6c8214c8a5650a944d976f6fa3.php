<!DOCTYPE html>
<html lang="<?php echo e(config('language')); ?>">
<head>
	<meta charset="<?php echo e(config('charset')); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title><?php echo e(config('application_name')); ?></title>
	<link rel="shortcut icon" type="image/png" href="<?php echo e(asset('img/app/favicon.ico')); ?>">


	<link rel="stylesheet" href="<?php echo e(node('@fortawesome/fontawesome-free/css/all.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(node('bootstrap/dist/css/bootstrap.css')); ?>">
	<link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
	<link rel="stylesheet" href="<?php echo e(node('sweetalert2/dist/sweetalert2.css')); ?>">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <div class="container-fluid">
        <a class="navbar-brand" href="/dashboard">
            <b>
            	<i class="fa fa-shapes"></i> 
            	<?php echo e(config('application_name')); ?>

            </b>
        </a>
        <button aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler" data-bs-target="#navbarSupportedContent" data-bs-toggle="collapse" type="button">
            <span class="navbar-toggler-icon">
            </span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link <?php echo e(($active == 'home') ? 'active' : ''); ?>" href="/dashboard">
                        Inicio
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php echo e(($active == 'users') ? 'active' : ''); ?>" href="/dashboard/users">
                        Usuarios
                    </a>
                </li>
            </ul>
            <div class="d-flex">
            	<ul class="navbar-nav">
				    <li class="nav-item dropdown">
				        <a aria-expanded="false" class="nav-link dropdown-toggle" data-bs-toggle="dropdown" href="#" id="navbarDarkDropdownMenuLink" role="button">
				        	<img class="nav-img-profile" src="<?php echo e(auth()->photo); ?>" alt="">
				            <?php echo e(auth()->name); ?>

				        </a>
				       	<ul aria-labelledby="navbarDarkDropdownMenuLink" class="dropdown-menu dropdown">
				            <li><a class="dropdown-item" href="<?php echo e('/dashboard/users/edit/' . auth()->id); ?>">Perfil</a></li>
				            <li><a class="dropdown-item confirm" data-text="¿Está seguro que desea cerrar sesión?" href="/logout">Cerrar sesión</a></li>
				        </ul>
				    </li>
				</ul>
            </div>
        </div>
    </div>
</nav>

<div class="container mt-2 mb-5">
	<div class="row p-2">
		<div class="col-md-12">
			 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.alert','data' => []]); ?>
<?php $component->withName('alert'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?> <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> 

			<div class="card">
				<div class="card-header">
					<h3><?php echo e($title); ?></h3>
				</div>

				<div class="card-body">
					<?php echo e($slot); ?>

				</div>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo e(node('jquery/dist/jquery.js')); ?>"></script>
<script src="<?php echo e(node('bootstrap/dist/js/bootstrap.bundle.js')); ?>"></script>

<script src="<?php echo e(node('datatables.net/js/jquery.dataTables.js')); ?>"></script>
<script src="https://cdn.datatables.net/1.10.24/js/dataTables.bootstrap5.min.js"></script>

<script src="<?php echo e(node('sweetalert2/dist/sweetalert2.js')); ?>"></script>

<script src="<?php echo e(asset('js/main.js')); ?>"></script>

</body>
</html><?php /**PATH C:\Users\Nisa Delgado\Downloads\base\resources\views/components/layout-dashboard.blade.php ENDPATH**/ ?>