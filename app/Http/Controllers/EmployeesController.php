<?php

namespace App\Http\Controllers;

use App\Employees;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Http\Request;
use Illuminate\Support\Debug\Dumper;

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

        $model = $model->getBranch($id);

        if (! $model)
            return abort(404);

        return view('cruds.view', ['employee' => array_first($model), 'model' => $model]);
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

        $requestArray = $request->all();

        if ($request->file('photo')) {
            $img = new ImageController();
            $img = $img->resizeImage($request);
            $requestArray['photo'] = $img;
        }

        if ($request->parentId)
            $model = $model->addNode($request->parentId, $requestArray);
        else $model = $model->addRootNode($requestArray);
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

        if ($request->file('photo')) {
            $img = new ImageController();
            $img = $img->resizeImage($request);
            $request->request->add(['_photo' => $img]);
        }

        if ($model->updateNode($request))
            return redirect()->route('view', ['id' => $request['id']]);

        return back()->withInput($request);
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
     * @param   Request $request
     * @return  \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function search(Request $request)
    {
        $model = new Employees();
        $query = $request->input('query');
        $columns = ['id', 'fullname'];

        $valid = $model->validateId($query);
        if ($valid) {

            $model = $model->searchById($query, $columns);

        } else {

            $valid = $model->validate(['fullname' => $query], ['fullname']);
            if ($valid) {
                $model = $model->searchByName($query, $columns);
            } else
                $model = null;
        }

        return view('cruds.search', ['model' => $model]);
    }

    /**
     * @param   Request $request
     * @return  \Illuminate\Http\JsonResponse
     */
    public function deleteEmployeePhoto(Request $request)
    {
        $model = Employees::find($request->id);
        $file = new ImageController();
        $file->deletePhoto($model->photo);
        $model->photo = null;
        $model->save();
        return response()->json(true);
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




//    public function addNode(Request $request)
//    {
//
//    }




    public function moveNode(Request $request)
    {
//        $model = new Employees()
        return response()->json(['hello' => 'world']);
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
