<?php

namespace App\Services\Portfolio;

use App\Models\User;
use App\Models\Portfolio;
use Illuminate\Contracts\Pagination\Paginator;
use App\Services\Translation\TranslationService;
use App\Services\Portfolio\PortfolioServiceInterface;

class PortfolioService implements PortfolioServiceInterface
{

    public function __construct(
        public TranslationService $translationService,
    ) {
    }

    /**
     * لیست تمام نمونه کار ها
     * @param array $filters
     * @return Paginator
     */
    public function list(array $filters): Paginator
    {
        return
            Portfolio::query()
            ->filterBy($filters)
            ->with(["translations"])
            ->paginate();
    }


    /**
     * ویرایش و حذف نمونه کار
     * @param User $user
     * @param array $data
     * @param Portfolio|null $portfolio
     */
    public function updateOrCreate(User $user, array $data, Portfolio $portfolio = null)
    {

        $portfolio =
            Portfolio::updateOrCreate(
                ["id" => $portfolio?->id],
                [
                    "user_id" => $user->id,
                    "name" => $data["name"] ?? null,
                    "description" => $data["description"] ?? null,
                    "demo" => $data["demo"] ?? null,
                    "excerpt" => $data["excerpt"] ?? null,
                    "percent" => $data["percent"] ?? null,
                    "launched_at" => $data["launched_at"] ?? null,
                ]
            );

        $this->translationService->sync($portfolio, $translations = $data["translations"] ?? []);

        return $portfolio->load("translations");
    }

    /**
     * حذف نمونه کار
     * @param Portfolio $portfolio
     */
    public function delete(Portfolio $portfolio)
    {
        return $portfolio->delete();
    }
}
