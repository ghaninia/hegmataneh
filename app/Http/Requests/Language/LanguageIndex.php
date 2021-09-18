<?php

namespace App\Http\Requests\Language;

use Illuminate\Validation\Rule;
use App\Core\Enums\EnumsLanguage;
use Illuminate\Foundation\Http\FormRequest;

class LanguageIndex extends FormRequest
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
            "code" => ["nullable", "string"],
            "direction" => ["nullable", Rule::in(EnumsLanguage::direction())]
        ];
    }
}
