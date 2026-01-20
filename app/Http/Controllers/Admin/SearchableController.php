<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\PotCampaign;
use App\Models\PotList;
use Carbon\Carbon;
use Illuminate\Http\Request;

use DB;

class SearchableController extends Controller
{
    //

        //Search Pot list Campaigns
        public function searchPotList(Request $request)
        {



            $user = auth()->user();

            $campaigns = $this->campaignsWithpotList();

            $camp = PotCampaign::find($request->campaign_id);

            $term = $request->query('term', '');

            if($this->role()->name == 'super' || $this->role()->name == 'super-admin'){

                $pot_lists = PotList::search($term)
                                ->join('pot_campaigns', 'pot_campaigns.id', 'pot_lists.pot_campaign_id')
                                ->where('pot_campaigns.id', $request->campaign_id)
                                ->whereNotNull('pot_lists.phone')
                                ->orderBy('pot_lists.created_at', 'ASC')
                                ->groupBy('pot_lists.id')
                                ->paginate('30')->withQueryString();

            }else{

            $pot_lists = PotList::search($term)
                            ->join('pot_campaigns', 'pot_campaigns.id', 'pot_lists.pot_campaign_id')
                            ->join('dealerships', 'dealerships.id', 'pot_lists.dealership_id')
                            ->join('admin_dealership', 'admin_dealership.dealership_id', 'dealerships.id')
                            ->where('admin_dealership.admin_id', $user->id)
                            ->where('pot_campaigns.id', $request->campaign_id)
                            ->whereNotNull('pot_lists.phone')
                            ->orderBy('pot_lists.created_at', 'ASC')
                            ->groupBy('pot_lists.id')
                            ->paginate(20)->withQueryString();

            }

            //return $pot_lists->count();

            $dealerships = $this->fetchDealerships($request->campaign_id);

            return view('admin.call-pots.search.pot-list-results', compact('pot_lists', 'campaigns', 'dealerships', 'camp'));

        }

        public function searchSaleDate(Request $request){

            $first_sale_date = Carbon::parse($request->first_sale_date)->format('Y-m-d');
            $last_sale_date = Carbon::parse($request->last_sale_date)->format('Y-m-d');

            $user = auth()->user();

            $campaigns = $this->campaignsWithpotList();

            $camp = PotCampaign::find($request->campaign_id);

            if($this->role()->name == 'super' || $this->role()->name == 'super-admin'){

                $pot_lists = PotList::select('pot_lists.*')
                                ->join('pot_campaigns', 'pot_campaigns.id', 'pot_lists.pot_campaign_id')
                                ->where('pot_campaigns.id', $request->campaign_id)
                                ->whereDate('pot_lists.sale_date', '>=', $first_sale_date)
                                ->whereDate('pot_lists.sale_date', '<=', $last_sale_date)
                                ->whereNotNull('pot_lists.phone')
                                ->orderBy('pot_lists.created_at', 'ASC')
                                ->groupBy('pot_lists.id')
                                ->paginate('30')->withQueryString();


            }else{

                    $pot_lists = PotList::select('pot_lists.*')
                            ->join('pot_campaigns', 'pot_campaigns.id', 'pot_lists.pot_campaign_id')
                            ->join('dealerships', 'dealerships.id', 'pot_lists.dealership_id')
                            ->join('admin_dealership', 'admin_dealership.dealership_id', 'dealerships.id')
                            ->where('admin_dealership.admin_id', $user->id)
                            ->where('pot_campaigns.id', $request->campaign_id)
                            ->whereDate('pot_lists.sale_date', '>=', $first_sale_date)
                            ->whereDate('pot_lists.sale_date', '<=', $last_sale_date)
                            ->whereNotNull('pot_lists.phone')
                            ->orderBy('pot_lists.created_at', 'ASC')
                            ->groupBy('pot_lists.id')
                            ->paginate(20)->withQueryString();

            }


            $dealerships = $this->fetchDealerships($request->campaign_id);

            return view('admin.call-pots.search.pot-list-results', compact('pot_lists', 'campaigns', 'dealerships', 'camp'));
        }



        public function searchLastWorkDate(Request $request){

            $start_date = Carbon::parse($request->start_date)->format('Y-m-d');
            $end_date = Carbon::parse($request->end_date)->format('Y-m-d');

             $user = auth()->user();

             $campaigns = $this->campaignsWithpotList();

             $camp = PotCampaign::find($request->campaign_id);

             $term = $request->query('term', '');


             if($this->role()->name == 'super' || $this->role()->name == 'super-admin'){

                 $pot_lists = PotList::select('pot_lists.*')
                                 ->join('pot_campaigns', 'pot_campaigns.id', 'pot_lists.pot_campaign_id')
                                 ->where('pot_campaigns.id', $request->campaign_id)
                                 ->whereDate('pot_lists.last_work_date', '>=', $start_date)
                                 ->whereDate('pot_lists.last_work_date', '<=', $end_date)
                                 ->whereNotNull('pot_lists.phone')
                                 ->orderBy('pot_lists.created_at', 'ASC')
                                 ->groupBy('pot_lists.id')
                                 ->paginate('30')->withQueryString();


             }else{


             $pot_lists = PotList::select('pot_lists.*')
                             ->join('pot_campaigns', 'pot_campaigns.id', 'pot_lists.pot_campaign_id')
                             ->join('dealerships', 'dealerships.id', 'pot_lists.dealership_id')
                             ->join('admin_dealership', 'admin_dealership.dealership_id', 'dealerships.id')
                             ->where('admin_dealership.admin_id', $user->id)
                             ->where('pot_campaigns.id', $request->campaign_id)
                             ->whereDate('pot_lists.last_work_date', '>=', $start_date)
                             ->whereDate('pot_lists.last_work_date', '<=', $end_date)
                             ->whereNotNull('pot_lists.phone')
                             ->orderBy('pot_lists.created_at', 'ASC')
                             ->groupBy('pot_lists.id')
                             ->paginate(20)->withQueryString();

             }


             $dealerships = $this->fetchDealerships($request->campaign_id);

             return view('admin.call-pots.search.pot-list-results', compact('pot_lists', 'campaigns', 'dealerships', 'camp'));
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

        private function campaignsWithpotList(){
            $campaigns = PotCampaign::join('pot_lists', 'pot_lists.pot_campaign_id', 'pot_campaigns.id')
                            ->orderBy('pot_campaigns.order', 'ASC')
                            ->groupBy('pot_campaigns.id')
                            ->select('pot_campaigns.*')
                            ->where('pot_campaigns.active', 1)
                            ->get();

            return $campaigns;
        }


        public function role(){
            $admin_id = auth('admin')->user()->id;
            $admin = new Admin;
            $role = $admin->adminRole($admin_id);

            return $role;
        }


}
