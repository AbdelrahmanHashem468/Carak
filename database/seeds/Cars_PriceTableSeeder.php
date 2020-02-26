<?php

use Illuminate\Database\Seeder;
use App\Model\Car\Car_Price;

class Cars_PriceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Car_Price::class, 30)->create();
    }
}
