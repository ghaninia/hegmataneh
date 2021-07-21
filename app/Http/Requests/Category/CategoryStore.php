<?php

namespace App\Http\Requests\Category;

use App\Models\Term;
use App\Rules\SlugRule;
use App\Rules\ColorRule;
use App\Rules\TermParentRule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryStore extends FormRequest
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
            "name" => ["required", "max:255"],
            "description" => ["nullable", "string"],
            "slug" => [ new SlugRule(Term::class, "name")],

            "term_id" => [ new TermParentRule() ] ,
            "color" => [ "nullable" , new ColorRule ]
        ];
    }
}
