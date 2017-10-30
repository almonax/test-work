<?php

namespace App\Http\Controllers;

use Dotenv\Validator;
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
        $model = Employees::paginate(20);
        return view('dashboard', ['employees' => $model]);
    }

//    public function addNode(Request $request)
//    {
//
//    }

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


    public function moveNode()
    {
        // move nodes
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

    public function addNode(Request $request)
    {
        $this->validate($request, [
            'fullname' => 'required|string|max:40',
            'salary' => 'string|nullable|max:11',
            'beg_work' => 'date|nullable',
            'parentId' => 'integer|nullable'
        ]);

        $model = new Employees();
        if ($request->parentId)
            $model = $model->addNode($request->parentId, $request->all());
        else $model = $model->addRootNode($request->all());
        return redirect()->route('view', ['id' => $model]);
    }

    public function create($id = null)
    {
        $parent = null;
        if ($id && is_int( (int) $id )) {
            $parent = Employees::find($id, ['id', 'fullname']);
            if (! $parent) abort(404, 'Record with this ID not found');
        }

        return view('cruds.create', ['parentData' => $parent]);
    }

    public function edit()
    {

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        $this->validate($request, [
           'id' => 'required|integer'
        ]);

        $model = new Employees();
        $model = $model->deleteNode($request->id);

        if ($model === true) $model = url('/');

        return response()->json(['model' => $model]);
    }

    private function dd(...$args)
    {
        foreach ($args as $x) {
            (new Dumper)->dump($x);
        }
        return;
    }

}
