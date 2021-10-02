<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class BootstrapServiceProvider extends ServiceProvider
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
        $this->app->bind(\App\Services\Role\RoleServiceInterface::class, \App\Services\Role\RoleService::class);
        $this->app->bind(\App\Services\Authunticate\AuthServiceInterface::class, \App\Services\Authunticate\AuthService::class);
        $this->app->bind(\App\Services\User\UserServiceInterface::class, \App\Services\User\UserService::class);
        $this->app->bind(\App\Services\Option\OptionServiceInterface::class, \App\Services\Option\OptionService::class);
        $this->app->bind(\App\Services\View\ViewServiceInterface::class, \App\Services\View\ViewService::class);
        $this->app->bind(\App\Services\Vote\VoteServiceInterface::class, \App\Services\Vote\VoteService::class);
        $this->app->bind(\App\Services\Post\PostServiceInterface::class, \App\Services\Post\PostService::class);
        $this->app->bind(\App\Services\Product\ProductServiceInterface::class, \App\Services\Product\ProductService::class);
        $this->app->bind(\App\Services\Skill\SkillServiceInterface::class, \App\Services\Skill\SkillService::class);
        $this->app->bind(\App\Services\Page\PageServiceInterface::class, \App\Services\Page\PageService::class);
        $this->app->bind(\App\Services\Theme\ThemeServiceInterface::class, \App\Services\Theme\ThemeService::class);
        $this->app->bind(\App\Services\Portfolio\PortfolioServiceInterface::class, \App\Services\Portfolio\PortfolioService::class);
        $this->app->bind(\App\Services\Comment\CommentServiceInterface::class, \App\Services\Comment\CommentService::class);
        $this->app->bind(\App\Services\Category\CategoryServiceInterface::class, \App\Services\Category\CategoryService::class);
        $this->app->bind(\App\Services\Tag\TagServiceInterface::class, \App\Services\Tag\TagService::class);
        $this->app->bind(\App\Services\Upload\UploadServiceInterface::class, \App\Services\Upload\UploadService::class);
        $this->app->bind(\App\Services\File\FileServiceInterface::class, \App\Services\File\FileService::class);
        $this->app->bind(\App\Services\AccessServiceServiceInterface::class, \App\Services\AccessServiceService::class);
        $this->app->bind(\App\Services\Access\AccessServiceInterface::class, \App\Services\Access\AccessService::class);
        $this->app->bind(\App\Services\Serial\SerialServiceInterface::class, \App\Services\Serial\SerialService::class);
        $this->app->bind(\App\Services\Price\PriceServiceInterface::class, \App\Services\Price\PriceService::class);
        $this->app->bind(\App\Services\Product\Information\ProductInformationServiceInterface::class, \App\Services\Product\Information\ProductInformationService::class);
        $this->app->bind(\App\Services\Translation\TranslationServiceInterface::class, \App\Services\Translation\TranslationService::class);
        $this->app->bind(\App\Services\Currency\CurrencyServiceInterface::class, \App\Services\Currency\CurrencyService::class);
        $this->app->bind(\App\Services\Language\LanguageServiceInterface::class, \App\Services\Language\LanguageService::class);
        $this->app->bind(\App\Services\Basket\BasketServiceInterface::class, \App\Services\Basket\BasketService::class);
        $this->app->bind(\App\Services\Guest\GuestServiceInterface::class, \App\Services\Guest\GuestService::class);
        $this->app->bind(\App\Services\Slug\SlugServiceInterface::class, \App\Services\Slug\SlugService::class);
        $this->app->bind(\App\Services\Widget\WidgetServiceInterface::class, \App\Services\Widget\WidgetService::class);
        //:end-bindings:
    }
}
