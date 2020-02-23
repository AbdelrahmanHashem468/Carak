<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(UsersTableSeeder::class);
        $this->call(CarsTableSeeder::class);
        $this->call(Cars_ModelTableSeeder::class);
        $this->call(Cars_PriceTableSeeder::class);
        $this->call(Spare_partTableSeeder::class);
        $this->call(Cars_For_SellTableSeeder::class);
        $this->call(GroupsTableSeeder::class);
        $this->call(PostsTableSeeder::class);
        $this->call(RepliesTableSeeder::class);
        $this->call(LikesTableSeeder::class);
        $this->call(Maintenance_TypesTableSeeder::class);
        $this->call(Maintenance_CentersTableSeeder::class);





    }
}
