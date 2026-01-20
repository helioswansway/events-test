<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PotCampaign;
use App\Models\PotList;
use App\Models\Dealership;
use App\Models\Admin;
use App\Models\Brand;

use App\Imports\PotListImport;
use App\Exports\PotListExport;

use Carbon\Carbon;
use Excel;
use Validator;
use DB;

class PotListController extends Controller
{
    //

    public function index() {

        $admin = new Admin;
        $campaigns = $this->campaignsWithpotList();
        return view('admin.call-pots.index')
            ->with('admin', $admin)
            ->with('campaigns', $campaigns);

    }

    public function upload()
    {
        $dealerships = Dealership::all();
        $campaigns = PotCampaign::where('active', 1)->get();

        return view('admin.call-pots.upload', [
            'dealerships' => $dealerships,
            'campaigns' => $campaigns,
        ]);
    }

    //Stores and updates all Customers from a spreadsheet
    public function store(Request $request)
    {

        //Validates File extention
        $validator = Validator::make($request->all(), [
            'filename' => 'required|mimes:xlsx,xls,csv,txt'
        ]);


        //Only returns true if file extention matches requirements
        if($validator->passes()){

            //Imports all new Booking Customers
            $admin_id = auth('admin')->user()->id;
            $dealership_id = $request->dealership_id;
            $pot_campaign_id = $request->campaign_id;

            $data = Excel::import(new PotListImport($pot_campaign_id, $dealership_id), $request->file('filename'));
            //Returns an error if extention not meet.

            return redirect()
                        ->route('admin.pot-list.index')
                        ->with('success', 'Leaderboard Account users been inserted successfully.');
        }else{
            //Returns an error if extention not meet.
            return redirect('/dashboard/leaderboard/upload')
            ->with('error', 'File format must be xlsx,xls or csv.');
        }

    }

    public function update(Request $request, $id)
    {
        //
        //return $request->all();
        $admin_id = auth('admin')->user()->id;
        $list =  PotList::find($id);

        $list->admin_id = $admin_id;
        $list->call_attempts = $request->call_attempts;
        $list->call_status = $request->call_status;
        $list->message_left = $request->message_left;
        $list->booking_status = $request->booking_status;
        $list->notes = $request->notes;
        $list->save();

        return back()->with('success', 'Pot List ['. $list->first_name . '] has been successfully updated');

    }

    public function form($id)
    {
        //
        $admin_id = auth('admin')->user()->id;
        $list =  PotList::find($id);

        $list->admin_id = $admin_id;
        $list->locked = 1;
        $list->save();

        return view('admin.call-pots._ajax-form')
            ->with('list', $list);
    }

    //Exports all updated registrations into a CSV file save in the database
    public function export($campaign_id){
        $date = Carbon::now()->format('d-M-Y');

        $campaign = PotCampaign::find($campaign_id);

        $campaign_name = strtolower(str_replace(" ", "-", $campaign->name));
    //    / return $campaign_id;
        return Excel::download(new PotListExport($campaign_id), 'post-list-'.$campaign_name."-".$date.'.csv');
    }

    //returns Competition league based on competition ID
    public function showCampaignList($id)
    {
        $admin_id = auth('admin')->user()->id;

        $campaigns = $this->campaignsWithpotList();

        $camp = PotCampaign::find($id);


        if($this->role()->name == 'super' || $this->role()->name == 'super-admin'){

            $pot_lists = PotList::select('pot_lists.*')
                            ->join('pot_campaigns', 'pot_campaigns.id', 'pot_lists.pot_campaign_id')
                            ->where('pot_campaigns.id', $id)
                            ->whereNotNull('phone')
                            ->orderBy('pot_lists.created_at', 'ASC')
                            ->paginate(20);

        }else{

            $pot_lists = PotList::select('pot_lists.*')
                            ->join('pot_campaigns', 'pot_campaigns.id', 'pot_lists.pot_campaign_id')
                            ->join('dealerships', 'dealerships.id', 'pot_lists.dealership_id')
                            ->join('admin_dealership', 'admin_dealership.dealership_id', 'dealerships.id')
                            ->where('admin_dealership.admin_id', $admin_id)
                            ->where('pot_campaigns.id', $camp->id)
                            ->whereNotNull('pot_lists.phone')
                            ->orderBy('pot_lists.created_at', 'ASC')
                            ->paginate(20);

        }


        $dealerships = $this->fetchDealerships($camp->id);

        return view('admin.call-pots.show-pot-list')
                ->with('dealerships', $dealerships)
                ->with('campaigns', $campaigns)
                ->with('camp', $camp)
                ->with('pot_lists', $pot_lists);

    }

