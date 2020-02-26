<?php

use Illuminate\Database\Seeder;
use App\Model\Group\Group;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Group::class, 50)->create();
    }
}
