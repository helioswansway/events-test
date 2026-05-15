<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class CustomerFakeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Book::class, 1300)->create()->each(function($book){
            $book->save();
        });
    }
}
