<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\JobTitle;
use App\Leaderboard;
use DB;

class JobTitleController extends Controller
{
    //

    public function index()
    {
        $job_titles = JobTitle::orderBy('name', 'ASC')->get();
        return view('admin.leaderboard.job-titles.index')
            ->with('job_titles', $job_titles);
    }

    public function create()
    {

        $job_titles = JobTitle::orderBy('name', 'ASC')->get();

        return view('admin.leaderboard.job-titles.index')
            ->with('job_titles', $job_titles);
    }

    public function store(Request $request)
    {
        //Job Title
        $job_title              = new JobTitle;

        $job_title->name        =   $request->name;
        $job_title->save();

    }

    public function edit($id)
    {
        //
        $job_title     = JobTitle::find($id);
        return view('admin.leaderboard.job-titles.edit')
                ->with('job_title', $job_title);

    }


    public function update(Request $request)
    {
        //

        $job_title              =  JobTitle::find($request->id);

        $job_title->name        =   $request->name;
        $job_title->save();


    }

    public function delete(Request $request)
    {

        $job_title          =   JobTitle::find($request->id);
        $user               =   Leaderboard::where('job_title_id', $request->id)->first();

        if($user){
            return redirect()->route('admin.job.titles.index')->with('warning',  'You aren unable to delete current Job Title because it\'s assigned to Users.');
        }


        $job_title->delete();
        //return redirect()->route('admin.job.title.index')->with('success', $job_title->name . ' has been deleted successfully.');

    }

}
