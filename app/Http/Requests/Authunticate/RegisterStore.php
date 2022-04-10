<?php

namespace App\Http\Requests\Authunticate;

use App\Rules\PasswordRule;
use App\Kernel\Enums\EnumsOption;
use Illuminate\Foundation\Http\FormRequest;

class RegisterStore extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return options(EnumsOption::DASHBOARD_CAN_REGISTER);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "name" => ["required", "string", "max:255"],
            "email" => ["required", "email", "unique:users"],
            // "mobile" => ["nullable", new MobileRule, "unique:users"],
            // "username" => ["nullable", new UsernameRule, "unique:users"],
            "password" => ["required", new PasswordRule],
            // "bio" => ["nullable", "string"],
        ];
    }
}
