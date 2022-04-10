<?php

namespace App\Http\Requests\Tag;

use App\Models\Term;
use App\Rules\SlugRule;
use App\Rules\TranslationableRule;
use Illuminate\Foundation\Http\FormRequest;

class TagRequest extends FormRequest
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
            "translations" => [ "required" , "array" , new TranslationableRule($this)] ,
            "translations.*.name" => ["required" , "string" , new SlugRule(Term::class , $this->tag) ] ,
            "translations.*.description" => ["nullable" , "string"] ,
        ];
    }
}
