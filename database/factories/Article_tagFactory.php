<?php

namespace Database\Factories;

use App\Models\Article;
use App\Models\Tag;
use App\Models\Article_tag;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class Article_tagFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $articleIndex = 1;

        return [
            'article_id' => $articleIndex++,
            'tag_id' => Tag::all()->random()->id,
        ];
    }

    /**
     * Configure the model factory.
     *
     * @return $this
     */
    public function configure(): self
    {
        return $this->afterMaking(function (Article_tag $articleTag) {
            for ($i = 0; $i < 2; $i++) {
                Article_tag::create([
                    'article_id' => $articleTag->article_id,
                    'tag_id' => Tag::all()->random()->id,
                ]);
            }
        });
    }
}
