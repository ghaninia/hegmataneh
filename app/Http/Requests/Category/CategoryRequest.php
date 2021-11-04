<?php

namespace App\Http\Requests\Category;

use App\Models\Term;
use App\Rules\SlugRule;
use App\Rules\ColorRule;
use App\Rules\TermParentRule;
use App\Rules\TranslationableRule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    
    protected $category ;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true ;
    }

    public function prepareForValidation()
    {
        $this->category = $this->route("category") ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [

            "term_id" => [ new TermParentRule( $this->category ) ] ,
            "color" => [ "nullable" , new ColorRule ] ,
            
            "translations" => [ "required" , "array" , new TranslationableRule($this)] ,
            "translations.*.name" => ["required" , "string" , new SlugRule(Term::class , $this->category) ] ,
            "translations.*.description" => ["nullable" , "string"] ,

            "thumbnail" => ["nullable" , ]
        ];
    }
}
