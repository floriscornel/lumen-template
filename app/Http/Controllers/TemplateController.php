<?php declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Resources\TemplateResource;
use App\Http\Validators\TemplateValidator;
use App\Models\Template;
use Illuminate\Http\Request;

class TemplateController extends Controller
{
    public function index(Request $request)
    {
        $this->authorize('index', Template::class);

        $templates = Template::search($request->input('q'))->where('user_id', $request->user()->id)
            ->orderBy('updated_at');

        // return $templates->simplePaginate();

        $result = $templates->simplePaginateRaw()->toArray();

        $result['data'] = array_map(function ($t) {
            return new TemplateResource(new Template($t));
        }, $result['data']['hits']);

        return $result;
    }

    public function store(Request $request)
    {
        $this->authorize('create', Template::class);
        $data = (new TemplateValidator())->validate(
            $request->all(),
            $template = new Template()
        );
        $template->fill($data);
        $template->save();
        return new TemplateResource($template);
    }

    public function show(string $id)
    {
        $template = Template::findOrFail($id);
        $this->authorize('view', $template);
        return new TemplateResource($template);
    }

    public function update(Request $request, string $id)
    {
        $template = Template::findOrFail($id);
        $this->authorize('update', $template);
        $data = (new TemplateValidator())->validate(
            $request->all(),
            $template
        );
        $template->fill($data);
        $template->save();
        return new TemplateResource($template);
    }

    public function destroy(string $id)
    {
        $template = Template::findOrFail($id);
        $this->authorize('delete', $template);
        return Template::destroy([$template->id]);
    }
}
