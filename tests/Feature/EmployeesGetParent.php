<?php

namespace Tests\Feature;

use App\Employees;
use Tests\TestCase;

class EmployeesGetParent extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $model = new Employees();
        print $model->getParentNode(49);

        $this->assertTrue(true);
    }
}
