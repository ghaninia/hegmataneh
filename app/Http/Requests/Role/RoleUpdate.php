<?php

namespace App\Http\Requests\Role;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class RoleUpdate extends FormRequest
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
        $role = $this->route("role");
        return [
            "name" => ["required", "string", "max:255", Rule::unique("roles")->ignore($role->id)],
            "permissions" => ["required", "array"],
            "permissions.*" => [
                "required" , "exists:permissions,id"
            ]
        ];
    }
}
