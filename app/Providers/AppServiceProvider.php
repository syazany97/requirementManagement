<?php

namespace App\Providers;

use App\Models\Comment\Comment;
use App\Models\Project\Project;
use App\Observers\CommentObserver;
use App\Observers\ProjectObserver;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Project::observe(ProjectObserver::class);
        Comment::observe(CommentObserver::class);
    }
}
