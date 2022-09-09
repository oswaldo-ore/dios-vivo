<?php

namespace Database\Seeders;

use App\Models\Business;
use App\Models\Rol;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Business::getBusiness();



        $this->call([
            RolSeeder::class,
            CategorySeeder::class,
            //BookSeeder::class,
        ]);

        User::factory(10)->create();
    }
}
