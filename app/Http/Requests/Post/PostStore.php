<?php

namespace App\Http\Requests\Post;

use App\Models\Post;
use App\Rules\SlugRule;
use App\Rules\Term\TagRule;
use App\Kernel\Enums\EnumsPost;
use Illuminate\Validation\Rule;
use App\Rules\Term\CategoryRule;
use App\Rules\TranslationableRule;
use Illuminate\Foundation\Http\FormRequest;

class PostStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $statsSchedule = EnumsPost::STATUS_SCHEDULE;

        return [
            "status" => ["required", Rule::in(EnumsPost::status())],
            "comment_status" => ["required", "boolean"],
            "vote_status" => ["required", "boolean"],
            "format" => ["required", Rule::in(EnumsPost::format())],
            "published_at" => [ "nullable" , "required_if:status,{$statsSchedule}", "date"],
            "created_at" => ["nullable", "date"],

            "tags" => ["nullable", "array"],
            "tags.*" => ["required", new TagRule ],

            "categories" => ["nullable", "array"],
            "categories.*" => ["required", new CategoryRule],

            "translations" => [ "required" , "array" , new TranslationableRule($this)] ,
            "translations.*.title" => ["required" , "string" , new SlugRule(Post::class) ] ,
            "translations.*.content" => ["nullable" , "string"] ,
            "translations.*.excerpt" => ["nullable" , "string"] ,
            "translations.*.faq" => ["nullable" , "string"] ,
            "translations.*.goal_post" => ["nullable" , "string"] ,
        ];
    }
}
