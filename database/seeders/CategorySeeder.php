<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*Category::create([
            "name" => "activo",
        ]);
        Category::create([
            "name" => "pasivo",
        ]);
        Category::create([
            "name" => "patrimonio",
        ]);*/
        Category::create([
            "name" => "ingreso",
        ]);
        Category::create([
            "name" => "egreso",
        ]);

        Category::create([
            "name" => "Ofrendas",
            "category_id" => 1,
        ]);

        Category::create([
            "name" => "Donación",
            "category_id" => 1,
        ]);
        Category::create([
            "name" => "Energía Eléctrica",
            "category_id" => 2,
        ]);

        Category::create([
            "name" => "Agua potable",
            "category_id" => 2,
        ]);
    }
}
