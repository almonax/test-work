<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Debug\Dumper;
use App\Employees;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
        $model = Employees::paginate(20);
        return view('dashboard', ['employees' => $model]);
    }

    public function addNode(Request $request)
    {

    }

    /**
     * View single record of employee
     *
     * @param   int $id
     * @return  \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function viewNode($id)
    {
        $model = Employees::find($id);

        if (! $model) return abort(404, 'Record with this ID not found');

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
