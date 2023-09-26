<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

class Docs extends Command
{
    protected static $defaultName = 'docs';

    protected static $defaultDescription = 'Acceso a la documentación';

    protected function execute($input, $output)
    {
        $style = new SymfonyStyle($input, $output);

        $table->table(['Inicio'], [
            ['Instalación', 'https://github.com/base-php/base-php'],
        ]);

        $table->table(['Lo básico'], [
            ['Contenedor de servicios', 'https://laravel.com/docs/9.x/container'],
            ['Rutas', 'https://laravel.com/docs/9.x/routing'],
            ['Middleware', 'https://laravel.com/docs/9.x/middleware'],
            ['Controladores', 'https://laravel.com/docs/9.x/controllers'],
            ['Vistas', 'https://laravel.com/docs/9.x/views'],
            ['Plantillas Blade', 'https://laravel.com/docs/9.x/blade'],
            ['Validaciones', 'https://laravel.com/docs/9.x/validation'],
        ]);

        $table->table(['Más a fondo'], [
            ['Consola', 'https://github.com/bobthecow/psysh/wiki'],
            ['Colecciones', 'https://laravel.com/docs/9.x/collections'],
            ['Almacenamiento de archivos', 'https://flysystem.thephpleague.com/docs'],
            ['Cliente HTTP', 'https://laravel.com/docs/9.x/http-client'],
            ['Correos electrónicos', 'https://github.com/PHPMailer/PHPMailer'],
        ]);

        $table->table(['Frontend'], [
            ['Bootstrap', 'https://getbootstrap.com'],
            ['Tailwind', 'https://tailwindcss.com'],
            ['jQuery', 'https://jquery.com'],
            ['Alpine', 'https://alpinejs.dev'],
        ]);

        $table->table(['Base de datos'], [
            ['Inicio', 'https://laravel.com/docs/9.x/database'],
            ['Queries', 'https://laravel.com/docs/9.x/queries'],
            ['Paginación', 'https://laravel.com/docs/9.x/pagination'],
            ['Migraciones', 'https://laravel.com/docs/9.x/migrations'],
        ]);

        $table->table(['Eloquent ORM'], [
            ['Inicio', 'https://laravel.com/docs/9.x/eloquent'],
            ['Relaciones', 'https://laravel.com/docs/9.x/eloquent-relationships'],
            ['Colecciones Eloquent', 'https://laravel.com/docs/9.x/eloquent-collections'],
            ['Mutadores', 'https://laravel.com/docs/9.x/eloquent-mutators'],
            ['Serialización', 'https://laravel.com/docs/9.x/eloquent-serialization'],
        ]);

        $table->table(['Pruebas'], [
            ['PHP Unit', 'https://phpunit.de'],
            ['Pest', 'https://pestphp.com'],
        ]);

        $style->table(['Paquetes'], [
            ['Autenticación de dos factores', 'https://packagist.org/packages/pragmarx/google2fa-qrcode'],
            ['Autenticación con Facebook', 'https://github.com/facebookarchive/php-graph-sdk'],
            ['Autenticación con Google', 'https://github.com/googleapis/google-api-php-client'],
            ['Excel', 'https://phpspreadsheet.readthedocs.io/en/latest'],
            ['PDF', 'https://packagist.org/packages/dompdf/dompdf'],
            ['QR', 'https://packagist.org/packages/endroid/qr-code'],
            ['OpenAI', 'https://github.com/openai-php/client'],
            ['SSH', 'https://github.com/spatie/ssh'],
            ['MJML', 'https://github.com/spatie/mjml-php'],
            ['Pint', 'https://github.com/laravel/pint'],
            ['Prompts', 'https://github.com/laravel/prompts'],
        ]);

        return Command::SUCCESS;
    }
}
