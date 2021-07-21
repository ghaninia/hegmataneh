<?php

namespace App\Http\Requests\Category;

use App\Rules\TermParentRule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryIndex extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => ["nullable" , "string"] ,
            "slug" => ["nullable" , "string"] ,
            "description" => ["nullable" , "string"] ,
            "color" => ["nullable" , "string"] ,
            "term_id" => ["nullable" , "integer"] ,
        ];
    }
}
