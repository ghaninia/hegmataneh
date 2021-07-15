<?php

namespace App\Http\Requests\Role;

use App\Core\Enums\EnumsRole;
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
        return [] ;
        // $role = $this->route("role");
        // return [
        //     "name" => ["required", "string", "max:255", Rule::unique("roles")->ignore($role->id)],
        //     "permissions" => ["required", "array"],
        //     "permissions.*" => [
        //         "required", Rule::in(
        //             EnumsRole::all()
        //         )
        //     ]
        // ];
    }
}
