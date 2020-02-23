<?php

use Illuminate\Database\Seeder;
use App\Model\Maintenance\Maintenance_Type;

class Maintenance_TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Maintenance_Type::class, 50)->create();

    }
}
