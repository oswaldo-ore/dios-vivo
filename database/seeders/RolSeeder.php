<?php

namespace Database\Seeders;

use App\Models\Rol;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rol = new Rol();
        $rol->name = "super admin";
        $rol->save();
        $rol1 = new Rol();
        $rol1->name = "administrador";
        $rol1->save();
        $rol1 = new Rol();
        $rol1->name = "secretaria";
        $rol1->save();
        $user = new User();
        $user->name ="oswaldo";
        $user->last_name = "Orellana vasquez";
        $user->ci = "12345678";
        $user->email = "angeloscuro1234545@gmail.com";
        $user->telephone = "12345678";
        $user->password = Hash::make("12345678");
        $user->rol_id = 2;
        $user->save();
    }
}
