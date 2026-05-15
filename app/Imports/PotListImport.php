<?php

namespace App\Imports;

use App\Models\PotList;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

use Maatwebsite\Excel\Concerns\ToModel;
use Response;
use Carbon\Carbon;


class PotListImport implements ToModel, WithHeadingRow, WithBatchInserts, WithChunkReading
{
    use RemembersRowNumber;

    use Importable;

    protected $pot_campaign_id;
    protected $dealership_id;

    public function  __construct($pot_campaign_id, $dealership_id)
    {
        $this->pot_campaign_id = $pot_campaign_id;
        $this->dealership_id = $dealership_id;
    }


    public function model(array $row)
    {

        $currentRowNumber = $this->getRowNumber();


        PotList::updateOrCreate([
                'email' => $row['email'],
            ],[
            //
            'title' => $row['title'], //$row[0]
            'first_name' => $row['first_name'],
            'last_name' => $row['last_name'],
            'registration' => $row['registration'],
            'email' => $row['email'],
            'phone' => $row['phone'],
            'customer_type' => $row['customer_type'],
            'model' => $row['model'],
            'description' => $row['description'],
            'sale_date' => $row['sale_date'],
            'last_work_date' => $row['last_work_date'],
            'mileage' => $row['mileage'],
            'pot_campaign_id' => $this->pot_campaign_id,
            'dealership_id' => $this->dealership_id,
        ]);
    }

    public function batchSize(): int
    {
        return 300;
    }

    public function chunkSize(): int
    {
        return 300;
    }
}
