<?php

namespace App\Http\Requests\Serial;

use App\Models\Serial;
use App\Rules\SlugRule;
use App\Rules\CurrencyRule;
use App\Rules\EpisodesRule;
use App\Rules\Term\TagRule;
use App\Rules\Term\CategoryRule;
use App\Rules\TranslationableRule;
use Illuminate\Foundation\Http\FormRequest;

class SerialRequest extends FormRequest
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

        return [

            "currencies" => ["nullable", "array", new CurrencyRule],
            "currencies.*.price" => ["required", "numeric"],
            "currencies.*.amazing_price" => ["nullable", "numeric"],
            "currencies.*.amazing_from_date" => ["nullable", "required_with:amazing_to_date", "date"],
            "currencies.*.amazing_to_date" => ["nullable", "required_with:amazing_from_date", "date"],

            "translations" => ["required", "array", new TranslationableRule($this)],
            "translations.*.title" => ["required", "string", new SlugRule(Serial::class, $this->serial)],
            "translations.*.description" => ["nullable", "string"],

            "episodes" => ["nullable", "array", "bail", new EpisodesRule($this->user)],
            "episodes.*.is_locked" => ["nullable", "boolean"],
            "episodes.*.priority" => ["nullable", "numeric"],
            "episodes.*.translations" => ["required", "array", new TranslationableRule($this)],
            "episodes.*.translations.*.title" => ["required", "string"],
            "episodes.*.translations.*.description" => ["nullable", "string"],

            "tags" => ["nullable", "array"],
            "tags.*" => ["required", new TagRule],

            "categories" => ["nullable", "array"],
            "categories.*" => ["required", new CategoryRule],
        ];
    }
}
