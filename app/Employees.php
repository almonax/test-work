<?php

namespace App;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class Employees extends EmployeesValidate
{

    public $timestamps = false;

    protected $table = 'employees';

    protected $fillable = ['fullname', 'salary', 'beg_work', 'photo'];

    /**
     * Get keys of single employee
     *
     * @param   $id
     * @return  object StdClass
     * @throws  \Exception
     */
    public function getKeysNode($id)
    {
        $employee = DB::table($this->table)
            ->select(['lft', 'rht', 'lvl'])
            ->where('id', '=', $id)
            ->first();

        if (! $employee)  throw new \Exception('Empty set. Record with this ID not found', 404);
        return $employee;
    }

    /**
     * Selected tree, begin as nodes with lvl = 0
     *
     * @param   int $depth
     * @return  array
     */
    public function getTree($depth)
    {
        $model = DB::table($this->table)
            ->select('id')
            ->where('lvl', '=', 0)
            ->get();

        $branches = [];

        foreach ($model as $item) {
            $branches[] = $this->getBranch($item->id, $depth);
        }
        return $branches;
    }

    /**
     * Get a branch with depth
     *
     * @param  int $id
     * @param  int $depth
     * @return array
     */
    public function getBranch($id, $depth = 1)
    {
        $employeeData = $this->getKeysNode($id);

        $branch = DB::table($this->table)->where('lft', '>=', $employeeData->lft)
            ->where('lft', '<', $employeeData->rht)
            ->where('lvl', '<=', $employeeData->lvl + $depth)
            ->get([
                'id', 'fullname', 'lvl', 'salary', 'beg_work', 'photo',
                /* To simplify the views  */
                DB::raw('FORMAT((((rht - lft) -1) / 2),0) AS cnt_children'),
                DB::raw('CASE WHEN rht - lft > 1 THEN 1 ELSE 0 END AS is_branch')
            ]);

        return $branch;
    }

    /**
     * @param   integer $id
     * @param   array $columns
     * @return  mixed
     */
    public function searchById($id, $columns)
    {
        return Employees::where('id', '=', $id)
            ->get($columns);
    }

    /**
     * @param   string $name
     * @param   array $columns
     * @return  mixed
     */
    public function searchByName($name, $columns)
    {
        return Employees::where('fullname', 'LIKE', "%{$name}%")
            ->get($columns);
    }

    /**
     * @param   Request $request
     * @return  mixed
     */
    public function updateNode($request)
    {
        $id = $request->id;
        $reqArr = $request->all($this->getFillable());
        if (isset($reqArr['photo']))
            $reqArr['photo'] = $request['_photo'];

        return DB::transaction(function() use($reqArr, $id) {
            return Employees::find($id)
                ->update($reqArr);
        });
    }

    /**
     * Delete node in tree
     *
     * @param   int $id
     */
    public function deleteNode($id)
    {
        $employeeData = $this->getKeysNode($id);
        $deltaKeys = ($employeeData->rht - $employeeData->lft) + 1;

        return DB::transaction(function() use ($id, $employeeData, $deltaKeys) {

            Employees::where('lft', '>=', $employeeData->lft)
                ->where('lft', '<', $employeeData->rht)
                ->where('rht', '<=', $employeeData->rht)
                ->where('lvl', '>=', $employeeData->lvl)
                ->delete();

            Employees::where('rht', '>', $employeeData->rht)
                ->update([
                    'lft' => DB::raw('CASE WHEN `lft` > ' . $employeeData->lft . ' THEN `lft` - ' . $deltaKeys . ' ELSE `lft` END'),
                    'rht' => DB::raw('CASE WHEN `rht` > ' . $employeeData->lft . ' THEN `rht` - ' . $deltaKeys . ' ELSE `rht` END'),
                ]);
            return true;
        });
    }

    /**
     * Add tree root node
     *
     * @param   array $data
     * @return  mixed
     */
    public function addRootNode($data)
    {
        $maxRightKey = Employees::max('rht');

        return DB::transaction(function() use($data, $maxRightKey) {
            $model = new Employees($data);
            $model->lft = $maxRightKey + 1;
            $model->rht = $maxRightKey + 2;
            $model->lvl = 0;
            $model->save();
            return $model->id;
        });
    }

    /**
     * Add new node in tree
     *
     * @param   int $parentId
     * @param   array $data
     * @return  mixed
     */
    public function addNode($parentId, $data)
    {
        $parentData = $this->getKeysNode($parentId);

        return DB::transaction(function() use($data, $parentData) {
            // update keys for other nodes
            Employees::where('rht', '>=', $parentData->rht)
                ->update([
                    'lft' => DB::raw('CASE WHEN `lft` > '. $parentData->rht .' THEN `lft` + 2 ELSE `lft` END'),
                    'rht' => DB::raw('CASE WHEN `rht` >= '. $parentData->rht .' THEN `rht` + 2 ELSE `rht` END')
                ]);
            // insert new node
            $model = new Employees($data);
            $model->lft = $parentData->rht;
            $model->rht = $parentData->rht + 1;
            $model->lvl = $parentData->lvl + 1;
            $model->save();
            return $model->id;
        });
    }

