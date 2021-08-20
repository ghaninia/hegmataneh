<?php

namespace App\Http\Requests\Post;

use App\Core\Enums\EnumsPost;
use App\Rules\SlugRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PostStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true ;
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
            "slug" => [new SlugRule(Post::class, "title")],

            "status" => ["required", Rule::in(EnumsPost::status())],
            "comment_status" => ["required", "boolean"],
            "vote_status" => ["required", "boolean"],
            "format" => ["required", Rule::in(EnumsPost::format())],
            "development" => ["nullable", "numeric"],
            "content" => ["nullable", "string"],
            "excerpt" => ["nullable", "string"],
            "faq" => ["nullable", "string"],
            "theme" => ["nullable", "string"],
            "published_at" => ["nullable", "date_format:Y/m/d H:i:s"],
            "created_at" => ["nullable", "date_format:Y/m/d H:i:s"],

        ];
    }
}
