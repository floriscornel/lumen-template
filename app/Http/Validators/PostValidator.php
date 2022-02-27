<?php declare(strict_types=1);

namespace App\Http\Validators;

use App\Models\Post;

class PostValidator
{
    public function rules(Post $post): array
    {
        return [
            'title' => [
                $post->exists ? 'sometimes' : null,
                'required',
                'string',
                'max:255',
            ],
            'content' => [
                $post->exists ? 'sometimes' : null,
                'required',
                'string',
                'max:255',
            ],
        ];
    }

    public function validate(array $data, Post $post): array
    {
        return validator($data, $this->rules($post))->validate();
    }
}
