<?php

namespace App\Providers;

use App\Board;
use App\Issue;
use App\IssueDiscussion;
use App\Observers\IssueDiscussionObserver;
use App\Project;

use App\Repositories\BoardRepository;
use App\Repositories\ProjectRepository;
use App\Repositories\UserRepository;

use App\Observers\BoardObserver;
use App\Observers\IssueObserver;
use App\Observers\ProjectObserver;

use App\Services\FileUpload\FileUploadContract;
use App\Services\FileUpload\AvatarUploadService;
use App\Services\FileUpload\BoardImageUploadService;
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
        Board::observe(BoardObserver::class);
        IssueDiscussion::observe(IssueDiscussionObserver::class);
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

        app()->when(BoardRepository::class)->needs(FileUploadContract::class)
            ->give(function() {
                return new BoardImageUploadService(config('images.boards_images_dir'));
            });

    }
}
