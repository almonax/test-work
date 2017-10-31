<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Debug\Dumper;
use App\Employees;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

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

    /**
     * View single record of employee
     *
     * @param   int $id
     * @return  \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function viewNode($id)
    {
        $model = new Employees();
        $valid =   $model->validateId($id);

        if (! $valid)
            return abort(404);

        $model = Employees::find($id);

        if (! $model)
            return abort(404);

        return view('cruds.view', ['employee' => $model]);
    }

    /**
     * @param   int|null $id - parent node id
     * @return  \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create($id = null)
    {
        $parent = null;
        $model = new Employees();

        if (! empty($id)) {
            $valid = $model->validateId($id);

            if (! $valid) abort(404);
            $parent = Employees::find($id, ['id', 'fullname']);
        }

        return view('cruds.create', ['parentData' => $parent]);
    }

    /**
     * @param   Request $request
     * @return  \Illuminate\Http\RedirectResponse
     */
    public function addNode(Request $request)
    {
        $model = new Employees();
        $this->validate($request, $model->getRules());

        if ($request->parentId)
            $model = $model->addNode($request->parentId, $request->all());
        else $model = $model->addRootNode($request->all());
        return redirect()->route('view', ['id' => $model]);
    }

    /**
     * @param   $id
     * @return  \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        $model = new Employees();
        $valid = $model->validateId($id);

        if (! $valid)
            abort(404);

        $model = Employees::find($id);
        if (! $model)
            return abort(404);

        return view('cruds.edit', ['employee' => $model]);
    }

    /**
     * @param   Request $request
     * @return  $this|\Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        $model = new Employees();

        $request->validate($model->getRules([
            'id', 'fullname', 'salary', 'beg_work'
        ]));

        if ($model->updateNode($request))
            return redirect()->route('view', ['id' => $request->id]);

        return back()->withInput($request->all());
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        $model = new Employees();
        $this->validate($request, $model->getRules(['id']));

        $model = $model->deleteNode($request->id);

        if ($model === true) $model = url('/');

        return response()->json(['model' => $model]);
    }

    /**
     *
     *
     *
     *
     *
     *
     *
     */


    /**
     * @param   $query
     * @return  \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search($query)
    {
        $model = new Employees();
        $columns = ['id', 'fullname'];
        $valid = $model->validateId($query);
        if ($valid) {
            $model = Employees::where('id', '=', $query)
                ->get($columns);
        } else {
            $valid = $model->validate($query, ['fullname']);
            if ($valid) {
                $model = Employees::where('fullname', 'LIKE', "%{$query}%")
                    ->get($columns)
                    ->pagination(20);
            } else
                $model = null;
        }

        return view('cruds.search', ['model' => $model]);

    }




//    public function addNode(Request $request)
//    {
//
//    }




    public function moveNode()
    {
        // move nodes
    }

    public function getBranch(Request $request)
    {
        $validateData = $request->validate([
            'id' => 'integer'
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
