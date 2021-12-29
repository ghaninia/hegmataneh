<?php

namespace App\Http\Controllers\Api\Option;

use App\Core\Enums\EnumsOption;
use App\Http\Controllers\Controller;
use App\Services\Option\OptionService;
use App\Http\Requests\Option\OptionUpdate;
use App\Repositories\Option\OptionRepository;
use App\Http\Resources\Option\OptionCollection;

class OptionController extends Controller
{

    protected $optionRepo;

    public function __construct(OptionRepository $optionRepo)
    {
        $this->optionRepo = $optionRepo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $options = $this->optionRepo->all();
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
