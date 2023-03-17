<?php

namespace Tests;

use DB;
use PHPUnit\Framework\TestCase;

class Test extends TestCase
{
    public $queryString;
    public $request;

    public function actingAs($user)
    {
        $this->queryString['actingAs'] = $user->id;
        return $this;
    }

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

    public function assertExactJson($array)
    {
        $json = json_decode($this->request->body(), true);

        if ($array == $json) {
            return $this->assertTrue(true);
        }

        return $this->fail('El valor del JSON no es el esperado');
    }

    public function assertJsonPath($key, $value)
    {
        $array = json_decode($this->request->body(), true);
        $array = arr()->dot($array);

        if ($array[$key] == $value) {
            return $this->assertTrue(true);
        }

        return $this->fail('El valor del JSON es distinto al esperado');
    }

    public function assertSee($text1, $text2)
    {
        if (strpos($text1, $text2) !== false) {
            return $this->assertTrue(true);
        }

        return $this->fail('No se encontró el texto');
    }

    public function assertStatus($status)
    {
        if ($this->request->status() == $status) {
            $this->assertTrue(true);
        }

        $this->fail('El estado es distinto al esperado');

        return $this;
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

        if (! empty($this->queryString)) {
            $queryString = http_build_query($this->queryString);
            $url = $url . '?' . $queryString;
        }

        $this->request = http()->get($url);

        return $this;
    }

    public function post($route, $data)
    {
        $url = "localhost:8080/$route";

        if (! empty($this->queryString)) {
            $queryString = http_build_query($this->queryString);
            $url = $url . '?' . $queryString;
        }

        $this->request = http()->post($url, $data);

        return $this;
    }

    public function withHeaders($array)
    {
        $this->queryString['withHeaders'] = $array;
        return $this;
    }

    public function withSession($array)
    {
        $this->queryString['withSession'] = $array;
        return $this;
    }
}
