<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'inspire', description: 'Muestra una frase motivacional')]
class Inspire extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $quotes = file_get_contents('https://frasedeldia.azurewebsites.net/api/phrase');
        $quotes = json_decode($quotes);

        $quote = $quotes->phrase;
        $author = $quotes->author;

        $style = new SymfonyStyle($input, $output);
        $style->text(['"'.$quote.'"', '- '.$author]);
        $style->newLine();

        return Command::SUCCESS;
    }
}
