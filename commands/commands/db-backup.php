<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'db:backup', description: 'Genera copa de seguridad de la conexión a base de datos dada')]
class DBBackup extends Command
{
    public function configure()
    {
        $this->addArgument('filename', InputArgument::OPTIONAL);
        $this->addArgument('connection', InputArgument::OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $config = include 'app/config.php';

        $connection = ($input->getArgument('connection')) ? $input->getArgument('connection') : 'default';

        $i = array_search('default', array_column($config['database'], 'name'));

        $filename = $config['database'][$i]['database'].'_'.time();

        if ($config['database'][$i]['driver'] != 'sqlite') {
            $filename = $filename.'.sql';
        } else {
            $filename = $filename.'.sqlite';
        }

        $filename = ($input->getArgument('filename')) ? $input->getArgument('filename') : $filename;

        backup($connection)->filename($filename);

        $style = new SymfonyStyle($input, $output);
        $style->success('Copia de seguridad creada satisfactoriamente.');

        return Command::SUCCESS;
    }
}
