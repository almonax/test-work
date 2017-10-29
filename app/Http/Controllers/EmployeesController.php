<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Debug\Dumper;
use App\Employees;

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

        return view('tree.tree-template', ['tree' => $model]);

    }

    public function addNode(Request $request)
    {
        // create
    }

    public function viewNode(Request $request)
    {
//        $request->route('id');
//        $request->id;
//        $this->dd($request->all());die;
        $data = $this->validate($request->id, [
           'id' => 'integer'
        ]);

        dd($data);
//        $this->dd($request->validate([
//            'id' => 'integer'
//        ]));die;
        $model = new Employees();
        $model = $model->getEmployee($data);

        return view('cruds.view', ['employee' => $model]);
    }

    public function updateNode(Request $request)
    {
//        $request->validate()
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
        $model = new Employees();
        $model = $model->pagination;
    }

    public function getBranch(Request $request)
    {
        $validateData = $request->validate([
            'id' => 'required|integer'
        ]);
        return $this->dd($validateData);
    }

    public function getBeginTree(Request $request)
    {
        $model = new Employees();
        $model = $model->getTree(1);
        return response()->json(['model' => $model]);
//        return $model;
    }

    private function dd(...$args)
    {
        foreach ($args as $x) {
            (new Dumper)->dump($x);
        }
        return;
    }

}
