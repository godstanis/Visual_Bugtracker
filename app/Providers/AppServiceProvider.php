<?php

namespace App\Providers;

use App\Board;
use App\Http\Controllers\User\UserController;
use App\Issue;
use App\IssueDiscussion;
use App\Observers\IssueDiscussionObserver;
use App\Observers\PathObserver;
use App\Path;
use App\Project;

use App\Repositories\BoardRepository;
use App\Repositories\ProjectRepository;

use App\Observers\BoardObserver;
use App\Observers\IssueObserver;
use App\Observers\ProjectObserver;

use App\Services\FileUpload\FileUploadContract;
use App\Services\FileUpload\AvatarUploadService;
use App\Services\FileUpload\BoardImageUploadService;
use App\Services\FileUpload\ProjectImageUploadService;

use App\Services\User\UserService;
use App\Services\User\AbstractUserService;
use App\User;
use Illuminate\Pagination\Paginator;
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
        Paginator::useBootstrapThree();

        Project::observe(ProjectObserver::class);
        Issue::observe(IssueObserver::class);
        Board::observe(BoardObserver::class);
        IssueDiscussion::observe(IssueDiscussionObserver::class);
        Path::observe(PathObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        app()->bind(AbstractUserService::class, function($app, $parameters) {
            return app()->makeWith(UserService::class, $parameters);
        });

        app()->when(UserService::class)->needs(FileUploadContract::class)
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
