<?php

use Illuminate\Database\Seeder;

class Solar_priceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('solar_prices')->insert([
            'oli82price' => '6.25',
            'oli92price' => '7.5',
            'oli95price' => '8.5',
            'solarprice' => '6.75',
            'gasprice' => '3.5',
        ]);
    }
}