    public function byDealership($campaign_id, $dealership_id){
        $camp = PotCampaign::find($campaign_id);

        $campaigns = $this->campaignsWithpotList();

        $pot_lists = PotList::select('pot_lists.*')
                        ->join('pot_campaigns', 'pot_campaigns.id', 'pot_lists.pot_campaign_id')
                        ->join('dealerships', 'dealerships.id', 'pot_lists.dealership_id')
                        ->join('admin_dealership', 'admin_dealership.dealership_id', 'dealerships.id')
                        ->where('dealerships.id', $dealership_id)
                        ->where('pot_campaigns.id', $camp->id)
                        ->whereNotNull('pot_lists.phone')
                        ->orderBy('pot_lists.created_at', 'ASC')
                        ->groupBy('pot_lists.email')
                        ->paginate(20);



        $dealerships = $this->fetchDealerships($camp->id);

        return view('admin.call-pots.show-pot-list')
                ->with('dealerships', $dealerships)
                ->with('campaigns', $campaigns)
                ->with('camp', $camp)
                ->with('pot_lists', $pot_lists);

    }

    //Return booked pot lists
    public function booked($id)
    {
        return $this->potListStatus($id, 'booked');
    }


    //Return in_progres pot lists
    public function inProgress($id)
    {
        return $this->potListStatus($id, 'in_progress');
    }

    //Return not_interest pot lists
    public function notInterest($id)
    {
        return $this->potListStatus($id, 'not_interested');
    }

    private function potListStatus($id, $status){

        $campaigns = $this->campaignsWithpotList();

        $camp = PotCampaign::find($id);

        $pot_lists = PotList::select('pot_lists.*')
                        ->join('pot_campaigns', 'pot_campaigns.id', 'pot_lists.pot_campaign_id')
                        ->where('pot_campaigns.id', $id)
                        ->where('pot_lists.booking_status', $status)
                        ->orderBy('pot_lists.updated_at', 'ASC')
                        ->paginate(20);

        $booking_status = PotList::select('pot_lists.*')
                            ->join('pot_campaigns', 'pot_campaigns.id', 'pot_lists.pot_campaign_id')
                            ->where('pot_campaigns.id', $id)
                            ->where('pot_lists.booking_status', $status)
                            ->orderBy('pot_lists.updated_at', 'ASC')
                            ->first();

        $dealerships = $this->fetchDealerships($camp->id);

        return view('admin.call-pots.show-pot-list')
                ->with('dealerships', $dealerships)
                ->with($status, $booking_status)
                ->with('campaigns', $campaigns)
                ->with('camp', $camp)
                ->with('pot_lists', $pot_lists);
    }

    public function role(){
        $admin_id = auth('admin')->user()->id;
        $admin = new Admin;
        $role = $admin->adminRole($admin_id);

        return $role;
    }

    public function reset($id)
    {
        //

        $list  = PotList::find($id);

        if($list){

            $list->admin_id = NULL;
            $list->locked = 0;
            $list->call_attempts = NULL;
            $list->call_status = NULL;
            $list->message_left = 0;
            $list->booking_status = NULL;
            $list->notes = NULL;
            $list->locked = 0;
            $list->save();
            return redirect()->back()->with('success', 'Pot List has been reset to default!');
        }


    }

    private function fetchDealerships($campaign_id){
        $dealerships = DB::table('dealerships')
                    ->select('dealerships.*')
                    ->join('pot_lists', 'pot_lists.dealership_id', 'dealerships.id')
                    ->join('pot_campaigns', 'pot_campaigns.id', 'pot_lists.pot_campaign_id')
                    ->join('admin_dealership', 'admin_dealership.dealership_id', 'dealerships.id')
                    //->where('admin_dealership.admin_id', $admin_id)
                    ->where('pot_campaigns.id', $campaign_id)
                    ->whereNotNull('pot_lists.phone')
                    ->groupBy('dealerships.id')
                    ->get();

        return $dealerships;
    }

    private function campaignsWithpotList($campaign_id = NULL){

        if($campaign_id){

            $campaigns = PotCampaign::join('pot_lists', 'pot_lists.pot_campaign_id', 'pot_campaigns.id')
                    ->orderBy('pot_campaigns.order', 'ASC')
                    ->groupBy('pot_campaigns.id')
                    ->select('pot_campaigns.*')
                    ->where('pot_campaigns.active', 1)
                    ->where('pot_campaigns.id', $campaign_id)
                    ->get();

                    return $campaigns;
        }else{
            $campaigns = PotCampaign::join('pot_lists', 'pot_lists.pot_campaign_id', 'pot_campaigns.id')
                    ->orderBy('pot_campaigns.order', 'ASC')
                    ->groupBy('pot_campaigns.id')
                    ->select('pot_campaigns.*')
                    ->where('pot_campaigns.active', 1)
                    ->get();

                    return $campaigns;
        }



    }

}
