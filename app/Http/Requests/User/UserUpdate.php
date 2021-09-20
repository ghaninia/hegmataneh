<?php

namespace App\Http\Requests\User;

use App\Rules\MobileRule;
use App\Rules\PasswordRule;
use App\Rules\UsernameRule;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UserUpdate extends FormRequest
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
        $user = $this->route("user");
        return [
            "role_id" => ["required", "exists:roles,id"],
            "language_id" => ["nullable", "exists:languages,id"],
            "currency_id" => ["nullable", "exists:currencies,id"],
            "name" => ["nullable", "string", "max:255"],
            "email" => ["required", "email", Rule::unique("users")->ignore($user->id)],
            "mobile" => ["nullable", new MobileRule, Rule::unique("users")->ignore($user->id)],
            "username" => ["nullable", new UsernameRule, Rule::unique("users")->ignore($user->id)],
            "password" => ["nullable", new PasswordRule],
            "bio" => ["nullable", "string"],
        ];
    }
}
