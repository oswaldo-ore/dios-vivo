<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;

class BookFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $category = Category::whereNotNull("category_id")->inRandomOrder()->first();
        $haber = $category->category_id == 1 ? 1 : 0;
        $saldo = $this->faker->randomFloat(2,0,10000);
        return [
            'date' => $this->faker->dateTimeBetween("-4 years"),
            "description" => $this->faker->paragraph(1),
            "debe" =>  $haber ? 0 : $saldo ,
            "haber" => $haber ? $saldo:0,
            "type" => $haber ? "ingreso " : "egreso",
            "saldo" =>  $saldo,
            "category_id" => $category->id,
        ];
    }
}
