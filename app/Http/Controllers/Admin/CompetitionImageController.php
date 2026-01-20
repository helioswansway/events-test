<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CompetitionImage;
use App\Models\Competition;
use App\Models\Brand;
use Image;
use DB;

class CompetitionImageController extends Controller
{
    //

    public function create(Request $request)
    {
        //
        $image = CompetitionImage::where('competition_id', $request->id)->first();
        $brands = Brand::orderBy('name', 'ASC')->get();

        if($image){
            return view('admin.leaderboard.images.edit')
                    ->with('brands', $brands)
                    ->with('image', $image);

        }else{
          return view('admin.leaderboard.images.index')
                    ->with('brands', $brands)
                    ->with('competition', $request->id);
        }

    }

    public function store(Request $request)
    {
        //
        $competition_image = new CompetitionImage();
        //Handles Form validation
        $this->validate($request, [
            'brand_id' => 'required',
        ],
        [
            'brand_id.required' => 'A Brand needs to  be selected'
        ]);

        if($request->hasfile('filename')){

            //prev_filename Stored
            $image = $request->file('filename');
            $filename = rand() . '.' .$image->getClientOriginalExtension();
            $location = public_path("assets/images/public/general/" . $filename);
            $img = Image::make($image);
            $img->fit(1200, 250)->save($location);

            $competition_image->filename         = $filename;

        }else{
            $competition_image->filename         = $competition_image->filename;

        }


        $competition_image->competition_id      =   $request->input('competition_id');
        $competition_image->brand_id            =   $request->input('brand_id');
        $competition_image->save();

        return redirect()->route('admin.leaderboard.index')->with('success', 'Image has been successfully created.');


    }

    public function update(Request $request, $id)
    {
        //

        $competition_image  = CompetitionImage::find($id);
        //handle file upload
        if($request->hasfile('filename')){
            //return asset('/assets/images/properties/'.$property->default_filename);
            if($competition_image->filename != ""){

                if(file_exists(public_path() . '/assets/images/public/general/'.$competition_image->filename)){
                    unlink('assets/images/public/general/'.$competition_image->filename);
                }
            }

                $image = $request->file('filename');
                $filename = rand() . '.' .$image->getClientOriginalExtension();
                $location = public_path("assets/images/public/general/" . $filename);

                //$location = public_path("assets/images/properties/" . $filename);
                $img = Image::make($image);
                $img->fit(1200, 250)->save($location);
                //$path = $request->file('filename')->move('assets/images/admin/general', $filenameToStore);
                $competition_image->filename          = $filename;

        }else{

            $competition_image->filename          = $competition_image->filename  ;
        }


        $competition_image->competition_id      =   $request->input('competition_id');
        $competition_image->brand_id            =   $request->input('brand_id');
        $competition_image->save();

        return redirect()->route('admin.leaderboard.index')->with('success', 'Image has been successfully Updated.');


    }

}
