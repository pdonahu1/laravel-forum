<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Collection;
use App\Models\User;
use Illuminate\Support\Facades\File;
use SplFileInfo;
use App\Support\PostFixtures;
use App\Models\Topic;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            
            'user_id' => User::factory(),
            'topic_id' => Topic::factory(),
            'title' => str(fake()->sentence)->beforeLast('.')->title(),
            'body' => $body = Collection::times(4, fn () => fake()->realText(1250))->join(PHP_EOL . PHP_EOL),
            'html' => str($body)->markdown(),
            'likes_count' => 0,
        ];
    }
    public function withFixture(): static
    {
        return $this->sequence(...PostFixtures::getFixtures());
    }
    
}
