<?php

namespace App\Http\Requests\Gateway;

use App\Core\Enums\EnumsSystem;
use App\Services\Gateway\GatewayService;
use Illuminate\Foundation\Http\FormRequest;

class GatewayDestroy extends FormRequest
{

    protected $gateway;

    public function __construct(public GatewayService $gatewayService)
    {
    }

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
        return !$this->gatewayService->hasOrders($this->gateway);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