    /**
     * Get full data of single employee
     *
     * @param   $id
     * @return  object StdClass
     * @throws  \Exception
     */
    public function getEmployee($id)
    {
        //maybe use this:
        // return Employee::find($id)
        $employee = DB::table($this->table)
            ->select('*')
            ->where('id', '=', $id)
            ->first();
//        if (! $employee)  throw new \Exception('Empty set. Record with this ID not found', 404);
        return $employee;
    }

    /**
     * Count all records in table
     *
     * @return  int
     */
    public function employeesCount()
    {
        return DB::table($this->table)->count();
    }

    /**
     * Move node with $nodeId under node with $newParentId
     *
     * @param   int $nodeId
     * @param   int $newParentId
     * @return  bool|\Exception
     */
    public function moveNode($nodeId, $newParentId)
    {
        // Get data of moved node and his new parent
        $nodeData = $this->getKeysNode($nodeId);
        $newParentData = $this->getKeysNode($newParentId);

        // Compute advanced data
        $levelDiff = $nodeData->lvl - $newParentData->lvl - 1;
        $keySize = $nodeData->rht - $nodeData->lft;

        DB::beginTransaction();

        try {

            # Update the moving node by placing it in a new space
            Employees::where('lft', '>=', $nodeData->lft)
                ->where('rht', '<=', $nodeData->rht)
                ->update([
                    'lft' => DB::raw('0 - (`lft`)'),
                    'rht' => DB::raw('0 - (`rht`)')
                ]);

            # Decrease left and/or right position values of currently 'lower' items (and parents)
            Employees::where('lft', '>', $nodeData->rht)
                ->update([
                    'lft' => DB::raw('`lft` - ' . $keySize)
                ]);
            Employees::where('rht', '>', $nodeData->rht)
                ->update([
                    'rht' => DB::raw('`rht` - ' . $keySize)
                ]);

            # Increase left and/or right position values of future 'lower' items (and parents)
            $keyDiff = ($newParentData->rht > $nodeData->rht) ?
                $newParentData->rht - $keySize :
                $newParentData->rht;

            Employees::where('lft', '>=', $keyDiff)
                ->update([
                    'lft' => DB::raw('`lft` + ' . $keySize)
                ]);
            Employees::where('rht', '>=', $keyDiff)
                ->update([
                    'rht' => DB::raw('`rht` + ' . $keySize)
                ]);

            # Move node (ant it's subnodes) and update it's parent item lvl
            $keyDiff = ($newParentData->rht > $nodeData->rht) ?
                $newParentData->rht - $nodeData->rht - 1 :
                $newParentData->rht - $nodeData->rht - 1 + $keySize;

//            DB::rollback();

            Employees::where('lft', '<=', 0 - $nodeData->lft)
                ->where('rht', '>=', 0 - $nodeData->rht)
                ->update([
                    'lft' => DB::raw('0 - (`lft`) + ' . $keyDiff),
                    'rht' => DB::raw('0 - (`rht`) + ' . $keyDiff),
                    'lvl' => DB::raw('(`lvl`) - ' . $levelDiff)
                ]);
        } catch (\Exception $e) {


            DB::rollback();

            return $e;
//            return Redirect::to('/')
//                ->withErrors($e->getErrors());
        }

        DB::commit();
        return true;

    }

    /**
     * Move branch to new root of the tree
     *
     * @param $id
     */
    public function moveToRoot($id)
    {
        $nodeData = $this->getKeysNode($id);
        $keySize = $nodeData->rht - $nodeData->lft;

        # Update the moving node by placing it in a new space
        Employees::where('lft', '>=', $nodeData->lft)
            ->where('rht', '<=', $nodeData->rht)
            ->update([
                'lft' => DB::raw('0 - (`lft`)'),
                'rht' => DB::raw('0 - (`rht`)')
            ]);
        # Decrease left and/or right position values of currently 'lower' items (and parents)
        Employees::where('lft', '>', $nodeData->rht)
            ->update([
                'lft' => DB::raw('`lft` - ' . $keySize)
            ]);
        Employees::where('rht', '>', $nodeData->rht)
            ->update([
                'rht' => DB::raw('`rht` - ' . $keySize)
            ]);

        # Increase left and/or right position values of future 'lower' items (and parents)
        Employees::where('lft', '>=', $nodeData->lft)
            ->update([
                'lft' => DB::raw('`lft` - ' . $keySize)
            ]);
        Employees::where('rht', '>=', $nodeData->rht)
            ->update([
                'rht' => DB::raw('`rht` - ' . $keySize)
            ]);

        # Update hidden branch
        $maxKey = Employees::max('rht');
        /**
         * for use in production need improve formula that calc $lvlDiff,
         * because holes are formed
         */
        $lvlDiff = $nodeData->lvl;

        Employees::where('lft', '<=', 0 - $nodeData->lft)
            ->where('rht', '>=', 0 - $nodeData->rht)
            ->update([
                'lft' => DB::raw('0 - (`lft`) + ' . $maxKey),
                'rht' => DB::raw('0 - (`rht`) + ' . $maxKey),
                'lvl' => DB::raw('(`lvl`) - ' . $lvlDiff)
            ]);
    }

}
