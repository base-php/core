<?php

use Doctrine\DBAL\DriverManager;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\Table;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\ConfirmationQuestion;
use Symfony\Component\Console\Style\SymfonyStyle;

class DBTable extends Command
{
    protected static $defaultName = 'db:table';

    protected static $defaultDescription = 'Muestra información base de datos dada';

    public function configure()
    {
        $this->addOption('database', null, InputOption::VALUE_OPTIONAL, 'Conexión de base de datos a utilizar', 'default');
    }

    protected function execute($input, $output)
    {
        include 'vendor/base-php/core/database/database.php';

        if (! class_exists('Doctrine\DBAL\DriverManager')) {
            $helper = $this->getHelper('question');

            $text = 'La inspección de información de la base de datos requiere el paquete doctrine/dbal ¿Te gustaría instalarlo? (si/no) [no]';
            $question = new ConfirmationQuestion($text, false, '/^(s|y)/i');

            if ($helper->ask($input, $output, $question)) {
                exec('composer require doctrine/dbal');

                return Command::SUCCESS;
            }

            return Command::SUCCESS;
        }

        return Command::SUCCESS;
    }
}
