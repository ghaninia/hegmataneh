<?php

namespace App\Http\Requests\User\Detail;

use Illuminate\Foundation\Http\FormRequest;

class DetailUserViewStore extends FormRequest
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
            "ipv4" => ["nullable" , "ipv4"]
        ];
    }
}
