<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class EmployeesValidate extends Model
{

    /**
     * @var array
     */
    private $rules = [
        'id' => 'integer',
        'fullname' => 'required|string|min:4|max:40',
        'salary' => 'nullable|string|max:11',
        'beg_work' => 'nullable|date|date_format:Y-m-d',
        'parentId' => 'nullable|integer' // not column name.
    ];

    /**
     * @var array
     */
    private $errors;

    /**
     * @param   array $data
     * @param   array $rules
     * @return  bool
     */
    public function validate($data, $rules = [])
    {
        $rules = (empty($rules))
            ? $this->rules
            : $this->getRules($rules);

        $validData = Validator::make($data, $rules);

        if ($validData->fails()) {
            $this->errors = $validData->errors();
            return false;
        }

        return true;
    }

    /**
     * @return  array
     */
    public function errors()
    {
        return $this->errors;
    }

    /**
     * @param   array $key
     * @return  array
     */
    public function getRules($key = [])
    {
        if (empty($key))
            return $this->rules;
        else {
            $rulesArray = [];

            foreach ($key as $val) {
                if (isset($this->rules[$val]))
                    $rulesArray[$val] = $this->rules[$val];
            }

            return $rulesArray;
        }

    }

    /**
     * @param   int|string $id
     * @return  bool
     */
    public function validateId($id)
    {
        return $this->validate(
            ['id' => $id],
            ['id']
        );
    }

}
