<?php

namespace App\Http\Controllers\Dashboard\Portfolio;

use App\Models\User;
use App\Models\Portfolio;
use App\Http\Controllers\Controller;
use App\Services\Portfolio\PortfolioService;
use App\Http\Requests\Portfolio\PortfolioIndex;
use App\Http\Requests\Portfolio\PortfolioRequest;
use App\Http\Resources\Portfolio\PortfolioResource;
use App\Http\Resources\Portfolio\PortfolioCollection;

class PortfolioController extends Controller
{

    public function __construct(public PortfolioService $portfolioService)
    {
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user, PortfolioIndex $request)
    {

        $filters = array_merge(
            $request->only([
                "name",
                "content",
                "demo",
                "excerpt",
                "percent",
                "launched_at"
            ]),
            [
                "user" => [
                    "id" => $user->id,
                ],
            ]
        );

        $portfolios = $this->portfolioService->list(
            $filters,
        );

        return new PortfolioCollection($portfolios);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(User $user, PortfolioRequest $request)
    {
        $portfolio = $this->portfolioService->updateOrCreate(
            $user,
            $request->all()
        );

        return $this->success([
            "msg"  => trans("dashboard.success.portfolio.create"),
            "data" => new PortfolioResource($portfolio)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param User $user
     * @param  \App\Models\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, Portfolio $portfolio)
    {
        $this->authorizeForUser($user, "view", $portfolio);

        return new PortfolioResource($portfolio->load(["user" , "translations"]));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param User $user
     * @param  \App\Models\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, Portfolio $portfolio, PortfolioRequest $request)
    {
        $this->authorizeForUser($user, "update", $portfolio);

        return $this->success([
            "msg"  => trans("dashboard.success.portfolio.update"),
            "data" => new PortfolioResource(
                $this->portfolioService->updateOrCreate(
                    $user,
                    $request->all(),
                    $portfolio
                )
            )
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Portfolio $portfolio)
    {
        $this->authorizeForUser($user, "delete", $portfolio);

        $this->portfolioService->delete($portfolio);

        return $this->success([
            "msg" => trans("dashboard.success.portfolio.delete")
        ]);
    }
}
