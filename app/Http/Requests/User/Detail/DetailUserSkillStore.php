<?php

namespace App\Http\Requests\User\Detail;

use Illuminate\Foundation\Http\FormRequest;

class DetailUserSkillStore extends FormRequest
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
            "title_fa" => ["nullable" , "string"] ,
            "title_en" => ["nullable" , "string"] ,
        ];
    }
}
