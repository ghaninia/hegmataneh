<?php

namespace App\Http\Controllers\Dashboard\Option;

use App\Models\Option;
use App\Core\Enums\EnumsOption;
use App\Http\Controllers\Controller;
use App\Services\Option\OptionService;
use App\Http\Requests\Option\OptionUpdate;
use App\Http\Resources\Option\OptionCollection;

class OptionController extends Controller
{


    public function __construct()
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $options = Option::all();
        return new OptionCollection($options);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  OptionUpdate $request
     * @return \Illuminate\Http\Response
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
