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

        $style->table([], [
            ['Instalación', 'https://github.com/base-php/base-php'],

            ['Contenedor de servicios', 'https://laravel.com/docs/9.x/container'],

            ['Rutas', 'https://laravel.com/docs/9.x/routing'],
            ['Middleware', 'https://laravel.com/docs/9.x/middleware'],
            ['Controladores', 'https://laravel.com/docs/9.x/controllers'],
            ['Vistas', 'https://laravel.com/docs/9.x/views'],
            ['Plantillas Blade', 'https://laravel.com/docs/9.x/blade'],
            ['Validaciones', 'https://laravel.com/docs/9.x/validation'],

            ['Consola', 'https://github.com/bobthecow/psysh/wiki'],
            ['Colecciones', 'https://laravel.com/docs/9.x/collections'],
            ['Almacenamiento de archivos', 'https://flysystem.thephpleague.com/docs'],
            ['Cliente HTTP', 'https://laravel.com/docs/9.x/http-client'],
            ['Correos electrónicos', 'https://github.com/PHPMailer/PHPMailer'],

            ['Bases de datos', 'https://laravel.com/docs/9.x/database'],
            ['Queries', 'https://laravel.com/docs/9.x/queries'],
            ['Paginación', 'https://laravel.com/docs/9.x/pagination'],
            ['Migraciones', 'https://laravel.com/docs/9.x/migrations'],

            ['Eloquent ORM', 'https://laravel.com/docs/9.x/eloquent'],
            ['Relaciones', 'https://laravel.com/docs/9.x/eloquent-relationships'],
            ['Colecciones Eloquent', 'https://laravel.com/docs/9.x/eloquent-collections'],
            ['Mutadores', 'https://laravel.com/docs/9.x/eloquent-mutators'],
            ['Serialización', 'https://laravel.com/docs/9.x/eloquent-serialization'],

            ['Pruebas', 'https://phpunit.de'],

            ['Autenticación de dos factores', 'https://packagist.org/packages/pragmarx/google2fa-qrcode'],
            ['Excel', 'https://phpspreadsheet.readthedocs.io/en/latest'],
            ['PDF', 'https://packagist.org/packages/dompdf/dompdf'],
            ['QR', 'https://packagist.org/packages/endroid/qr-code'],
        ]);

        return Command::SUCCESS;
    }
}
