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
            "name" => "ingresos",
        ]);
        Category::create([
            "name" => "egresos",
        ]);

        Category::create([
            "name" => "Ofrendas",
            "category_id" => 1,
        ]);

        Category::create([
            "name" => "Donacion",
            "category_id" => 1,
        ]);
        Category::create([
            "name" => "Energia Electrica",
            "category_id" => 2,
        ]);

        Category::create([
            "name" => "Agua potable",
            "category_id" => 2,
        ]);
    }
}
