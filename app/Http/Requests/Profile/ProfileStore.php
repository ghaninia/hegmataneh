<?php

namespace App\Http\Requests\Profile;

use App\Rules\MobileRule;
use App\Rules\PasswordRule;
use App\Rules\UsernameRule;
use App\Services\Authunticate\AuthServiceInterface;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfileStore extends FormRequest
{

    public function __construct(
        protected AuthServiceInterface $authService
    ){}

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
            "language_id" => ["nullable", "exists:languages,id"],
            "currency_id" => ["nullable", "exists:currencies,id"],
            "name" => ["nullable", "string", "max:255"],
            "email" => ["required", "email", Rule::unique("users")->ignore($this->authService->id()) ],
            "mobile" => ["nullable", new MobileRule, Rule::unique("users")->ignore($this->authService->id()) ],
            "username" => ["nullable", new UsernameRule,Rule::unique("users")->ignore($this->authService->id()) ],
            "bio" => ["nullable", "string"],
            "password" => ["nullable" ,  new PasswordRule],
        ];
    }
}
