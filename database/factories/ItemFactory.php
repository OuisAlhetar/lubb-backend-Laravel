<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\App;

class ItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Item::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'section_id' => \App\Models\Section::factory(),
            'title' => $this->faker->sentence(4),
            'cover_image' => $this->faker->imageUrl,
            'author_or_guest' => $this->faker->name,
            'release_year' => $this->faker->year,
//            'category_id' => Category::inRandomOrder()->first()->id, // Random category ID
            'short_summary' => $this->faker->paragraph,
            'detailed_summary' => $this->faker->text,
//            'tags' => $this->faker->words(5, true),
        ];
    }
}
