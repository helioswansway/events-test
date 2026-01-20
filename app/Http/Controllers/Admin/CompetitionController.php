<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\CompetitionImage;
use App\Models\Competition;
use App\Models\SaleLeague;
use App\Leaderboard;
use DB;

class CompetitionController extends Controller
{
    //

    public function create()
    {
        //

        $competitions = Competition::where('archived', 0)->orderBy('active', 'DESC')->get();
        return view('admin.leaderboard.competitions.index')
                ->with('competitions', $competitions);

    }

    public function store(Request $request)
    {
        //
        $competition = new Competition;

        $competition->name            =   $request->name;
        $competition->active          =   $request->active;
        $competition->end_date        =   $request->end_date;
        $competition->save();
        return $competition->id;
    }

    public function update(Request $request)
    {
        //

        $competition =  Competition::find($request->id);

        $competition->name            =   $request->name;
        $competition->active          =   $request->active;
        $competition->end_date        =   $request->end_date;
        $competition->save();


    }

    public function archive(Request $request)
    {
        //

        $competition =  Competition::find($request->id);

        $competition->archived          =   1;
        $competition->active            =   0;

        $competition->save();


    }

    public function archived()
    {
        //

        $competitions = Competition::where('archived', 1)->orderBy('updated_at', 'DESC')->get();

        return view('admin.leaderboard.competitions.archived')
                ->with('competitions', $competitions);

    }

    public function editArchived($id)
    {
        //

        $competitions       =   Competition::select('competitions.*')
                                ->where('id', $id)
                                ->get();

        $competition = Competition::find($id);

        return view('admin.leaderboard.competitions.edit-archived')
                ->with('competition', $competition)
                ->with('competitions', $competitions);

    }

    public function updateArchived(Request $request, $id)
    {
        //

        //return "Updating...";

        //return $request->all();

        $competition = Competition::find($id);
       // dd($customer);
        $competition->active            =   $request->input('active');
        $competition->archived          =   $request->input('archived');
        $competition->end_date          =   $request->input('end_date');
        $competition->name              =   $request->input('name');

        $competition->save();

        return redirect()->route('admin.competition.archived')->with('success', '['.$competition->name . '] was successfully updated.');
    }



    //returns Competition league based on competition ID
    public function showCompetitionLeague(Request $request)
    {
        //
        $competition        =   Competition::find($request->id);


        $sales  =   SaleLeague::select('sale_leagues.*')
                                    ->join('competition_leaderboard', 'competition_leaderboard.leaderboard_id', 'sale_leagues.leaderboard_id')
                                    ->join('competitions', 'competitions.id', 'competition_leaderboard.competition_id')
                                    ->where('competition_leaderboard.competition_id', $competition->id)
                                    ->groupBy('sale_leagues.leaderboard_id')
                                    //->orderBy('total', 'DESC')
                                    ->orderBy('created_at', 'ASC')
                                    ->paginate(30);


        return view('admin.leaderboard._show-competition-league')
                ->with('competition', $competition)
                ->with('sales', $sales);

    }

    public function delete(Request $request)
    {

        //return $request->id;

        //Deletes competition_leaderboard pivot table that's associated with competition_id
        $competition_leaderboard    =  DB::table('competition_leaderboard')->where('competition_id', $request->id)->delete();
        //Deletes all sales_leagues that has competition_id
        $sales_league               =  SaleLeague::where('competition_id', $request->id)->delete();
        //Finds the competition
        $competition                =  Competition::find($request->id);
        //Gets the competition image
        $competition_image          =  CompetitionImage::where('competition_id',$competition->id)->first();
        //Checks if competition_image has a file, if so it will be removed and delete
        if(isset($competition_image->filename)){
            if(file_exists(public_path() . '/assets/images/public/general/'.$competition_image->filename)){
                unlink('assets/images/public/general/'.$competition_image->filename);
            }

            $competition_image->delete();
        }

        //Deeletes the competion
        $competition->delete();

    }

}
