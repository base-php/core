<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;

class PermissionsCreatePermission extends Command
{
    protected static $defaultName = 'permissions:create-permission';

    protected static $defaultDescription = 'Crea un permiso';

    public function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED);
    }

    protected function execute($input, $output)
    {
        include 'vendor/base-php/core/database/database.php';

        $name = $input->getArgument('name');
        $description = $input->getArgument('name');

        DB::table('permissions')->insert([
            'name' => $name,
            'description' => $description,
        ]);

        $style = new SymfonyStyle($input, $output);
        $style->success("Permission '$name' created.");

        return Command::SUCCESS;
    }
}
