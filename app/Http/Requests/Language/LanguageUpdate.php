<?php

namespace App\Http\Requests\Language;

use Illuminate\Validation\Rule;
use App\Core\Enums\EnumsLanguage;
use Illuminate\Foundation\Http\FormRequest;

class LanguageUpdate extends FormRequest
{

    protected $language;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->language = $this->route("language");
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => ["required", "string"],
            "code" => ["required", Rule::unique("languages")->ignore($this->language->id)],
            "direction" => ["nullable", Rule::in(EnumsLanguage::direction())]
        ];
    }
}
