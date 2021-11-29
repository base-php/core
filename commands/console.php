<?php

use Symfony\Component\Console\Application;

class Console
{
	public static function run()
	{
		$application = new Application('Base PHP 1.3.91 by Nisa Delgado');

        $application->add(new Analyse());
        $application->add(new MakeController());
        $application->add(new MakeDatabase());
        $application->add(new MakeExcel());
        $application->add(new MakeMail());
        $application->add(new MakeMiddleware());
        $application->add(new MakeMigration());
        $application->add(new MakeModel());
        $application->add(new MakePdf());
        $application->add(new MakeResource());
        $application->add(new MakeRule());
        $application->add(new MakeTest());
        $application->add(new MakeValidation());
        $application->add(new Migrate());
        $application->add(new Test());
        $application->add(new Server());

        $application->run();
	}
}
