<?php

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class AdminTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'phonenumber' => '01140073150',
            'photo' => 'https://res.cloudinary.com/cark/image/upload/v1595782679/kccphfkzv1poktl9y8m1.jpg',
            'role' => 'admin',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),   //'$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
        ]);
    }
}
