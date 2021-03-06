<?php declare(strict_types=1);

namespace Database\Seeders;

use App\Models\PersonalAccessToken;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $users = User::factory(5)->make();
        foreach ($users as $user) {
            $user->save();
            $posts = Post::factory()->count(50)->make();
            foreach ($posts as $post) {
                $post->user()->associate($user);
                $post->save();
            }

            $token = new PersonalAccessToken([
                'token'   => md5($user->email),
                'user_id' => $user->id,
            ]);
            $token->save();

            echo "User $user->email has API token $token->id|$token->token \n";
        }
    }
}
