<?php

namespace App\Http\Requests\Gateway;

use App\Kernel\Enums\EnumsSystem;
use App\Services\Gateway\GatewayService;
use Illuminate\Foundation\Http\FormRequest;

class GatewayDestroy extends FormRequest
{

    public function __construct(protected GatewayService $gatewayService){}

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
