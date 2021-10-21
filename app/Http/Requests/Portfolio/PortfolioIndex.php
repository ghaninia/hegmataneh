<?php

namespace App\Http\Requests\Portfolio;

use App\Rules\FilterRangeRule;
use Illuminate\Foundation\Http\FormRequest;

class PortfolioIndex extends FormRequest
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

            "name" => ["nullable", "string"],
            "excerpt" => ["nullable", "string"],
            "content" => ["nullable", "string"],

            "demo" => ["nullable", "link"],
            "percent" => ["nullable", "numeric", new FilterRangeRule],
            "launched_at" => ["numeric", "date", new FilterRangeRule],

        ];
    }
}
