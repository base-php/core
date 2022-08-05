<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;

class Inspire extends Command
{
    protected static $defaultName = 'inspire';

    protected static $defaultDescription = 'Display an inspiring quote';

    protected function execute($input, $output)
    {
        $quotes = file_get_contents('https://type.fit/api/quotes');
        $quotes = json_decode($quotes, true);

        $count = count($quotes);
        $rand = rand(0, $count);

        $quote = $quotes[$rand]['text'];
        $author = $quotes[$rand]['author'];

        $style = new SymfonyStyle($input, $output);
        $style->text(['"' . $quote . '"', '- ' . $author]);
        $style->newLine();

        return Command::SUCCESS;
    }
}
