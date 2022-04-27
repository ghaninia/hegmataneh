<?php

namespace App\Http\Controllers\Dashboard\Option;

use App\Models\Option;
use App\Kernel\Enums\EnumsOption;
use App\Http\Controllers\Controller;
use App\Services\Option\OptionService;
use App\Http\Requests\Option\OptionUpdate;
use App\Http\Resources\Option\OptionCollection;

class OptionController extends Controller
{

    /**
     * Display a listing of the resource
     * @return OptionCollection
     */
    public function index()
    {
        $options = Option::all();
        return new OptionCollection($options);
    }


    /**
     * Update the specified resource in storage
     * @param OptionUpdate $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(OptionUpdate $request)
    {
        $options = $request->only(EnumsOption::all());

        foreach ($options as $key => $value) {
            OptionService::getInstance()->put($key,  $value);
        }

        return $this->success([
            "msg" => trans("dashboard.success.option.update")
        ]);
    }
}
