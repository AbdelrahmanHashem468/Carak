<?php

use Illuminate\Database\Seeder;
use App\Model\Service\Offer;

class OffersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Offer::class, 200)->create();
    }
}
