<?php

namespace App\Exports;

use App\Models\PotList;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\FromCollection;

class PotListExport implements FromView
{

    protected $pot_campaign_id;

    public function  __construct($pot_campaign_id)
    {
        $this->pot_campaign_id = $pot_campaign_id;
    }

    /**
    * @return \Illuminate\Support\Collection
    */

    public function view(): View
    {

        $pot_lists = PotList::where('pot_lists.pot_campaign_id', $this->pot_campaign_id)->whereNotNull('phone')->get();

        return view('admin.exports.pot-list', [
            'pot_lists' => $pot_lists
        ]);

    }

}
