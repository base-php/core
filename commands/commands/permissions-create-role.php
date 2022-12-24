<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;

class PermissionsCreateRole extends Command
{
    protected static $defaultName = 'permissions:create-role';

    protected static $defaultDescription = 'Crea un rol';

    public function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED);
    }

    protected function execute($input, $output)
    {
        include 'vendor/base-php/core/database/database.php';

        $name = $input->getArgument('name');
        $description = $input->getArgument('name');

        DB::table('roles')->insert([
            'name' => $name,
            'description' => $description
        ]);

        $style = new SymfonyStyle($input, $output);
        $style->success("Role '$name' created.");

        return Command::SUCCESS;
    }
}
