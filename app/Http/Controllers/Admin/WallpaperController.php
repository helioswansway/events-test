<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Wallpaper;

use App\Book;
use App\Exec;
use App\Leaderboard;
use App\Models\Admin;

use Image;
use DB;

class WallpaperController extends Controller
{
    //

    public function index()
    {
        $wallpapers = Wallpaper::orderBy('order', 'ASC')->get();

        return view('admin.wallpapers.index')
                ->with('wallpapers', $wallpapers);

    }

         //Sorts Vehicles position
         public function wallpaperPosition(Request $request)
         {

             if($request->ajax()){
                 //return "Ajax Request";
                 $sorting    = $request->input('update');
                 $positions  = $request->input('positions');

                 foreach ($positions as $order) {
                     $id = $order[0];
                     $newPosition = $order[1];
                     $wallpaper = Wallpaper::where('id', '=', $id)->update(array('order' => $newPosition));
                 }
             }
         }

    public function create()
    {
        //

        return view('admin.wallpapers.create');
    }


    // @todo: Look at using storage facade
    public function store(Request $request)
    {

        $wallpaper = new Wallpaper;
        //Handles Form validation
        $this->validate($request, [
            'filename' => 'required',
            'name' => 'required',
            'path' => 'required',
        ],
        [
            'name.required' => 'A name needs to  be created',
            'path.required' => 'A path needs to  be created',
            'filename.required' => 'A filename needs to  be created'
        ]);

        if($request->hasfile('filename')){

            //prev_filename Stored
            $image = $request->file('filename');
            $filename = rand() . '.' .$image->getClientOriginalExtension();
            $location = public_path("assets/images/public/general/" . $filename);
            $img = Image::make($image);
            $img->fit($request->input('width'), $request->input('height'))->save($location);

            $wallpaper->filename         = $filename;

        }else{
            $wallpaper->filename         = $wallpaper->filename;
        }

        $position = DB::table('wallpapers')->max('order');
        $wallpaper->order = $position + 1;

        $wallpaper->name = $request->input('name');
        $wallpaper->description = $request->input('description');
        $wallpaper->path = $request->input('path');
        $wallpaper->width = $request->input('width');
        $wallpaper->height = $request->input('height');

        $wallpaper->save();

        return redirect()->route('admin.wallpaper.index')->with('success', '['. $wallpaper->name . '] has been successfully created.');
    }


    public function edit($id)
    {
        //
        $wallpaper = Wallpaper::find($id);
        return view('admin.wallpapers.edit')
                    ->with('wallpaper', $wallpaper);
    }

    public function update(Request $request, $id)
    {
        //
            $wallpaper = Wallpaper::find($id);


            if($request->hasfile('filename')){
                //return asset('/assets/images/properties/'.$property->default_filename);
                if($wallpaper->filename != ""){

                    if(file_exists(public_path() . '/assets/images/public/general/'.$wallpaper->filename)){
                        unlink('assets/images/public/general/'.$wallpaper->filename);
                    }
                }

                    $image = $request->file('filename');
                    $filename = rand() . '.' .$image->getClientOriginalExtension();
                    $location = public_path("assets/images/public/general/" . $filename);

                    //$location = public_path("assets/images/properties/" . $filename);
                    $img = Image::make($image);
                    $img->fit($request->input('width'), $request->input('height'))->save($location);
                    //$path = $request->file('filename')->move('assets/images/admin/general', $filenameToStore);
                    $wallpaper->filename = $filename;

            }else{

                $wallpaper->filename = $wallpaper->filename  ;
            }


            $wallpaper->name = $request->input('name');
            $wallpaper->description = $request->input('description');
            $wallpaper->path = $request->input('path');
            $wallpaper->width = $request->input('width');
            $wallpaper->height = $request->input('height');

            $wallpaper->save();

            return redirect()->route('admin.wallpaper.index')->with('success', '['. $wallpaper->name . '] has been successfully upadated.');

    }


    public function delete($id)
    {
        //
        $wallpaper = Wallpaper::find($id);

        if($wallpaper){
             //Unlink File

            if(file_exists(public_path() . '/assets/images/public/general/'.$wallpaper->filename)){
                unlink('assets/images/public/general/'.$wallpaper->filename);
            }
            $wallpaper->delete();
            return redirect()->route('admin.wallpaper.index')->with('success', 'Wallpaper [' .$wallpaper->url. '] has been deleted!');
        }

    }


}
