<?php

namespace App\Http\Requests\Gateway;

use Illuminate\Foundation\Http\FormRequest;

class GatewayIndex extends FormRequest
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
            "id" => ["nullable", "exists:gateways,id"],
            "name" => ["nullable", "string"],
            "status" => ["nullable", "boolean"],
            "key" => ["nullable", "string"],
            "currency_id" => ["nullable", "exists:currencies,id"]
        ];
    }
}
