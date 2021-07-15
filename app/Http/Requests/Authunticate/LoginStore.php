<?php

namespace App\Http\Requests\Authunticate;

use App\Services\Authunticate\AuthService;
use Illuminate\Foundation\Http\FormRequest;

class LoginStore extends FormRequest
{
    protected $authService ;
    public function __construct(AuthService $authService)
    {
        $this->authService = $authService ;
    }

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
            $this->authService->field() => ["required" , "string"] ,
            "password" => ["required"] ,
            "remember" => ["nullable" , "boolean"]
        ];
    }
}
