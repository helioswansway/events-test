<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;


    public function book()
    {
        return $this->belongsTo("App\Book");
    }

    public function exec()
    {
        return $this->belongsTo("App\Exec");
    }

    public function dealership()
    {
        return $this->belongsTo("App\Models\Dealership");
    }

}
