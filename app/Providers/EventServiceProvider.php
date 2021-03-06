<?php

namespace App\Providers;

use App\Models\File;
use App\Models\Post;
use App\Models\Term;
use App\Models\Episode;
use App\Observers\FileObserver;
use App\Observers\PostObserver;
use App\Observers\TermObserver;
use App\Observers\EpisodeObserver;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        Term::observe(TermObserver::class);
        File::observe(FileObserver::class);
        Post::observe(PostObserver::class);
        Episode::observe(EpisodeObserver::class);
    }
}
