<?php declare(strict_types=1);

namespace Database\Factories;

use App\Models\Post;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Post::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $title = $this->faker->sentence(4, true);
        return [
            'id'      => $this->faker->uuid(),
            'title'   => $title,
            'slug'    => substr(strtolower(str_replace(' ', '-', $title)), 0, 50),
            'content' => $this->faker->text(300),
        ];
    }
}
