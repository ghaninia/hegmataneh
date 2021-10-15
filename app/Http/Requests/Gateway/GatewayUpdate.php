<?php

namespace App\Http\Requests\Gateway;

use App\Core\Enums\EnumsOption;
use App\Core\Enums\EnumsSystem;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class GatewayUpdate extends FormRequest
{

    protected $gateway;

    public function prepareForValidation()
    {
        $this->gateway = $this->route(EnumsSystem::WALLCARD_GATEWAY);
    }

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
            "name" => ["required", "string"],
            "status" => ["required", "boolean"],
            "code" => ["required", "string", Rule::unique("gateways")->ignore($this->gateway->id)],
            "currencies" => ["required", "array"],
            "currencies.*" => ["required", "exists:currencies,id"],
        ];
    }
}
