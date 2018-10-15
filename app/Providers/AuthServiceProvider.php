<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

use App\Path;
use App\Issue;
use App\Project;

use App\Board;
use App\Policies\BoardPolicy;
use App\Policies\PathPolicy;
use App\Policies\IssuesPolicy;
use App\Policies\ProjectPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Project::class => ProjectPolicy::class,
        Issue::class => IssuesPolicy::class,
        Board::class => BoardPolicy::class,
        Path::class => PathPolicy::class
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

    }
}
