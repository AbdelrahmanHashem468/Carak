<?php

use Illuminate\Database\Seeder;
use App\Model\Car\Spare_part;

class Spare_partTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Spare_part::class, 100)->create();
    }
}
