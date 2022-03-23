<?php

namespace App\Http\Controllers\Dashboard\Widget;

use App\Http\Controllers\Controller;
use App\Http\Requests\Widget\StatisticPostsRequest;
use App\Services\Authunticate\AuthServiceInterface;
use App\Services\Widget\WidgetServiceInterface;

class WidgetController extends Controller
{

    public function __construct(
        protected WidgetServiceInterface $widgetService,
        protected AuthServiceInterface $authService
    ) {
    }


    public function statisticPosts(StatisticPostsRequest $request)
    {

        $statistics = $this->widgetService
            ->setUser(
                $this->authService->user()
            )
            ->statisticPosts();

        return $statistics;
    }
}
