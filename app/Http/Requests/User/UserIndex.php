<?php

namespace App\Http\Requests\User;

use App\Rules\MobileRule;
use App\Rules\UsernameRule;
use Illuminate\Foundation\Http\FormRequest;

class UserIndex extends FormRequest
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
            "name" => ["nullable", "string"],
            "username" => ["nullable", new UsernameRule],
            "email" => ["nullable", "email"],
            "mobile" => ["nullable", new MobileRule],
            "role" => ["nullable", "exists:roles,id"],
            "status" => ["nullable" , "boolean"]
        ];
    }
}
