<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->bind(\App\Repositories\Role\RoleRepositoryInterface::class, \App\Repositories\Role\RoleRepository::class);
        $this->app->bind(\App\Repositories\User\UserRepositoryInterface::class, \App\Repositories\User\UserRepository::class);
        $this->app->bind(\App\Repositories\Option\OptionRepositoryInterface::class, \App\Repositories\Option\OptionRepository::class);
        $this->app->bind(\App\Repositories\View\ViewRepositoryInterface::class, \App\Repositories\View\ViewRepository::class);
        $this->app->bind(\App\Repositories\Vote\VoteRepositoryInterface::class, \App\Repositories\Vote\VoteRepository::class);
        $this->app->bind(\App\Repositories\Post\PostRepositoryInterface::class, \App\Repositories\Post\PostRepository::class);
        $this->app->bind(\App\Repositories\Skill\SkillRepositoryInterface::class, \App\Repositories\Skill\SkillRepository::class);
        $this->app->bind(\App\Repositories\Portfolio\PortfolioRepositoryInterface::class, \App\Repositories\Portfolio\PortfolioRepository::class);
        $this->app->bind(\App\Repositories\Comment\CommentRepositoryInterface::class, \App\Repositories\Comment\CommentRepository::class);
        $this->app->bind(\App\Repositories\Term\TermRepositoryInterface::class, \App\Repositories\Term\TermRepository::class);
        $this->app->bind(\App\Repositories\File\FileRepositoryInterface::class, \App\Repositories\File\FileRepository::class);
        $this->app->bind(\App\Repositories\Permission\PermissionRepositoryRepositoryInterface::class, \App\Repositories\Permission\PermissionRepositoryRepository::class);
        $this->app->bind(\App\Repositories\Permission\PermissionRepositoryInterface::class, \App\Repositories\Permission\PermissionRepository::class);
        $this->app->bind(\App\Repositories\Serial\SerialRepositoryInterface::class, \App\Repositories\Serial\SerialRepository::class);
        $this->app->bind(\App\Repositories\Price\PriceRepositoryInterface::class, \App\Repositories\Price\PriceRepository::class);
        $this->app->bind(\App\Repositories\Product\Information\ProductInformationRepositoryInterface::class, \App\Repositories\Product\Information\ProductInformationRepository::class);
        $this->app->bind(\App\Repositories\Translation\TranslationRepositoryInterface::class, \App\Repositories\Translation\TranslationRepository::class);
        $this->app->bind(\App\Repositories\Currency\CurrencyRepositoryInterface::class, \App\Repositories\Currency\CurrencyRepository::class);
        $this->app->bind(\App\Repositories\Language\LanguageRepositoryInterface::class, \App\Repositories\Language\LanguageRepository::class);
        $this->app->bind(\App\Repositories\Basket\BasketRepositoryInterface::class, \App\Repositories\Basket\BasketRepository::class);
        $this->app->bind(\App\Repositories\Slug\SlugRepositoryInterface::class, \App\Repositories\Slug\SlugRepository::class);
        $this->app->bind(\App\Repositories\PostSerial\PostSerialRepositoryInterface::class, \App\Repositories\PostSerial\PostSerialRepository::class);
        $this->app->bind(\App\Repositories\Episode\EpisodeRepositoryInterface::class, \App\Repositories\Episode\EpisodeRepository::class);
        //:end-bindings:
    }
}
