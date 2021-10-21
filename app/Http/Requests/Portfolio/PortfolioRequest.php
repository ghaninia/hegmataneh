<?php

namespace App\Http\Requests\Portfolio;

use App\Rules\TranslationableRule;
use Illuminate\Foundation\Http\FormRequest;

class PortfolioRequest extends FormRequest
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
            "demo" => ["nullable", "url"],
            "percent" => ["nullable", "numeric", "min:0" , "max:100"],
            "launched_at" => ["nullable", "date"],

            "translations" => ["required", "array", new TranslationableRule($this)],
            "translations.*.name" => ["required", "string"],
            "translations.*.sub_name" => ["nullable", "string"],
            "translations.*.content" => ["nullable", "string"],
            "translations.*.excerpt" => ["nullable", "string"],
        ];
    }
}
