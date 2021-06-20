<!DOCTYPE html>
<html lang="<?php echo e(config('language')); ?>">
<head>
<meta charset="<?php echo e(config('charset')); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title><?php echo e(config('application_name')); ?></title>
<link rel="shortcut icon" type="image/png" href="<?php echo e(asset('img/app/favicon.ico')); ?>">

<link rel="stylesheet" href="<?php echo e(node('bootstrap/dist/css/bootstrap.css')); ?>">
<link rel="stylesheet" href="<?php echo e(node('sweetalert2/dist/sweetalert2.css')); ?>">
<link rel="stylesheet" href="<?php echo e(node('@fortawesome/fontawesome-free/css/all.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>">

</head>
<body>
	<?php if(auth()): ?>
		<div class="top">
			<div class="float-end">
				<a class="me-3" href="/dashboard">Inicio</a>
				<a class="confirm me-3" data-href="/logout" data-text="¿Está seguro que desea cerrar sesión?" href="/logout">Salir</a>
			</div>
		</div>
	<?php else: ?>
		<div class="top">
			<div class="float-end">
				<a class="me-3" href="/login">Iniciar sesión</a>
				<a href="/register">Registrarse</a>
			</div>
		</div>		
	<?php endif; ?>

	<br>

	<div class="content">
		<h1 class="text-center text-center-home">
			<div class="fa fa-shapes"></div> 
			<?php echo e(config('application_name')); ?>

		</h1>
	</div>

	<script src="<?php echo e(node('jquery/dist/jquery.js')); ?>"></script>
    <script src="<?php echo e(node('bootstrap/dist/js/bootstrap.js')); ?>"></script>
    <script src="<?php echo e(node('sweetalert2/dist/sweetalert2.js')); ?>"></script>
    <script src="<?php echo e(asset('js/main.js')); ?>"></script>
</body>
</html><?php /**PATH C:\Users\Nisa Delgado\Downloads\base\vendor\nisadelgado\framework\cache/f94c2fe8f4b740316134c62e682f0ab3a57593bb.blade.php ENDPATH**/ ?>