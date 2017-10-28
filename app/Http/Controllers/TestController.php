<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Debug\Dumper;
use Illuminate\Support\Facades\DB;


class TestController extends Controller
{
    public function run()
    {
        return 'Hello world';
    }

    private function dd(...$args)
    {
        foreach ($args as $x) {
            (new Dumper)->dump($x);
        }
        return;
    }
}
