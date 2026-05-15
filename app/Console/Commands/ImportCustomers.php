<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;
use App\Book;
use Spatie\SimpleExcel\SimpleExcelReader;
use Illuminate\Support\Facades\DB;

class ImportCustomers extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:customers {event_id} {dealership_code}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import customers from a CSV file';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $file_location = public_path("csv/customers.xlsx");

        SimpleExcelReader::create($file_location)
            ->noHeaderRow()
            ->getRows()
            ->chunk(100, function ($rows) {
                DB::transaction(function () use ($rows) {
                    $rows->each(function(array $row){
                        Book::updateOrCreate(
                            ['customer_number' => $row[0]],
                            [
                                'title' => $row[1],
                                'name' => $row[2],
                                'surname' => $row[3],
                                'address_1' => $row[4],
                                'address_2' => $row[5],
                                'address_3' => $row[6],
                                'address_4' => $row[7],
                                'address_5' => $row[8],
                                'post_code' => $row[9],
                                'vehicle_reg' => $row[10],
                                'vehicle_description' => $row[11],
                                'home_phone' => $row[12],
                                'mobile' => $row[13],
                                'email' => $row[14],
                                'password' => Hash::make('Rreenn84?he'),
                                'event_id' => $this->argument('event_id'),
                                'dealership_code' => $this->argument('dealership_code'),
                            ]);
                    });
                });
            });
    }
}
