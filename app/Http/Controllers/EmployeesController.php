<?php

namespace App\Http\Controllers;

use App\Employees;
use Illuminate\Http\Request;

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
     * Action of show form create new node
     *
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
     * Create (insert) new node in branch or in root of the tree
     *
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
     * Show form to edit
     *
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
     * Action update fields node
     *
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
     * Delete node or branch, or save descendant node, but not deleted node
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function delete(Request $request)
    {
        // declare main params
        $delNodeId = $request->id;
        $Imager = new ImageController();
        $model = new Employees();

        $this->validate($request, $model->getRules(['id']));

        // declare advanced params
        $parent = last($model->getParentNode($delNodeId, ['id'])->toArray());

        if ($parent === false) {
            $this->deleteEmployeePhoto($request);
            $model->deleteNode($request->id);
            return response()->json(['model' => url('/')]);
        }

        $branches = $model->getBranch($delNodeId);
        $delNodePhoto = null;

        // move child-nodes to new parent
        foreach ($branches as $key => $branch) {
            if ($key === 0) {
                $delNodePhoto = $branch->photo;
                continue;
            }

            if ($model->moveNode($branch->id, $parent->id))
                continue;
            else
                break;
        }

        // del photo
        if ($delNodePhoto != null) {
            $Imager->deletePhoto($delNodePhoto);
        }
        // del node
        $model = $model->deleteNode($delNodeId);

        if ($model === true) $model = url('/');

        return response()->json(['model' => $model]);
    }

    /**
     * Simple search interface
     *
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
     * Delete employee photo. Clear folder and DB
     *
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
     * Move node or branch to new ancestor
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function moveNode(Request $request)
    {
        $moveArray = $request->toMovie;
        $model = new Employees();

        if (! $moveArray) return response('No get data', 400);

        foreach ($moveArray as $item) {

            // validation
            $validNodeId = $model->validateId($item['nodeId']);
            $validParentId = $model->validateId($item['parentId']);

            if (! $validNodeId || !$validParentId)
                return response('Incorrect params in the query', 400);

            // start transfer
            if ($item['parentId'] == 0) {
                // that move node to root
                $transfer = $model->moveNodeToRoot($item['nodeId']);
            } else {
                $transfer = $model->moveNode($item['nodeId'], $item['parentId']);
            }

            if ($transfer !== true) response('Transfer employees aborted', 500);
        }

        return response()->json(true);
    }

    /**
     * Getting branch
     *
     * @param   Request $request
     * @return  Employees|array|\Illuminate\Contracts\Routing\ResponseFactory|\Symfony\Component\HttpFoundation\Response
     */
    public function getBranch(Request $request)
    {
        $getId = $request->node;
        $model = new Employees();

        $valid = $model->validateId($getId);
        if (! $valid) {
            return response('false', 404);
        }

        $model = $model->getBranch($getId);

        foreach ($model as $item) {
            if ($item->is_branch == true) {
                $item->children = [];
                $item->load_on_demand = true;
            }
            $item->label = $item->fullname;
            unset($item->fullname);
        }
        $model = $model->toArray();
        array_shift($model);

        return $model;
    }

    /**
     * Action for get first two level tree in 'Transfer Employees'
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getBeginTree()
    {
        $model = new Employees();
        $model = $model->getTree(1);
        return response()->json(['model' => $model]);
    }

}
