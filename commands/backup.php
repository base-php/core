<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;

class MakeBackup extends Command
{
    protected static $defaultName = 'backup';

    protected static $defaultDescription = 'Genera copa de seguridad de la conexión a base de datos dada';

    public function configure()
    {
        $this->addArgument('filename', InputArgument::OPTIONAL);
        $this->addArgument('connection', InputArgument::OPTIONAL);
    }

    protected function execute($input, $output)
    {
        $connection = ($input->getArgument('connection')) ? $input->getArgument('connection') : 'default';
        $filename   = ($input->getArgument('filename')) ? $input->getArgument('filename') : '';

        backup($connection)->filename($filename);

        $style = new SymfonyStyle($input, $output);
        $style->success('Copa de seguridad creada satisfactoriamente.');

        return Command::SUCCESS;
    }
}
