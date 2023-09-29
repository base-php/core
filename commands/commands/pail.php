<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;

class Pail extends Command
{
    protected static $defaultName = 'pail';

    protected static $defaultDescription = 'Muestra los registros de error';

    public function configure()
    {
        $this->addOption('filter', null, InputOption::VALUE_NONE, 'Filtra los errores');
    }

    protected function execute($input, $output)
    {
        $style = new SymfonyStyle($input, $output);

        $filter = $input->getOption('filter');

        $errorLogFilePath = ini_get('error_log');
        $errors = file_get_contents($errorLogFilePath);

        foreach (explode("\n", $errors) as $error) {
            if ($filter) {
                if (strpos($error, $filter)) {
                    $style->error($error);
                }
            } else {
                $style->error($error);
            }
        }

        return Command::SUCCESS;
    }
}
