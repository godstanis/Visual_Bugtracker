<?php

/*
|--------------------------------------------------------------------------
| BreadCrumbs routes
|--------------------------------------------------------------------------
|
| Routes for laravel-breadcrumbs package
|
*/

//Home
Breadcrumbs::register('home', function($breadcrumbs)
{
    $breadcrumbs->push( trans('projects.home') , route('home'));
});

//Projects
Breadcrumbs::register('projects', function($breadcrumbs)
{
    $breadcrumbs->parent('home');
    $breadcrumbs->push(trans('projects.my_projects'), route('bugtracker.projects'));
});

//Projects > Project_id
Breadcrumbs::register('project', function($breadcrumbs, $project)
{
    $breadcrumbs->parent('projects');
    $breadcrumbs->push(trans('projects.project').' "'.$project->name.'"', route('bugtracker.project', $project->id));
});

//Projects > Project_id > Issues
Breadcrumbs::register('issues', function($breadcrumbs, $project)
{
    $breadcrumbs->parent('project', $project);
    $breadcrumbs->push(trans('projects.issues'), route('project.issues', $project->id));
});

//Projects > Project_id > Issues
Breadcrumbs::register('discussion', function($breadcrumbs, $project, $issue)
{
    $breadcrumbs->parent('issues', $project);
    $breadcrumbs->push(trans('projects.issue_discussion',['id'=>$issue->title]), route('project.issue.discussion', ['issue'=>$issue, 'project'=>$project->id]));

});

//Projects > Project_id > Boards
Breadcrumbs::register('boards', function($breadcrumbs, $project)
{
    $breadcrumbs->parent('project', $project);
    $breadcrumbs->push(trans('projects.boards'), route('project.boards', $project->id));
});

//Projects > Project_id > Activity
Breadcrumbs::register('activity', function($breadcrumbs, $project)
{
    $breadcrumbs->parent('project', $project);
    $breadcrumbs->push(trans('projects.activity'), route('project.activity', $project->id));
});

//Projects > Project_id > Settings
Breadcrumbs::register('settings', function($breadcrumbs, $project)
{
    $breadcrumbs->parent('project', $project);
    $breadcrumbs->push(trans('projects.settings'), route('project.settings', $project->id));
});

//Projects > Project_id > Team
Breadcrumbs::register('team', function($breadcrumbs, $project)
{
    $breadcrumbs->parent('project', $project);
    $breadcrumbs->push(trans('projects.team'), route('project.team', $project->id));
});
