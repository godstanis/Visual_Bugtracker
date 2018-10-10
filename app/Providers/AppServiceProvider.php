<?php

namespace App\Providers;

use App\Project;
use App\Observers\ProjectObserver;
use App\Repositories\UserRepository;
use App\Services\FileUpload\AvatarUploadService;
use App\Services\FileUpload\FileUploadContract;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

use Queue;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Project::observe(ProjectObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        app()->when(UserRepository::class)->needs(FileUploadContract::class)
            ->give(function() {
                return new AvatarUploadService(config('images.user_avatar_dir'));
            });

    }
}
