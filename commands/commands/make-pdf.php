<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;

class MakePdf extends Command
{
    protected static $defaultName = 'make:pdf';

    protected static $defaultDescription = 'Crea una nueva clase de PDF';

    public function configure()
    {
        $this->addArgument('name', InputArgument::OPTIONAL);
    }

    protected function execute($input, $output)
    {
        $name = $input->getArgument('name');

        while (! $name) {
            $question = new Question("\n- ¿Cuál es el nombre del PDF?\n> ");

            $helper = $this->getHelper('question');
            $name = $helper->ask($input, $output, $question);
        }

        $content = file_get_contents('vendor/base-php/core/commands/examples/pdf.php');
        $content = str_replace('PDFName', $name, $content);

        if (! file_exists('app/PDF')) {
            mkdir('app/PDF');
        }

        $fopen = fopen('app/PDF/' . $name . '.php', 'w+');
        fwrite($fopen, $content);
        fclose($fopen);

        $style = new SymfonyStyle($input, $output);
        $style->success("Clase de PDF '$name' creada satisfactoriamente.");

        return Command::SUCCESS;
    }
}
