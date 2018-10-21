<?php

namespace App\Providers;

use App\Services\ImageUpload\AbstractFileUploadService;
use App\Services\ImageUpload\AvatarUploadService;

use App\Services\User\AbstractUserActivationService;
use App\Services\User\UserActivationService;
use App\Services\User\AbstractUserService;
use App\Services\User\UserService;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

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

        app()->bind(AbstractUserActivationService::class, function($app, $parameters) {
            return app()->makeWith(UserActivationService::class, $parameters);
        });
    }
}
