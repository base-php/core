<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputOption;

class AuthInstall extends Command
{
    protected static $defaultName = 'auth:install';

    protected static $defaultDescription = 'Instala los controladores y recursos de autenticación';

    public function configure()
    {
        $this->addOption('bootstrap', null, InputOption::VALUE_NONE, 'Autenticación con Bootstrap');
        $this->addOption('tailwind', null, InputOption::VALUE_NONE, 'Autenticación con Tailwind');
    }

    protected function execute($input, $output)
    {
        $frontend = $input->getOption('bootstrap') ? 'bootstrap' : 'tailwind';

        copy('vendor/base-php/core/auth/controllers/AuthController.php', 'app/Controllers/AuthController.php');
        copy('vendor/base-php/core/auth/controllers/DashboardController.php', 'app/Controllers/DashboardController.php');
        copy('vendor/base-php/core/auth/controllers/UserController.php', 'app/Controllers/UserController.php');

        if (! file_exists('app/Mails')) {
            mkdir('app/Mails');
        }

        copy('vendor/base-php/core/auth/mails/PasswordRecoveryEmail.php', 'app/Mails/PasswordRecoveryEmail.php');
        copy('vendor/base-php/core/auth/mails/VerifiedEmail.php', 'app/Mails/VerifiedEmail.php');

        if (! file_exists('app/Middleware')) {
            mkdir('app/Middleware');
        }

        copy('vendor/base-php/core/auth/middleware/Auth.php', 'app/Middleware/Auth.php');
        copy('vendor/base-php/core/auth/middleware/Permission.php', 'app/Middleware/Permission.php');

        if (! file_exists('app/Validations')) {
            mkdir('app/Validations');
        }

        copy('vendor/base-php/core/auth/validations/UserStoreValidation.php', 'app/Validations/UserStoreValidation.php');
        copy('vendor/base-php/core/auth/validations/UserUpdateValidation.php', 'app/Validations/UserUpdateValidation.php');

        copy('vendor/base-php/core/auth/css/auth.css', 'resources/assets/css/auth.css');
        copy('vendor/base-php/core/auth/css/dashboard.css', 'resources/assets/css/dashboard.css');

        copy('vendor/base-php/core/auth/img/user.png', 'resources/assets/img/user.png');

        if (! file_exists('resources/assets/js')) {
            mkdir('resources/assets/js');
        }

        copy('vendor/base-php/core/auth/js/main.js', 'resources/assets/js/main.js');

        copy('vendor/base-php/core/auth/lang/auth.php', 'resources/lang/es/auth.php');
        copy('vendor/base-php/core/auth/lang/dashboard.php', 'resources/lang/es/dashboard.php');
        copy('vendor/base-php/core/auth/lang/pagination.php', 'resources/lang/es/pagination.php');
        copy('vendor/base-php/core/auth/lang/users.php', 'resources/lang/es/users.php');
        copy('vendor/base-php/core/auth/lang/validations.php', 'resources/lang/es/validations.php');

        if (! file_exists('resources/views/auth')) {
            mkdir('resources/views/auth');
        }

        if (! file_exists('resources/views/components')) {
            mkdir('resources/views/components');
        }

        if (! file_exists('resources/views/dashboard')) {
            mkdir('resources/views/dashboard');
        }

        if (! file_exists('resources/views/users')) {
            mkdir('resources/views/users');
        }

        if (! file_exists('resources/views/mails')) {
            mkdir('resources/views/mails');
        }

        copy('vendor/base-php/core/auth/views/' . $frontend . '/mails/recover.blade.php', 'resources/views/mails/recover.blade.php');
        copy('vendor/base-php/core/auth/views/' . $frontend . '/mails/verified-email.blade.php', 'resources/views/mails/verified-email.blade.php');

        copy('vendor/base-php/core/auth/views/' . $frontend . '/auth/2fa.blade.php', 'resources/views/auth/2fa.blade.php');
        copy('vendor/base-php/core/auth/views/' . $frontend . '/auth/forgot-password.blade.php', 'resources/views/auth/forgot-password.blade.php');
        copy('vendor/base-php/core/auth/views/' . $frontend . '/auth/login.blade.php', 'resources/views/auth/login.blade.php');
        copy('vendor/base-php/core/auth/views/' . $frontend . '/auth/recover.blade.php', 'resources/views/auth/recover.blade.php');
        copy('vendor/base-php/core/auth/views/' . $frontend . '/auth/register.blade.php', 'resources/views/auth/register.blade.php');

        copy('vendor/base-php/core/auth/views/' . $frontend . '/components/alert.blade.php', 'resources/views/components/alert.blade.php');
        copy('vendor/base-php/core/auth/views/' . $frontend . '/components/button.blade.php', 'resources/views/components/button.blade.php');
        copy('vendor/base-php/core/auth/views/' . $frontend . '/components/button-link.blade.php', 'resources/views/components/button-link.blade.php');
        copy('vendor/base-php/core/auth/views/' . $frontend . '/components/file-button.blade.php', 'resources/views/components/file-button.blade.php');
        copy('vendor/base-php/core/auth/views/' . $frontend . '/components/input.blade.php', 'resources/views/components/input.blade.php');
        copy('vendor/base-php/core/auth/views/' . $frontend . '/components/label.blade.php', 'resources/views/components/label.blade.php');
        copy('vendor/base-php/core/auth/views/' . $frontend . '/components/social-button.blade.php', 'resources/views/components/social-button.blade.php');
        copy('vendor/base-php/core/auth/views/' . $frontend . '/components/template-auth.blade.php', 'resources/views/components/template-auth.blade.php');
        copy('vendor/base-php/core/auth/views/' . $frontend . '/components/template-dashboard.blade.php', 'resources/views/components/template-dashboard.blade.php');

        copy('vendor/base-php/core/auth/views/' . $frontend . '/dashboard/index.blade.php', 'resources/views/dashboard/index.blade.php');

        copy('vendor/base-php/core/auth/views/' . $frontend . '/users/create.blade.php', 'resources/views/users/create.blade.php');
        copy('vendor/base-php/core/auth/views/' . $frontend . '/users/edit.blade.php', 'resources/views/users/edit.blade.php');
        copy('vendor/base-php/core/auth/views/' . $frontend . '/users/index.blade.php', 'resources/views/users/index.blade.php');

        $content = file_get_contents('vendor/base-php/core/auth/routes.php');
        $fopen = fopen('app/routes.php', 'a+');
        fwrite($fopen, $content);

        system('composer require phpmailer/phpmailer');

        if ($frontend == 'bootstrap') {
            system('npm install jquery bootstrap sweetalert2');
            copy('vendor/base-php/core/auth/views/bootstrap/home/index.blade.php', 'resources/views/home/index.blade.php');
        } else {
            system('npm install alpinejs flowbite sweetalert2');
        }

        $style = new SymfonyStyle($input, $output);
        $style->success('Autenticación instalada satisfactoriamente.');

        return Command::SUCCESS;
    }
}
