<?php

/*
|--------------------------------------------------------------------------
| Bugtracker Routes
|--------------------------------------------------------------------------
|
| Bugtracker related routes are stored here.
|
*/

Route::group(['prefix'=>'bugtracker', 'middleware'=>'auth', 'namespace'=>'Bugtracker'], function(){


    Route::group(['prefix'=>'projects'], function(){

        Route::get('', 'ProjectsController@getAvailableProjects')
            ->name('bugtracker.projects');
        Route::post('create-project', 'ProjectsController@postCreateProject')
            ->name('bugtracker.create_project');

    });


    Route::group(['prefix'=>'projects/{project}', 'middleware'=>'can:view,project'], function(){

        Route::get('', 'ProjectsController@getProjectById')
            ->name('bugtracker.project');

        Route::post('delete-project', 'ProjectsController@postDeleteProject')
            ->name('bugtracker.delete_project')->middleware('can:delete,project');

        Route::group(['prefix'=>'boards'], function(){

            Route::get('', 'BoardsController@getProjectBoards')
                ->name('project.boards');
            Route::post('create-board', 'BoardsController@postCreateBoard')
                ->name('project.create_board');
            Route::post('{board}/delete-board', 'BoardsController@postDeleteBoard')
                ->name('project.delete_board')->middleware('can:delete,board');

        });



        Route::group(['prefix'=>'issues'], function(){

            Route::get('', 'IssuesController@getProjectIssues')
                ->name('project.issues');
            Route::post('create-issue', 'IssuesController@postCreateIssue')
                ->name('project.issue.create');

            Route::post('delete_issue/{issue}', 'IssuesController@postDeleteIssue')
                ->name('project.issue.delete')->middleware('can:delete,issue');
            Route::post('close_issue/{issue}', 'IssuesController@closeIssue')
                ->name('project.issue.close')->middleware('can:delete,issue');
            Route::post('open_issue/{issue}', 'IssuesController@openIssue')
                ->name('project.issue.open')->middleware('can:delete,issue');


            Route::get('{issue}/discussion', 'IssueDiscussionController@getDiscussion')
                ->name('project.issue.discussion');
            Route::post('{issue}/discussion', 'IssueDiscussionController@createMessage')
                ->name('project.issue.discussion.create');


        });


        Route::group(['prefix'=>'team'], function(){

            Route::get('', 'TeamController@getAllTeamMembers')
                ->name('project.team');
            Route::post('add-member', 'TeamController@postAddMember')
                ->name('project.team.add')->middleware('can:delete,project');
            Route::post('delete-member/{user}', 'TeamController@postRemoveMember')
                ->name('project.team.remove')->middleware('can:delete,project');
            // TODO: GET->POST
            Route::get('search-member', 'TeamController@searchUser')
                ->name('project.team.search')->middleware('can:delete,project');

        });


        Route::group(['prefix'=>'settings'], function(){

            Route::get('', 'ProjectsController@getSettingsPage')
                ->name('project.settings');
            Route::post('', 'ProjectsController@postUpdateProject')
                ->name('project.settings')->middleware('can:delete,project');

        });


        Route::get('activity', 'ActivityController@getProjectActivities')
            ->name('project.activity');


        Route::group(['prefix'=>'editor'], function(){


            Route::post('{board}/delete-path', 'PathController@deletePath')
                ->name('board.delete_path');
            Route::post('{board}/create-path', 'PathController@savePath')
                ->name('board.create_path');

            Route::get('{board?}', 'EditorController@getEditor')->name('project.editor');


        });

    });

});
