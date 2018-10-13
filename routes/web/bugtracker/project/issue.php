<?php

/*
|--------------------------------------------------------------------------
| Bugtracker\Project\Issue Routes
|--------------------------------------------------------------------------
|
| Issue related routes are listed here.
|
*/

Route::group(['prefix'=>'{project}/issues', 'middleware'=>'auth', 'namespace'=>'Bugtracker'], function(){

    Route::get('', 'IssuesController@getProjectIssues')
        ->name('project.issues');
    Route::post('create-issue', 'IssuesController@postCreateIssue')
        ->name('project.issue.create');

    Route::get('delete_issue/{issue}', 'IssuesController@getDeleteIssue')
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
