<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\SaleType;
use DB;

class SaleTypeController extends Controller
{

    public function create()
    {
        //
        $sale_types  = SaleType::orderBy('name', 'ASC')->get();
        return view('admin.leaderboard.sales-types.index')
                ->with('sale_types', $sale_types);
    }

    public function store(Request $request)
    {
        //SaleType
        $sale_type = new SaleType;

        $sale_type->name = $request->name;
        $sale_type->save();

    }

    public function update(Request $request)
    {
        //

        $sale_type              =  SaleType::find($request->id);

        $sale_type->name        =   $request->name;
        $sale_type->save();


    }

    public function delete(Request $request)
    {
        //
        $sale_type =  SaleType::find($request->id);
        $sale_type->delete();

    }

}
