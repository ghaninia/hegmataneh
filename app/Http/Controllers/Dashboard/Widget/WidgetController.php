<?php

namespace App\Http\Controllers\Dashboard\Widget;

use App\Http\Controllers\Controller;
use App\Http\Requests\Widget\StatisticRequest;
use App\Services\Widget\WidgetServiceInterface;
use App\Services\Authunticate\AuthServiceInterface;

class WidgetController extends Controller
{

    public function __construct(
        protected WidgetServiceInterface $widgetService,
        protected AuthServiceInterface $authService
    ) {
    }

    /**
     * shpw post statistic form user
     * @param StatisticRequest $request
     * @return mixed
     */
    public function statisticPosts(StatisticRequest $request)
    {

        $statistics = $this->widgetService
            ->setUser(
                $this->authService->user()
            )
            ->statisticPosts();

        return $statistics;
    }

    /**
     * show post statistic form user
     * @param StatisticRequest $request
     * @return mixed
     */
    public function statisticUsers(StatisticRequest $request)
    {

        $statistics = $this->widgetService
            ->setUser(
                $this->authService->user()
            )
            ->statisticUsers();

        return $statistics;
    }
}
