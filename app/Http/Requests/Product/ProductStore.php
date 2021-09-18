<?php

namespace App\Http\Requests\Product;

use App\Models\Post;
use App\Rules\SlugRule;
use App\Rules\CurrencyRule;
use App\Rules\Term\TagRule;
use App\Core\Enums\EnumsPost;
use Illuminate\Validation\Rule;
use App\Rules\Term\CategoryRule;
use Illuminate\Foundation\Http\FormRequest;

class ProductStore extends FormRequest
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

            "title" => ["required", "string"],
            "slug" => [new SlugRule(Post::class, "title")],
            "content" => ["nullable", "string"],
            "excerpt" => ["nullable", "string"],
            "faq" => ["nullable", "string"],
            "status" => ["required", Rule::in(EnumsPost::status())],
            "comment_status" => ["required", "boolean"],
            "vote_status" => ["required", "boolean"],
            "created_at" => ["nullable", "date"],
            "published_at" => ["nullable", "required_if:status,{$statsSchedule}", "date"],

            "maximum_sell" => ["nullable", "numeric"],
            "expire_day" => ["nullable", "numeric"],
            "download_limit" => ["nullable", "numeric"],

            "currencies" => ["nullable", "array", new CurrencyRule],
            "currencies.*.price" => ["required", "numeric"],
            "currencies.*.amazing_price" => ["nullable", "numeric"],
            "currencies.*.amazing_from_date" => ["nullable", "required_with:amazing_to_date", "date"],
            "currencies.*.amazing_to_date" => ["nullable", "required_with:amazing_from_date", "date"],

            "tags" => ["nullable", "array"],
            "tags.*" => ["required", new TagRule],

            "categories" => ["nullable", "array"],
            "categories.*" => ["required", new CategoryRule],

            "skills" => ["nullable", "array"],
            "skills.*" => ["required", "exists:skills,id"]

        ];
    }
}
