<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    function list($company_id)
    {
        return Person::where('company_id', $company_id)
               ->orderBy('first_name', 'asc')
               ->get();
    }
}
