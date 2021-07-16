<?php

namespace App\Http\Requests\User;

use App\Rules\MobileRule;
use App\Rules\PasswordRule;
use App\Rules\UsernameRule;
use Illuminate\Foundation\Http\FormRequest;

class UserStore extends FormRequest
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
            "role_id" => ["required", "exists:roles,id"],
            "name" => ["nullable", "string", "max:255"],
            "email" => ["required", "email", "unique:users"],
            "mobile" => ["nullable", new MobileRule, "unique:users"],
            "username" => ["nullable", new UsernameRule, "unique:users"],
            "password" => ["required", new PasswordRule],
            "bio" => ["nullable", "string"],
        ];
    }
}
