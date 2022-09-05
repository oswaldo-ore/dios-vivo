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
        $rol = new Rol();
        $rol->name = "super admin";
        $rol->save();
        $rol1 = new Rol();
        $rol1->name = "administrador";
        $rol1->save();
        // \App\Models\User::factory(10)->create();
        $user = new User();
        $user->name ="oswaldo";
        $user->last_name = "Orellana vasquez";
        $user->ci = "12345678";
        $user->email = "angeloscuro1234545@gmail.com";
        $user->telephone = "12345678";
        $user->password = Hash::make("12345678");
        $user->rol_id = $rol->id;
        $user->save();
        $this->call([
            CategorySeeder::class,
            BookSeeder::class,
        ]);
    }
}
