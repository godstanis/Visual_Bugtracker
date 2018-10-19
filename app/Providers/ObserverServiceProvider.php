<?php

namespace App\Providers;

use App\IssueDiscussion;
use App\Project;
use App\Board;
use App\Path;
use App\Issue;

use App\Observers\IssueDiscussionObserver;
use App\Observers\Project\ProjectObserver;
use App\Observers\Board\BoardObserver;
use App\Observers\IssueObserver;
use App\Observers\PathObserver;


use App\Services\FileUpload\AbstractFileUploadService;
use App\Services\FileUpload\ProjectImageUploadService;
use App\Services\FileUpload\BoardImageUploadService;

use App\Observers\Project\ProjectImageObserver;
use App\Observers\Board\BoardImageObserver;

use Illuminate\Support\ServiceProvider;

class ObserverServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Project::observe([
            ProjectObserver::class,
            ProjectImageObserver::class
        ]);
        Board::observe([
            BoardObserver::class,
            BoardImageObserver::class
        ]);

        Issue::observe(IssueObserver::class);
        IssueDiscussion::observe(IssueDiscussionObserver::class);
        Path::observe(PathObserver::class);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        /*
         * Observers
         */
        app()->when(ProjectImageObserver::class)->needs(AbstractFileUploadService::class)
            ->give(function() {
                return new ProjectImageUploadService(config('images.project_thumb_dir'));
            });
        app()->when(BoardImageObserver::class)->needs(AbstractFileUploadService::class)
            ->give(function() {
                return new BoardImageUploadService(config('images.boards_images_dir'));
            });
    }
}
