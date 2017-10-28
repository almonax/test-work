<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Validator;

class EmployeesValidate extends Model
{

    private $rules = [
        'id'        => 'required|integer',
        'fullname'  => 'required|string|min:5',
        'salary'    => 'nullable|string|max:11',
        'beg_work'  => 'nullable|date'
    ];

    private $errors;

    public function validate($data)
    {
        $validData = Validator::make($data, $this->rules);

        if ($validData->fails()) {
            $this->errors = $validData->errors();
            return false;
        }

        return true;
    }

    public function errors()
    {
        return $this->errors;
    }

}
