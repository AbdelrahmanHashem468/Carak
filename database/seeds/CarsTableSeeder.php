<?php

use Illuminate\Database\Seeder;
use App\Model\Car\Car;
class CarsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Car::class, 10)->create();
    }
}
