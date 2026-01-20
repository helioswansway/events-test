<?php

namespace App\Imports;

use App\Book;
use Maatwebsite\Excel\Concerns\ToModel;

use Maatwebsite\Excel\Concerns\RemembersRowNumber;
use Maatwebsite\Excel\Concerns\WithBatchInserts;
use Maatwebsite\Excel\Concerns\WithChunkReading;

use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Response;
use Carbon\Carbon;

class BooksImport implements ToModel, WithBatchInserts, WithChunkReading
{

    use RemembersRowNumber;

    use Importable;

    protected $event_id;
    protected $dealership_code;
    public function  __construct($event_id, $dealership_code)
    {
        $this->event_id                 = $event_id;
        $this->dealership_code          = $dealership_code;
    }

    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        $currentRowNumber = $this->getRowNumber();

        Book::updateOrCreate([
            'customer_number' => $row[0],
            ],[
            //
            'customer_number'           => $row[0], //$row['customer_number'],
            'title'                     => $row[1], //$row['title'],
            'name'                      => $row[2], //$row['name'],
            'surname'                   => $row[3], //$row['surname'],
            'address_1'                 => $row[4], //$row['address_1'],
            'address_2'                 => $row[5], //$row['address_2'],
            'address_3'                 => $row[6], //$row['address_3'],
            'address_4'                 => $row[7], //$row['address_4'],
            'address_5'                 => $row[8], //$row['address_5'],
            'post_code'                 => $row[9], //$row['post_code'],
            'vehicle_reg'               => $row[10], //$row['vehicle_reg'],
            'vehicle_description'       => $row[11], //$row['vehicle_description'],
            'home_phone'                => $row[12], //$row['home_phone'],
            'mobile'                    => $row[13], //$row['mobile'],
            'email'                     => $row[14], //$row['email'],
            'password'                  => Hash::make('Rreenn84?he'), //$row['vehicle_number'],
            'event_id'                  => $this->event_id,
            'dealership_code'           => $this->dealership_code,
        ]);
    }

    public function batchSize(): int
    {
        return 100;
    }

    public function chunkSize(): int
    {
        return 100;
    }


}
