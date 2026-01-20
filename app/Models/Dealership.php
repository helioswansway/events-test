<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dealership extends Model
{
    //

    public function brand()
    {
        return $this->belongsTo('App\Models\Brand');
    }

    public function events()
    {
        return $this->belongsToMany("App\Models\Event");
    }


    public function self($id){
        return Dealership::find($id);
    }


}
