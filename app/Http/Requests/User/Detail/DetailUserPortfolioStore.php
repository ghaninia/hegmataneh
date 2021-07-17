<?php

namespace App\Http\Requests\User\Detail;

use App\Rules\FilterRangeRule;
use Illuminate\Foundation\Http\FormRequest;

class DetailUserPortfolioStore extends FormRequest
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
            "name" => ["nullable" , "string" ] ,
            "description" => ["nullable" , "string" ] ,
            "excerpt" => ["nullable" , "string" ] ,
            "percent" => ["nullable" , new FilterRangeRule ],
            "present.*" => ["nullable" , "numeric"],
            "launched_at" => ["nullable" , new FilterRangeRule ],
            "launched_at.*" => ["nullable" , "date_format:Y/m/d" ]
        ];
    }
}
