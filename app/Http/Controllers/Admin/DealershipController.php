<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Dealership;
use App\Models\Brand;
use DB;

class DealershipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $dealerships = Dealership::orderBy('brand_id', 'ASC')->get();
        return view('admin.dealerships.index')
            ->with('dealerships', $dealerships);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brand::all();
        return view('admin.dealerships.create')
                ->with('brands', $brands);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';

        $validatedData = $request->validate([
            'name' => 'required|unique:dealerships,name',
            'website' => 'required|regex:'.$regex
        ],
        [
            'name.required' => 'A dealership name is required!',
            'name.unique' => 'Dealership name already exists!',
            'website.regex' => 'You need to type a correct web address!',
            'website.required' => 'A Website is required!'
        ]);

        $dealership     = new Dealership;

        $dealership->brand_id                   =   $request->input('brand_id');
        $dealership->brand_manager              =   $request->input('brand_manager');
        $dealership->brand_manager_email        =   $request->input('brand_manager_email');
        $dealership->name                       =   $request->input('name');
        $dealership->slug                       =   $request->input('slug');
        $dealership->email                      =   $request->input('email');
        $dealership->code                       =   $request->input('code');
        $dealership->phone                      =   str_replace(' ','',$request->input('phone'));
        $dealership->cc_phone                   =   str_replace(' ','',$request->input('cc_phone'));
        $dealership->website                    =   str_replace("http://", "https://", $request->input('website'));
        $dealership->save();

        return redirect()->route('dealership.index')->with('success', $dealership->name . ' was successfully created.');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $brands         = Brand::all();
        $dealership     = Dealership::find($id);

        return view('admin.dealerships.edit')
                ->with('dealership', $dealership)
                ->with('brands', $brands);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $regex = '/^(https?:\/\/)?([\da-z\.-]+)\.([a-z\.]{2,6})([\/\w \.-]*)*\/?$/';

        $validatedData = $request->validate([
            'name' => 'required',
            'website' => 'required|regex:'.$regex
        ],
        [
            'name.required' => 'A dealership name is required!',
            'website.regex' => 'You need to type a correct web address!',
            'website.required' => 'A Website is required!'
        ]);

        $dealership     = Dealership::find($id);

        //return $request->input('phone');
        $dealership->brand_id                   =   $request->input('brand_id');
        $dealership->brand_manager              =   $request->input('brand_manager');
        $dealership->brand_manager_email        =   $request->input('brand_manager_email');
        $dealership->name                       =   $request->input('name');
        $dealership->slug                       =   $request->input('slug');
        $dealership->email                      =   $request->input('email');
        $dealership->code                       =   $request->input('code');
        $dealership->phone                      =   str_replace(' ','',$request->input('phone'));
        $dealership->cc_phone                   =   str_replace(' ','',$request->input('cc_phone'));
        $dealership->website                    =   str_replace("http://", "https://", $request->input('website'));
        $dealership->save();

        return redirect()->route('dealership.index')->with('success', '['.$dealership->name . '] was successfully saved.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        $dealership = Dealership::find($id);
        $delete_admins = DB::table('admin_dealership')
                            ->select('admins.*')
                            ->join('admins', 'admins.id', 'admin_dealership.admin_id')
                            ->where('admin_dealership.dealership_id', $id)->delete();

        //return $delete_admins;

        $detach_dealership = DB::table('admin_dealership')->where('dealership_id', $id)->delete();

        $dealership->delete();
        return redirect()->route('dealership.index')->with('success', $dealership->name . ' has been deleted successfully.');

    }
}
