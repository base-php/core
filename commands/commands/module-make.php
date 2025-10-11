<?php

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Question\Question;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;

#[AsCommand(name: 'module:make', description: 'Crea un nuevo módulo')]
class ModuleMake extends Command
{
    public function configure()
    {
        $this->addArgument('name', InputArgument::OPTIONAL);
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $style = new SymfonyStyle($input, $output);

        $name = $input->getArgument('name');

        while (! $name) {
            $question = new Question("\n- ¿Cuál es el nombre del módulo?\n> ");

            $helper = $this->getHelper('question');
            $name = $helper->ask($input, $output, $question);
        }

        $name = ucfirst($name);

        if (! file_exists('modules')) {
            mkdir('modules');
        }

        if (file_exists("modules/$name")) {
            $style->error("El módulo '$name' ya existe.");
            return Command::FAILURE;
        }
        
        mkdir("modules/$name");
        mkdir("modules/$name/Controllers");
        mkdir("modules/$name/Resources");
        mkdir("modules/$name/Resources/assets");
        mkdir("modules/$name/Resources/assets/css");
        mkdir("modules/$name/Resources/assets/js");
        mkdir("modules/$name/Resources/views");

        $content = file_get_contents('vendor/base-php/core/commands/examples/controller.resource.php');
        $content = str_replace('ControllerName', $name . 'Controller', $content);
        $content = str_replace('App\Controllers', 'Modules\\' . $name . '\\Controllers', $content);
        $content = str_replace('use Redirect;', 'use App\Controllers\Controller;' . "\n" . 'use Redirect;', $content);
        $content = str_replace('// Your code here', "return view('blog:index');", $content);

        $fopen = fopen("modules/$name/Controllers/{$name}Controller.php", 'w+');
        fwrite($fopen, $content);
        fclose($fopen);

        $fopen = fopen("modules/$name/Resources/assets/css/style.css", 'w');
        fclose($fopen);
        
        $fopen = fopen("modules/$name/Resources/assets/js/main.js", 'w');
        fclose($fopen);

        $fopen = fopen("modules/$name/Resources/views/index.blade.php", 'w');
        fwrite($fopen, "<h1>Module $name</h1>");
        fclose($fopen);

        $slug = strtolower($name);
        $slug = str_replace(' ', '-', $slug);

        $fopen = fopen("modules/$name/routes.php", 'w');
        fwrite($fopen, "<?php\n\n" . '$route->get(\'/' . $slug . '\', [' . $name . 'Controller::class, \'index\']);' . "\n");
        fclose($fopen);

        $style->success("Módulo '$name' creado satisfactoriamente.");

        return Command::SUCCESS;
    }
}
