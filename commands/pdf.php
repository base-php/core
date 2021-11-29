<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;

class MakePdf extends Command
{
    protected static $defaultName = 'make:pdf';

    protected static $defaultDescription = 'Create a PDF file with the given name';

    public function configure()
    {
        $this->addArgument('name', InputArgument::REQUIRED);
    }

    protected function execute($input, $output)
    {
        $name = $input->getArgument('name');

        $content = file_get_contents('vendor/nisadelgado/framework/commands/examples/PDF.php');
        $content = str_replace('PDFName', $name, $content);

        if (!file_exists('app/PDF')) {
            mkdir('app/PDF');
        }

        $fopen = fopen('app/PDF/' . $name . '.php', 'w+');
        fwrite($fopen, $content);
        fclose($fopen);

        $text = "<info>PDF '$name' created successfully.</info>";
        $output->writeln($text);

        return Command::SUCCESS;
    }
}
