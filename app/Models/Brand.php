<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    //

    public function dealership()
    {
        return $this->belongsTo('App\Models\Dealership');
    }
}
