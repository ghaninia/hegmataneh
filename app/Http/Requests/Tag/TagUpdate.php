<?php

namespace App\Http\Requests\Tag;

use App\Models\Term;
use App\Rules\SlugRule;
use Illuminate\Foundation\Http\FormRequest;

class TagUpdate extends FormRequest
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
        $tag = $this->route("tag") ;

        return [
            "name" => [ "required" , "string"],
            "slug" => [ new SlugRule(Term::class , "name" , $tag) ],
            "description" => ["nullable" , "string"],
    ];
    }
}
