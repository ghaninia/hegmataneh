<?php

namespace App\Http\Requests\Post;

use App\Models\Post;
use App\Rules\LanguageableRule;
use App\Rules\SlugRule;
use App\Core\Enums\EnumsPost;
use App\Rules\Term\CategoryRule;
use App\Rules\Term\TagRule;
use Illuminate\Validation\Rule;
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
//            "title" => ["required", "string"],

            "status" => ["required", Rule::in(EnumsPost::status())],
            "comment_status" => ["required", "boolean"],
            "vote_status" => ["required", "boolean"],
            "format" => ["required", Rule::in(EnumsPost::format())],
//            "content" => ["nullable", "string"],
//            "excerpt" => ["nullable", "string"],
//            "faq" => ["nullable", "string"],
            "published_at" => [ "nullable" , "required_if:status,{$statsSchedule}", "date"],
            "created_at" => ["nullable", "date"],

            "tags" => ["nullable", "array"],
            "tags.*" => ["required", new TagRule ],

            "categories" => ["nullable", "array"],
            "categories.*" => ["required", new CategoryRule],

            "languages" => [ "required" , "array" , new LanguageableRule($this) , "bail"] ,
            "languages.*.title" => ["required" , "string"] ,
            "languages.*.content" => ["nullable" , "string"] ,
            "languages.*.excerpt" => ["nullable" , "string"] ,
            "languages.*.faq" => ["nullable" , "string"] ,
        ];
    }
}
