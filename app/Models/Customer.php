<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    //


    protected $fillable = [
       'customer_number',
       'dealership_code',
       'dealership_id',
       'title',
       'name',
       'surname',
       'address_1',
       'address_2',
       'address_3',
       'address_4',
       'address_5',
       'post_code',
       'vehicle_reg',
       'vehicle_description',
       'home_phone',
       'mobile',
       'email',
       'created_at',
       'updated_at'
    ];

    protected   $primaryKey = 'customer_number';
    public      $incrementing = false;


}
