<?php

use Illuminate\Database\Seeder;
use App\Model\Service\Notification;

class NotificationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Notification::class, 100)->create();
    }
}
