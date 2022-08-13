<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Style\SymfonyStyle;

class MakeExcel extends Command
{
    protected static $defaultName = 'make:excel';

    protected static $defaultDescription = 'Crea una nueva clase de Excel';

    public function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED);
    }

    protected function execute($input, $output)
    {
        $name = $input->getArgument('name');

        $content = file_get_contents('vendor/nisadelgado/framework/commands/examples/Excel.php');
        $content = str_replace('ExcelName', $name, $content);

        if (!file_exists('app/Excel')) {
            mkdir('app/Excel');
        }

        $fopen = fopen('app/Excel/' . $name . '.php', 'w+');
        fwrite($fopen, $content);
        fclose($fopen);

        $style = new SymfonyStyle($input, $output);
        $style->success("Clase de Excel '$name' created successfully.");

        return Command::SUCCESS;
    }
}
