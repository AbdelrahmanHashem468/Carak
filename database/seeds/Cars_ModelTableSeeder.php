<?php

use Illuminate\Database\Seeder;
use App\Model\Car\Car_Model;

class Cars_ModelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Car_Model::class, 30)->create();
    }
}
