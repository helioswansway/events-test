<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Models\Brand;
use App\Models\Dealership;

use Image;
use DB;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $brands = Brand::orderBy('name', 'ASC')->get();
        return view('admin.brands.index')
                ->with('brands', $brands);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('admin.brands.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        //return $request->all();
        $brand = new Brand;
        //Handles Form validation
        $this->validate($request, [
            'name'          => 'required',
            'filename'      => 'required|image'
        ]);


        if($request->hasfile('filename')){

                $image = $request->file('filename');
                $filename = rand() . '.' .$image->getClientOriginalExtension();
                $location = public_path("assets/images/public/general/" . $filename);

                //$location = public_path("assets/images/properties/" . $filename);
                $img = Image::make($image);
                $img->fit(200, 200)->save($location);
                //$path = $request->file('filename')->move('assets/images/admin/general', $filenameToStore);
                $brand->filename = $filename;

            }else{

                $brand->filename = $brand->filename  ;
            }


        $brand->name = $request->input('name');
        $brand->save();
        return redirect()->route('brand.index')->with('success', '['. $brand->name . '] has been successfully created');

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
        $brand = Brand::find($id);
        return view('admin.brands.edit')
                ->with('brand', $brand);
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

            $brand  = Brand::find($id);
            //handle file upload
            if($request->hasfile('filename')){
                //return asset('/assets/images/properties/'.$property->default_filename);
                    if($brand->filename != ""){

                        if(file_exists(public_path() . '/assets/images/public/general/'.$brand->filename)){
                            unlink('assets/images/public/general/'.$brand->filename);
                        }
                    }

                    $image = $request->file('filename');
                    $filename = rand() . '.' .$image->getClientOriginalExtension();
                    $location = public_path("assets/images/public/general/" . $filename);

                    //$location = public_path("assets/images/properties/" . $filename);
                    $img = Image::make($image);
                    $img->fit(200, 200)->save($location);
                    //$path = $request->file('filename')->move('assets/images/admin/general', $filenameToStore);
                    $brand->filename = $filename;

            }else{

                $brand->filename = $brand->filename  ;
            }

            $brand->name        =  $request->input('name');
            $brand->save();
            return redirect()->route('brand.index')->with('success', '['.$brand->name.'] has been updated! ');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //

        $brand  = Brand::find($id);
        $dealership = Dealership::where('brand_id', $brand->id)->first();

        if($dealership){
            return redirect()->route('brand.index')->with('warning', 'Brand [' .$brand->name. '] couldnt be been deleted! There are Dealerships linked to Brands.');
        }else{
            //handle file upload

            //Unlink File
            unlink('assets/images/public/general/'.$brand->filename);
            $brand->delete();
            return redirect()->route('brand.index')->with('success', 'Brand [' .$brand->name. '] has been deleted!');
        }


    }
}
