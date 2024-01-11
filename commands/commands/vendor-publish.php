<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class VendorPublish extends Command
{
    protected static $defaultName = 'vendor:publish';

    protected static $defaultDescription = 'Publica cualquier asset publicable de paquetes de proveedores';

    public function configure()
    {
        $this->addOption('tag', null, InputOption::VALUE_OPTIONAL, 'Una o varias etiquetas que tienen activos que desea publicar (se permiten varios valores)', '');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $tag = $input->getOption('tag');

        $style = new SymfonyStyle($input, $output);

        if ($tag) {
            switch ($tag) {
                case 'bill':
                    copy('vendor/base-php/core/packages/bill/views/bill.blade.php', 'resources/views/bills/bill.blade.php');
                    break;

                case 'crud':
                    copy('vendor/base-php/core/packages/crud/views/index.blade.php', 'resources/views/crud/index.blade.php');
                    copy('vendor/base-php/core/packages/crud/views/create.blade.php', 'resources/views/crud/create.blade.php');
                    copy('vendor/base-php/core/packages/crud/views/edit.blade.php', 'resources/views/crud/edit.blade.php');
                    break;

                case 'http':
                    copy('vendor/base-php/core/http/views/401.blade.php', 'resources/views/errors/401.blade.php');
                    copy('vendor/base-php/core/http/views/404.blade.php', 'resources/views/errors/404.blade.php');
                    copy('vendor/base-php/core/http/views/500.blade.php', 'resources/views/errors/500.blade.php');
                    copy('vendor/base-php/core/http/views/503.blade.php', 'resources/views/errors/503.blade.php');
                    break;

                case 'pagination':
                    copy('vendor/base-php/core/pagination/views/bootstrap-4.blade.php', 'resources/views/pagination/bootstrap-4.blade.php');
                    copy('vendor/base-php/core/pagination/views/bootstrap-5.blade.php', 'resources/views/pagination/bootstrap-5.blade.php');
                    copy('vendor/base-php/core/pagination/views/default.blade.php', 'resources/views/pagination/default.blade.php');
                    copy('vendor/base-php/core/pagination/views/recover.blade.php', 'resources/views/pagination/recover.blade.php');
                    copy('vendor/base-php/core/pagination/views/semantic-ui.blade.php', 'resources/views/pagination/semantic-ui.blade.php');
                    copy('vendor/base-php/core/pagination/views/simple-bootstrap-4.blade.php', 'resources/views/pagination/simple-bootstrap-4.blade.php');
                    copy('vendor/base-php/core/pagination/views/simple-bootstrap-5.blade.php', 'resources/views/pagination/simple-bootstrap-5.blade.php');
                    copy('vendor/base-php/core/pagination/views/simple-default.blade.php', 'resources/views/pagination/simple-default.blade.php');
                    copy('vendor/base-php/core/pagination/views/simple-tailwind.blade.php', 'resources/views/pagination/simple-tailwind.blade.php');
                    copy('vendor/base-php/core/pagination/views/tailwind.blade.php', 'resources/views/pagination/tailwind.blade.php');
                    break;
            }

            $style->success("Assets de [$tag] publicados.");

        } else {
            $style->warning("You must specify the tag of the assets you want to publish.");
        }

        return Command::SUCCESS;
    }
}
