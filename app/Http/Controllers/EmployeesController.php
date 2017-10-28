<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Debug\Dumper;
use App\Employees;
use Illuminate\View\View;

class EmployeesController extends Controller
{
    /**
     * EmployeesController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $model = new Employees();
        $model = $model->getTree(1);

        return view('dashboard', ['tree' => $model]);

    }

    public function addNode(Request $request)
    {
        // create
    }

    public function viewNode()
    {
        // read
    }

    public function updateNode()
    {
        // update
    }

    public function deleteNode()
    {
        // delete
    }

    public function moveNode()
    {
        // move nodes
    }

    public function viewAll()
    {
        //
    }

    public function getBranch()
    {
        //
    }

    private function dd(...$args)
    {
        foreach ($args as $x) {
            (new Dumper)->dump($x);
        }
        return;
    }

}
