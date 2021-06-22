 <?php if (isset($component)) { $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4 = $component; } ?>
<?php $component = $__env->getContainer()->make(Illuminate\View\AnonymousComponent::class, ['view' => 'components.layout-auth','data' => []]); ?>
<?php $component->withName('layout-auth'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
    <div class="container">
        <div class="row row-login d-flex justify-content-center">
            <div class="col-md-5">
                <h2 class="text-center">
                    <i class="fa fa-shapes"></i> 
                    <?php echo e(config('application_name')); ?>

                </h2>

                <div class="card card-auth mt-5">
                    <div class="card-body">
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

                        <form action="/login" method="POST">
                            <div class="mb-3 mt-3">
                                <label for="email">Correo electrónico</label>
                                <input type="text" name="email" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label for="password">Contraseña</label>
                                <div class="input-group">
                                    <input type="password" name="password" class="form-control" required>
                                    <button type="button" class="btn btn-light show-password" data-input="password">
                                        <i class="fa fa-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <div class="mb-3">
                                <input type="checkbox"> Recuérdame
                            </div>

                            <div>
                                <button class="btn btn-primary float-end" type="submit">
                                    <i class="fas fa-sign-in-alt"></i> Iniciar sesión
                                </button>
                                <a href="/forgot-password" class="float-end me-3">¿Olvidaste tu contraseña?</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
 <?php if (isset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4)): ?>
<?php $component = $__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4; ?>
<?php unset($__componentOriginalc254754b9d5db91d5165876f9d051922ca0066f4); ?>
<?php endif; ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?> <?php /**PATH C:\Users\Nisa Delgado\Downloads\base\vendor\nisadelgado\framework\cache/a405fdbc3e5dbfcd009e24f69b16e16e3819d54a.blade.php ENDPATH**/ ?>