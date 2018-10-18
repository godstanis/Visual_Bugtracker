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
use App\Observers\Project\ProjectObserver;
use App\Observers\Project\ProjectImageObserver;

use App\Services\FileUpload\AbstractFileUploadService;
use App\Services\FileUpload\AvatarUploadService;
use App\Services\FileUpload\BoardImageUploadService;
use App\Services\FileUpload\ProjectImageUploadService;

use App\Services\User\AbstractUserActivationService;
use App\Services\User\UserActivationService;
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

        Project::observe([
            ProjectObserver::class,
            ProjectImageObserver::class,
        ]);
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
        /*
         * User services
         */
        app()->bind(AbstractUserService::class, function($app, $parameters) {
            return app()->makeWith(UserService::class, $parameters);
        });
        app()->when(UserService::class)->needs(AbstractFileUploadService::class)
            ->give(function() {
                return new AvatarUploadService(config('images.user_avatar_dir'));
            });
        // UserActivationService
        app()->bind(AbstractUserActivationService::class, function($app, $parameters) {
            return app()->makeWith(UserActivationService::class, $parameters);
        });

        /*
         * Observers
         */
        app()->when(ProjectImageObserver::class)->needs(AbstractFileUploadService::class)
            ->give(function() {
                return new ProjectImageUploadService(config('images.project_thumb_dir'));
            });

        /*
         * Repositories
         */
        app()->when(BoardRepository::class)->needs(AbstractFileUploadService::class)
            ->give(function() {
                return new BoardImageUploadService(config('images.boards_images_dir'));
            });
    }
}
