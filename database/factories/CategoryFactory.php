<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $name = $this->faker->words(3 ,true);
        return [
            'parent_id'=> null,
            'name' => $name, // 'Lorem Ipsom Wat'
            'slug' => Str::slug($name),  // 'Lorem-Ipsom-Wat'
            'description' => $this->faker->sentences(1 , true),
            'image' => $this->faker->imageUrl(), 
        ];
    }
}
