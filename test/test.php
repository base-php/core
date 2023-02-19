<?php

namespace Tests;

use DB;
use PHPUnit\Framework\TestCase;

class Test extends TestCase
{
    public function assertDatabaseHas($table, $data)
    {
        include 'vendor/base-php/core/database/database.php';

        $db = DB::table($table)
            ->where($data)
            ->get();

        if ($db->count()) {
            return $this->assertTrue(true);
        }

        return $this->fail('Valor no existe en base de datos');
    }

    public function assertSee($text1, $text2)
    {
        if (strpos($text1, $text2) !== false) {
            return $this->assertTrue(true);
        }

        return $this->fail('No se encontró el texto');
    }

    public function command($command)
    {
        exec($command, $this->output);
        $this->output = implode("\n", $this->output);
        return $this;
    }

    public function expectsOutput($expect)
    {
        if ($expect == $this->output) {
            return $this->assertTrue(true);
        }

        return $this->fail('El resultado del comando no es el esperado');
    }

    public function get($route)
    {
        $url = "localhost:8080/$route";
        $request = http()->get($url);

        return $request;
    }

    public function post($route, $data)
    {
        $url = "localhost:8080/$route";
        $request = http()->post($url, $data);

        return $request;
    }
}
