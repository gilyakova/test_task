<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    function list()
    {
        return Company::all();
    }

    public function People()
    {
        return $this->hasMany('App\Person');
    }
}
