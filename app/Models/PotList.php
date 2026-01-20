<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Builder;

class PotList extends Model
{
    use HasFactory;

    protected $fillable = [
        'called',
        'admin_id',
        'dealership_id',
        'pot_campaign_id',
        'title',
        'first_name',
        'last_name',
        'registration',
        'email',
        'phone',
        'customer_type',
        'model',
        'description',
        'sale_date',
        'last_work_date',
        'mileage',
        'created_at',
        'updated_at'
    ];

    protected $searchable = [
        'description',
        'model',
        'registration',
        //'phone',
    ];

    public function admin()
    {
        return $this->belongsTo('Bitfumes\Multiauth\Model\Admin');
    }


    public function dealership()
    {
        return $this->belongsTo('App\Models\Dealership');
    }

    public function scopeSearch(Builder $builder, string $term = '')
    {

        foreach($this->searchable as $searchable){
            if(str_contains($searchable, '.')){
                $relation = Str::beforeLast($searchable, '.');
                $column = Str::afterLast($searchable, '.');
                $builder->orWhereRelation($relation, $column, 'like', "%$term%");
                continue;
            }

            $builder->orWhere($searchable, 'like', "%$term%");
        }


        return $builder;

    }
}
