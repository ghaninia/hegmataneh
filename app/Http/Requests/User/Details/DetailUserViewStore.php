<?php

namespace App\Http\Requests\User\Details;

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
            "user_ip" => ["nullable" , "ipv4"]
        ];
    }
}
