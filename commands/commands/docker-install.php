<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Yaml\Yaml;

#[AsCommand(name: 'docker:install', description: 'Instala el archivo Docker Compose predeterminado de Base PHP')]
class DockerInstall extends Command
{
    public function configure()
    {
        $this->addOption('php', null, InputOption::VALUE_OPTIONAL, 'Versión de PHP que será utilizada, por defecto es 8.4');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $style = new SymfonyStyle($input, $output);

        $services = $style->choice('¿Qué servicios le gustaría instalar?', ['mysql', 'pgsql'], 'mysql', multiSelect: true);

        $dockerComposeArray = require 'vendor/base-php/core/packages/docker/docker-compose.php';

        foreach ($services as $service) {
            $serviceArray = require "vendor/base-php/core/packages/docker/$service.php";
            $dockerComposeArray['services'][$service] = $serviceArray;

            $dockerComposeArray['services']['apache']['links'][] = $service;
            $dockerComposeArray['volumes']['persistent-' . $service] = null;
        }

        krsort($dockerComposeArray['services']);

        if ($input->getOption('php')) {
            $dockerComposeArray['services']['apache']['build'] = './vendor/base-php/core/packages/docker/php/' . $input->getOption('php');
        } else {
            $dockerComposeArray['services']['apache']['build'] = './vendor/base-php/core/packages/docker/php/8.4';
        } 

        $dockerComposeYml = Yaml::dump($dockerComposeArray, 10);
        file_put_contents('docker-compose.yml', $dockerComposeYml);

        $style->success('Docker se instaló correctamente. Puede ejecutar sus contenedores con el comando "php base docker:up"');

        if (! empty($services)) {
            $style->info('Un servicio de base de datos fue instalado. Ejecuta "php base docker:base migrate" para preparar tu base de datos.');
        }

        return Command::SUCCESS;
    }
}
