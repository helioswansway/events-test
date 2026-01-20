<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Vehicle;
use App\Models\Brand;

use Image;
use DB;

class VehicleController extends Controller
{
    //

    public function index()
    {

        $vehicles = Vehicle::groupBy('brand_id')->get();

        return view('admin.vehicles.index')
            ->with('vehicles', $vehicles);

    }

     //Sorts Vehicles position
     public function vehiclePosition(Request $request)
     {

         if($request->ajax()){
             //return "Ajax Request";
             $sorting    = $request->input('update');
             $positions  = $request->input('positions');

             foreach ($positions as $order) {
                 $id = $order[0];
                 $newPosition = $order[1];
                 $vehicle = Vehicle::where('id', '=', $id)->update(array('order' => $newPosition));
             }
         }
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        $brands    =   brand::all();
        return view('admin.vehicles.create')
                ->with('brands', $brands);
    }


    public function store(Request $request)
    {
        //

            $vehicle = new Vehicle;
            //Handles Form validation
            $this->validate($request, [
                'name'          => 'required',

            ]);

            if($request->hasfile('filename')){
                //return asset('/assets/images/properties/'.$property->default_filename);
                // if($vehicle->filename != ""){

                //     if(file_exists(public_path() . '/assets/images/public/general/'.$vehicle->filename)){
                //         unlink('assets/images/public/general/'.$vehicle->filename);
                //     }
                // }

                    $image = $request->file('filename');
                    $filename = rand() . '.' .$image->getClientOriginalExtension();
                    $location = public_path("assets/images/public/general/" . $filename);

                    //$location = public_path("assets/images/properties/" . $filename);
                    $img = Image::make($image);
                    $img->fit(1024, 768)->save($location);
                    //$path = $request->file('filename')->move('assets/images/admin/general', $filenameToStore);
                    $vehicle->filename          = $filename;

            }else{

                $vehicle->filename          = $vehicle->filename  ;
            }

            $position = DB::table('vehicles')->max('order');
            $vehicle->order = $position + 1;

            $vehicle->brand_id = $request->input('brand_id');
            $vehicle->name = $request->input('name');

            $vehicle->save();


            return redirect()->route('vehicle.edit.by.brand', ['id' => $vehicle->brand_id])->with('success', '['. $vehicle->name . '] has been successfully updated.');

    }

        /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


        /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brands    =   brand::all();
        $vehicle = Vehicle::find($id);
        return view('admin.vehicles.edit-vehicle')
                ->with('brands', $brands)
                ->with('vehicle', $vehicle);

    }

        /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editByBrand($id)
    {
        $v = Vehicle::where('brand_id', $id)->first();
        $brand = Brand::find($id);
        if(empty($v)){
            return redirect()->route('vehicle.index')->with('success', 'There isn\'t any more vehicles in ' . $brand->name);
        }

        $vehicles = Vehicle::where('brand_id', $id)->orderBy('order', 'ASC')->get();

        return view('admin.vehicles.edit')
            ->with('brand', $brand)
            ->with('vehicles', $vehicles);

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
            $vehicle = Vehicle::find($id);
            //Handles Form validation
            $this->validate($request, [
                'name'          => 'required',
            ]);

            if($request->hasfile('filename')){
                //return asset('/assets/images/properties/'.$property->default_filename);
                if($vehicle->filename != ""){

                    if(file_exists(public_path() . '/assets/images/public/general/'.$vehicle->filename)){
                        unlink('assets/images/public/general/'.$vehicle->filename);
                    }
                }

                    $image = $request->file('filename');
                    $filename = rand() . '.' .$image->getClientOriginalExtension();
                    $location = public_path("assets/images/public/general/" . $filename);

                    //$location = public_path("assets/images/properties/" . $filename);
                    $img = Image::make($image);
                    $img->fit(1024, 768)->save($location);
                    //$path = $request->file('filename')->move('assets/images/admin/general', $filenameToStore);
                    $vehicle->filename          = $filename;

            }else{

                $vehicle->filename          = $vehicle->filename  ;
            }


            $vehicle->name        =   $request->input('name');

            $vehicle->save();


            return redirect()->route('vehicle.edit.by.brand', ['id' => $vehicle->brand_id])->with('success', '['. $vehicle->name . '] has been successfully updated.');

    }


    public function delete($id)
    {
        $vehicle = vehicle::where('id', $id)->first();

        if($vehicle->filename != ""){
            if(file_exists(public_path() . '/assets/images/public/general/'.$vehicle->filename)){
                unlink('assets/images/public/general/'.$vehicle->filename);
            }
        }
        $vehicle->delete();

        return redirect()->route('vehicle.edit.by.brand', ['id' => $vehicle->brand_id])->with('success', '['. $vehicle->name . '] has been successfully deleted');

    }


}
