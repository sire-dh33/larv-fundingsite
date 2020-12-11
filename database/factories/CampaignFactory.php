<?php

namespace Database\Factories;

use App\Models\Campaign;
use Illuminate\Database\Eloquent\Factories\Factory;
// use Illuminate\Support\Facades\Storage;
// use Illuminate\Support\Facades\File;

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
        // $dir = '/photos/campaign'; // public/photos/campaign
        // if($files = \Storage::disk('web')->allFiles('photos/campaign')) {
        //     $path = $files[array_rand($files)];
        //     $url = Storage::url($path);
        // }

        return [
            'title' => $this->faker->company,
            'description' => $this->faker->paragraph,
            'image' => 'photos/campaign/Charity.jpg',
            'address' => $this->faker->streetAddress,
            'required' => 5000000,
            'collected' => $this->faker->numberBetween(4000000, 5000000),
        ];
    }
}
