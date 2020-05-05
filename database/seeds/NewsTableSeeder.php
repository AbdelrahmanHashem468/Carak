<?php

use Illuminate\Database\Seeder;
use App\Model\Service\News;

class NewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(News::class, 100)->create();
    }
}
