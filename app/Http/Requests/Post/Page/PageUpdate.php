<?php

namespace App\Http\Requests\Post\Page;

use App\Models\Post;
use App\Rules\SlugRule;
use App\Core\Enums\EnumsPost;
use Illuminate\Validation\Rule;
use App\Rules\TranslationableRule;
use Illuminate\Foundation\Http\FormRequest;

class PageUpdate extends FormRequest
{

    protected $page;


    public function prepareForValidation()
    {
        $this->page = $this->route("page");
    }

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
            "development" => ["nullable", "numeric"],
            "theme" => ["nullable", "string"],
            "published_at" => ["nullable", "required_if:status,{$statsSchedule}", "date"],
            "created_at" => ["nullable", "date"],

            "translations" => ["required", "array", new TranslationableRule($this)],
            "translations.*.title" => ["required", "string", new SlugRule(Post::class, $this->page)],
            "translations.*.content" => ["nullable", "string"],
            "translations.*.excerpt" => ["nullable", "string"],
            "translations.*.faq" => ["nullable", "string"],
        ];
    }
}
