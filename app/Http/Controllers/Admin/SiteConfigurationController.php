<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\SiteConfiguration;

use Image;
use DB;

class SiteConfigurationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
       $config  = SiteConfiguration::first();

        if(!empty($config)){
            return view('admin.site-configuration.index')->with('config', $config);
        }else{
            return view('admin.site-configuration.create');
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
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        //return "Storing";
        //Create Folder
        $config = new SiteConfiguration;

        //Handles Form validation
        $this->validate($request, [
            'company_name'      => 'required',
            'phone'             => 'required',
            'email'             => 'required|email',
            'address'           => 'required',
            'town'              => 'required',
            'county'            => 'required',
            'post_code'         => 'required',
            'filename'          => 'required',

        ]);

        $filenamewithExt = $request->file('filename')->getClientOriginalName();
        //get just filename
        $filename = pathinfo($filenamewithExt, PATHINFO_FILENAME);
        //get just ext
        $extension = $request->file('filename')->getClientOriginalExtension();
        // Filename to store
        $filenameToStore = $filename.'-'.time().'.'.$extension;
        // Upload Image
        //$path = $request->file('filename')->storeAs('public/assets/images/admin/general', $filenameToStore);
        $path = $request->file('filename')->move('assets/images/public/general', $filenameToStore);
        //$path = $request->file('filename')->move('assets/images/admin/general', $filenameToStore);

        $config->filename                   = $filenameToStore;
        $config->company_name               = $request->input('company_name');
        $config->phone                      = $request->input('phone');
        $config->email                      = $request->input('email');
        $config->address                    = $request->input('address');
        $config->address_1                  = $request->input('address_1');
        $config->town                       = $request->input('town');
        $config->county                     = $request->input('county');
        $config->post_code                  = $request->input('post_code');



        $config->save();

        return redirect('/dashboard/site-configuration')
        ->with('success', 'Configuration successfully been updated!');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {



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

        //Create Folder
        $config = SiteConfiguration::find($id);

        //Handles Form validation
        $this->validate($request, [
            'company_name'      => 'required',
            'phone'             => 'required',
            'email'             => 'required|email',
            'address'           => 'required',
            'town'              => 'required',
            'county'            => 'required',
            'post_code'         => 'required',


        ]);



        if($request->hasfile('filename')){
            //Unlink File

            if($config->filename != ""){

                if(file_exists(public_path() . '/assets/images/public/general/'.$config->filename)){
                    unlink('assets/images/public/general/'.$config->filename);
                }
            }

            //get filename with the extention

            $image = $request->file('filename');
            $filename = rand() . '.' .$image->getClientOriginalExtension();
            $location = public_path("assets/images/public/general/" . $filename);

            //$location = public_path("assets/images/properties/" . $filename);
            $img = Image::make($image);
            $img->save($location);
            //$path = $request->file('filename')->move('assets/images/admin/general', $filenameToStore);
            $config->filename           = $filename;

        }else{
            $config->filename           = $config->filename ;
        }


        if($request->hasfile('filename_contrast')){
            //Unlink File

            if($config->filename_contrast != ""){

                if(file_exists(public_path() . '/assets/images/public/general/'.$config->filename_contrast)){
                    unlink('assets/images/public/general/'.$config->filename_contrast);
                }
            }

            //get filename with the extention

            $image = $request->file('filename_contrast');
            $filename = rand() . '.' .$image->getClientOriginalExtension();
            $location = public_path("assets/images/public/general/" . $filename);

            //$location = public_path("assets/images/properties/" . $filename);
            $img = Image::make($image);
            $img->save($location);
            //$path = $request->file('filename')->move('assets/images/admin/general', $filenameToStore);
            $config->filename_contrast          = $filename;

        }else{
            $config->filename_contrast          = $config->filename_contrast ;
        }


        $config->company_name               = $request->input('company_name');
        $config->phone                      = $request->input('phone');
        $config->email                      = $request->input('email');
        $config->address                    = $request->input('address');
        $config->address_1                  = $request->input('address_1');
        $config->town                       = $request->input('town');
        $config->county                     = $request->input('county');
        $config->post_code                  = $request->input('post_code');

        $config->save();

        return redirect('/dashboard/site-configuration')
        ->with('success', 'Configuration successfully been updated!');

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
