<?php

namespace App\Http\Requests\Post\Page;

use App\Models\Post;
use App\Rules\SlugRule;
use App\Core\Enums\EnumsPost;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class PageUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return TRUE;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            "title" => ["required", "string"],
            "slug" => [new SlugRule(Post::class, "title", $this->route("page"))],

            "status" => ["required", Rule::in(EnumsPost::status())],
            "comment_status" => ["required", "boolean"],
            "vote_status" => ["required", "boolean"],
            "format" => ["required", Rule::in(EnumsPost::format())],
            "development" => ["required", "numeric"],
            "content" => ["nullable", "string"],
            "excerpt" => ["nullable", "string"],
            "faq" => ["nullable", "string"],
            "theme" => ["nullable", "string"],
            "published_at" => ["nullable", "date_format:Y/m/d H:i:s"],
            "created_at" => ["nullable", "date_format:Y/m/d H:i:s"],
        ];
    }
}
