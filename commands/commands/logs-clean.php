<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Style\SymfonyStyle;

class LogsClean extends Command
{
    protected static $defaultName = 'logs:clean';

    protected static $defaultDescription = 'Limpie los registros antiguos del registro de actividad.';

    public function configure()
    {
        $this->addOption(
            'days',
            null,
            InputOption::VALUE_OPTIONAL,
            '(opcional) Se limpiarán los registros anteriores a este número de días',
            0
        );
    }

    protected function execute($input, $output)
    {
        include 'vendor/base-php/core/database/database.php';

        $days = $input->getOption('days');

        $style = new SymfonyStyle($input, $output);

        $style->warning('Borrando registros...');

        if ($days) {
            $date = new Datetime();
            $date->modify("-$days");

            $count = DB::table('logs')
                ->where('date_create', '<=', $date)
                ->count();

            DB::table('logs')
                ->where('date_create', '<=', $date)
                ->delete();

        } else {
            $count = DB::table('logs')
                ->where('date_create', '<', now('Y-m-d'))
                ->count();

            DB::table('logs')
                ->where('date_create', '<', now('Y-m-d'))
                ->delete();
        }

        $style->success("$count borrados del registro");
        $style->warning('¡Todo listo!');

        return Command::SUCCESS;
    }
}
