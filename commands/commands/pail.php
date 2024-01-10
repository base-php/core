<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Pail extends Command
{
    protected static $defaultName = 'pail';

    protected static $defaultDescription = 'Muestra los registros de error';

    public function configure()
    {
        $this->addOption('filter', null, InputOption::VALUE_NONE, 'Filtra los errores');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $style = new SymfonyStyle($input, $output);

        $filter = $input->getOption('filter');

        $config = require 'app/config.php';

        $errorLogFile = $config['error_log'] ?? 'vendor/base-php/core/tmp/error.log';
        $errors = file_get_contents($errorLogFile);

        foreach (array_filter(explode("\n", $errors)) as $error) {
            if ($filter) {
                if (strpos($error, $filter)) {
                    $style->error($error);
                }
            } else {
                $style->error($error);
            }
        }

        if (! count(array_filter(explode("\n", $errors)))) {
            $style->info('No hay registros de errores');
        }

        return Command::SUCCESS;
    }
}
