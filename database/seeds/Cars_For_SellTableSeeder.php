<?php

use Illuminate\Database\Seeder;
use App\Model\Car\Car_For_Sell;

class Cars_For_SellTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Car_For_Sell::class, 30)->create();
    }
}
