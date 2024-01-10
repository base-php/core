<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class MakeChart extends Command
{
    protected static $defaultName = 'make:chart';

    protected static $defaultDescription = 'Crea una nueva clase de gráfico';

    public function configure()
    {
        $this->addArgument('name', InputArgument::OPTIONAL);
        $this->addArgument('library', InputArgument::OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $name = $input->getArgument('name');
        $library = $input->getArgument('library') ?? 'chartjs';

        while (! $name) {
            $question = new Question("\n- ¿Cuál es el nombre del gráfico?\n> ");

            $helper = $this->getHelper('question');
            $name = $helper->ask($input, $output, $question);
        }

        $content = file_get_contents('vendor/base-php/core/commands/examples/chart.php');
        $content = str_replace('ChartName', $name, $content);
        $content = str_replace('// Code...', '$this->type(\'' . $library . '\')', $content);

        if (! file_exists('app/Charts')) {
            mkdir('app/Charts');
        }

        $fopen = fopen('app/Charts/' . $name . '.php', 'w+');
        fwrite($fopen, $content);
        fclose($fopen);

        $style = new SymfonyStyle($input, $output);
        $style->success("Clase de gráfico '$name' creada satisfactoriamente.");

        return Command::SUCCESS;
    }
}
