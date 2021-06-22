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
</head>
<body>
    <?php echo e($slot); ?>


    <script src="<?php echo e(node('jquery/dist/jquery.js')); ?>"></script>
    <script src="<?php echo e(node('bootstrap/dist/js/bootstrap.js')); ?>"></script>
    <script src="<?php echo e(asset('js/main.js')); ?>"></script>
</body>
</html><?php /**PATH C:\Users\Nisa Delgado\Downloads\base\resources\views/components/layout-auth.blade.php ENDPATH**/ ?>