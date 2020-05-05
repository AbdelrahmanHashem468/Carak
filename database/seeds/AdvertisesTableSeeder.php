<?php

use Illuminate\Database\Seeder;

class AdvertisesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('advertises')->insert([
            'photo' => 'https://res.cloudinary.com/cark/image/upload/v1586258373/rdnokj4vf7ir4flrsfml.jpg'
        ]);
    }
}
