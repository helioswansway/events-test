<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PotCampaign;
use App\Models\PotList;

class PotCampaignController extends Controller
{
    public function index()
    {
        //
        $campaigns = PotCampaign::orderBy('order', 'ASC')->get();

        return view('admin.call-pots.campaigns.index', [
            'campaigns' => $campaigns,
        ]);

    }

    //Sorts Items position
    public function itemPosition(Request $request)
    {

        if($request->ajax()){

            $sorting    = $request->input('update');
            $positions  = $request->input('positions');

            foreach ($positions as $order) {
                $id = $order[0];
                $newPosition = $order[1];
                $campaign = PotCampaign::where('id', '=', $id)->update(array('order' => $newPosition));
            }


        }
    }

    //
    public function create()
    {
        //
        $campaigns = PotCampaign::orderBy('active', 'DESC')->get();
        return view('admin.call-pots.campaigns.create')
                ->with('campaigns', $campaigns);

    }


    public function store(Request $request)
    {
        //
        $campaign = new PotCampaign;

        $campaign->name = $request->name;
        $campaign->active = $request->active;
        $campaign->end_date = $request->end_date;
        $campaign->save();

        return redirect()->route('admin.pot-campaign.index')->with('success', '['. $campaign->name . '] has been successfully created');

    }

    public function edit($id)
    {
        //
        $campaign = PotCampaign::find($id);
        return view('admin.call-pots.campaigns.edit')
                ->with('campaign', $campaign);
    }

    public function update(Request $request, $id)
    {
        //

        $campaign =  PotCampaign::find($id);


        $campaign->name = $request->name;
        $campaign->active = $request->active;
        $campaign->end_date = $request->end_date;
        $campaign->save();

        return redirect()->route('admin.pot-campaign.index')->with('success', '['. $campaign->name . '] has been successfully updated');

    }


    public function delete($id)
    {

        //######################################
        //TODO
        //######################################
        //Delete all Pot Lists

        //Finds the Campaign
        $campaign = PotCampaign::find($id);

        $pot_list = PotList::where('pot_campaign_id', $campaign->id)->delete();

        //Deeletes the competion
        $campaign->delete();
        return redirect()->route('admin.pot-campaign.index')->with('success', '['. $campaign->name . '] has been successfully delete');


    }

}
