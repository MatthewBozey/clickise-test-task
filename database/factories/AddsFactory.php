<?php

namespace Database\Factories;

use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Adds>
 */
class AddsFactory extends Factory
{
    public function definition(): array
    {
        return [
            'company_id' => Company::inRandomOrder()->first(),
            'title' => $this->faker->sentence,
            'text' => $this->faker->paragraph,
            'status' => $this->faker->randomElement(['Активен', 'В ожидании', 'В архиве']),
            'url' => $this->faker->url,
            'impressions_count' => $this->faker->numberBetween(1000, 100000),
            'crm' => $this->faker->numberBetween(1, 100),
            'budget' => $this->faker->numberBetween(1, 100000000),
            'button_text' => $this->faker->randomElement(['Смотреть', 'Оставить заявку', 'Скачать', 'Подробнее']),
        ];
    }
}
