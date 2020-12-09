<?php

namespace Database\Factories;

use App\Models\Campaign;
use Illuminate\Database\Eloquent\Factories\Factory;

class CampaignFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Campaign::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->company,
            'description' => $this->faker->paragraph,
            'image' => 'photos/assets/campaign/Charity.jpg',
            'address' => $this->faker->streetAddress,
            'required' => 5000000,
            'collected' => 4500000,
        ];
    }
}
