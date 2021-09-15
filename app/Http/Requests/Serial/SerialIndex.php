<?php

namespace App\Http\Requests\Serial;

use App\Rules\FilterRangeRule;
use Illuminate\Foundation\Http\FormRequest;

class SerialIndex extends FormRequest
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
            "title" => ["nullable", "string"],
            "created_at" => ["nullable", "array", new FilterRangeRule],
            "created_at.*" => ["required", "date"],

            "price" => ["nullable", "array", new FilterRangeRule],
            "price.*" => ["required", "numeric"],

            "posts" => ["nullable", "array"],
            "posts.*" => ["required", "exists:posts"],

            "amazing_price" => ["nullable", "array", new FilterRangeRule],
            "amazing_price.*" => ["required", "numeric"],
        ];
    }
}
