<?php

namespace Tests\Feature;

use App\Http\Controllers\EmployeesController;
use GuzzleHttp\Psr7\Request;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmployeesDeleteNode extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $req = new \Illuminate\Http\Request(['id' => 49], ['id' => 49]);
        $controller = new EmployeesController();
        $controller  = $controller ->delete($req);
        print $controller;
        $this->assertTrue(true);
    }
}
