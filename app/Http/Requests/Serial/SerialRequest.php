<?php

namespace App\Http\Requests\Serial;

use App\Rules\CurrencyRule;
use App\Rules\EpisodesRule;
use Illuminate\Foundation\Http\FormRequest;

class SerialRequest extends FormRequest
{

    public $user;

    public function prepareForValidation()
    {
        $this->user = $this->route("user");
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
        return [
            "title" => ["required",  "string"],
            "description" => ["nullable", "string"],

            "episodes" => ["nullable", "array", "bail", new EpisodesRule($this->user)],
            "episodes.*.title" => ["required", "string"],
            "episodes.*.description" => ["nullable", "string"],
            "episodes.*.is_locked" => ["nullable", "boolean"],
            "episodes.*.priority" => ["nullable", "numeric"],

            "currencies" => ["nullable", "array", new CurrencyRule],
            "currencies.*.price" => ["required", "numeric"],
            "currencies.*.amazing_price" => ["nullable", "numeric"],
            "currencies.*.amazing_from_date" => ["nullable", "required_with:amazing_to_date", "date"],
            "currencies.*.amazing_to_date" => ["nullable", "required_with:amazing_from_date", "date"],
        ];
    }
}
