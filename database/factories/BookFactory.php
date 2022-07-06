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
        return [
            'date' => $this->faker->dateTimeBetween("-2 years"),
            "description" => $this->faker->paragraph(1),
            "debe" =>  $haber ? 0 : $this->faker->randomFloat(2,0,300)*(-1),
            "haber" => $haber ? $this->faker->randomFloat(2,0,300):0,
            "type" => $haber ? "ingreso " : "egreso",
            "category_id" => $category->id,
        ];
    }
}
