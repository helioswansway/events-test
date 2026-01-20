<?php

namespace App\Http\Controllers\Exec;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Exec;
use Image;
use DB;

class AccountController extends Controller
{
    //
   // dd(t);
   // $exec   = Exec::find(auth('exec')->user()->id));
    //

    public function account() {
        $exec =    Exec::find(auth('exec')->user()->id);
        return view('exec.account.index')
                ->with('exec', $exec);
    }

    public function update(Request $request) {

        $exec = Exec::find(auth('exec')->user()->id);
        //Handles Form validation

        $this->validate($request, [
            'name' => 'required',
            'email' => 'required',
        ]);


        if($request->hasfile('filename')){
            //return asset('/assets/images/properties/'.$property->default_filename);
            if($exec->filename != ""){

                if(file_exists(public_path() . '/assets/images/public/general/'.$exec->filename)){
                    unlink('assets/images/public/general/'.$exec->filename);
                }
            }

                $image = $request->file('filename');
                $filename = rand() . '.' .$image->getClientOriginalExtension();
                $location = public_path("assets/images/public/general/" . $filename);

                //$location = public_path("assets/images/properties/" . $filename);
                $img = Image::make($image);
                $img->fit(255, 255)->save($location);
                //$path = $request->file('filename')->move('assets/images/admin/general', $filenameToStore);

                $exec->filename = $filename;

        }else{

            $exec->filename = $exec->filename  ;
        }

        // if(!empty($request->input('password'))){
        //     $exec->password    = bcrypt($request->input('password'));
        // }

        //return $request->all();
        $exec->name = $request->input('name');
        $exec->email = $request->input('email');
        $exec->mobile = $request->input('mobile');
        $exec->dealership_code = auth('exec')->user()->dealership_code;
        $exec->specialised = $request->input('specialised');
        $exec->description = $request->input('description');

        $exec->save();
        if($request->input('update_mobile') == 1) {
            return redirect()->route('exec.dashboard')->with('success', 'Thank you! Your Mobile have been updated successfully!');

        }else{
            return redirect()->route('exec.account')->with('success', 'Your details have beed successfuly updated.');

        }

    }

}
