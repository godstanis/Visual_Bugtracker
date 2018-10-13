<?php

namespace App\Providers;

use App\Issue;
use App\Project;
use App\Observers\IssueObserver;
use App\Observers\ProjectObserver;

use App\Repositories\ProjectRepository;
use App\Repositories\UserRepository;
use App\Services\FileUpload\AvatarUploadService;
use App\Services\FileUpload\FileUploadContract;

use App\Services\FileUpload\ProjectImageUploadService;
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
        Issue::observe(IssueObserver::class);
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

        app()->when(ProjectRepository::class)->needs(FileUploadContract::class)
            ->give(function() {
                return new ProjectImageUploadService(config('images.project_thumb_dir'));
            });

    }
}
