<?php declare(strict_types=1);

namespace App\Http\Validators;

use App\Models\Template;

class TemplateValidator
{
    public function rules(Template $template): array
    {
        return [
            'title' => [
                $template->exists ? 'sometimes' : null,
                'required',
                'string',
                'max:255',
            ],
            'content' => [
                $template->exists ? 'sometimes' : null,
                'required',
                'string',
                'max:255',
            ],
        ];
    }

    public function validate(array $data, Template $template): array
    {
        return validator($data, $this->rules($template))->validate();
    }
}
