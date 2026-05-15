<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\PotList;
use App\Models\PotCampaign;

use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Carbon\Carbonite;
use Carbon\CarbonImmutable;

class DeletePotLists extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'potLists:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

        $campaign = PotCampaign::select('id')->where('end_date', '<=', Carbon::now()->subDays(60)->toDateString())->delete();

        if($campaign){
            $pot_lists = PotList::where('pot_campaign_id', $campaign->id)->delete();


            //$pot_lists = PotList::whereDate('created_at', '<=', Carbon::now()->subDays(30))->delete();
            if($pot_lists){
                echo "Deleted Pot Lists older than 60 days";
            }else{
                echo "Didn't Deleted Pot Lists";
            }
        }else{
            echo "Unable to Deleted any Campaigns";
        }

    }
}
