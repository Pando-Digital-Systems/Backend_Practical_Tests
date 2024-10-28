<?php
namespace Database\Factories;

use App\Models\TutorProduct;
use Illuminate\Database\Eloquent\Factories\Factory;

class TutorProductFactory extends Factory
{
    protected $model = TutorProduct::class;

    public function definition()
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'image' => $this->faker->imageUrl(),
            'team_id' => \App\Models\Team::factory(), // Optionally create a team for the relationship
        ];
    }
}
