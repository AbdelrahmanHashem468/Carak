<?php

use App\Model\Maintenance\Maintenance_Center;
use Illuminate\Database\Seeder;

class Maintenance_CentersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Maintenance_Center::class, 50)->create();
    }
}
