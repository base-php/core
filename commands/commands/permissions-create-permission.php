<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'permissions:create-permission', description: 'Crea un permiso')]
class PermissionsCreatePermission extends Command
{
    public function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
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
