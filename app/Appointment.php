<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['datetime', 'place', 'company_id', 'person_id', 'contacts', 'note'];

    /**
     * @param string $status
     * @param int $limit
     * @param int $skip
     * 
     * @return array
     */
    function list($status = 'active', $limit = 10, $skip = 0)
    {
        return Appointment::with('company')
                ->where('status', $status)
                ->orderBy('datetime', 'desc')
                ->skip($skip * $limit)
                ->take($limit)
                ->get();
    }

    /**
     */
    function list_all()
    {
        return Appointment::orderBy('datetime', 'desc')->get();
    }
    
    /**
     */
    public function Company()
    {
        return $this->belongsTo('App\Company');
    }
    
    /**
     */
    public function Person()
    {
        return $this->belongsTo('App\Person');
    }

}
