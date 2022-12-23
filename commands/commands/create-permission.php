<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;

class CreatePermission extends Command
{
    protected static $defaultName = 'permission:create-permission';

    protected static $defaultDescription = 'Crea un permiso';

    public function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED);
    }

    protected function execute($input, $output)
    {
        $name = $input->getArgument('name');

        DB::table('permissions')->insert([
            'name' => $name,
            'description' => $description
        ]);

        $style = new SymfonyStyle($input, $output);
        $style->success("Permission '$name' created.");

        return Command::SUCCESS;
    }
}
