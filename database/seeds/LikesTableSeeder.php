<?php

use Illuminate\Database\Seeder;
use App\Model\Group\Like;

class LikesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Like::class, 50)->create();

    }
}
