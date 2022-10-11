<?php

namespace Database\Factories;

use DateTime;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Todo>
 */
class TodoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $date = fake()->dateTimeThisMonth('+12 days');
        return [
            'title' => fake()->sentence(),
            'description' => fake()->paragraph(),
            'due_date' => new \MongoDB\BSON\UTCDateTime($date),
        ];
    }
}
