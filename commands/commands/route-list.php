<?php

use Illuminate\Container\Container;
use Illuminate\Events\EventServiceProvider;
use Illuminate\Routing\RoutingServiceProvider;
use Illuminate\Support\Facades\Facade;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'route:list', description: 'Lista de todas las rutas registradas')]
class RouteList extends Command
{
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $style = new SymfonyStyle($input, $output);

        $routes = [];

        $app = new Container;
        Facade::setFacadeApplication($app);
        $app['app'] = $app;
        $app['env'] = 'production';
        with(new EventServiceProvider($app))->register();
        with(new RoutingServiceProvider($app))->register();

        $route = $app['router'];
        include 'app/routes.php';

        $i = 1;

        foreach ($route->getRoutes()->getRoutes() as $item) {
            $methods = implode('|', $item->methods);
            $route = $item->uri;
            $action = $item->action['controller'];

            $routes[] = [$i++, $methods, $route, $action];
        }

        $style->table(
            ['#', 'Método', 'Ruta', 'Acción'],
            $routes
        );

        return Command::SUCCESS;
    }
}
