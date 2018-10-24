<?php

/*
|--------------------------------------------------------------------------
| Bugtracker\Project\Issue Routes
|--------------------------------------------------------------------------
|
| Issue related routes are listed here.
|
*/

Route::group(['prefix'=>'{project}/issues', 'middleware'=>['auth', 'can:view,project'], 'namespace'=>'Bugtracker'], function(){

    Route::get('', 'IssuesController@getProjectIssues')
        ->name('project.issues');
    Route::post('create', 'IssuesController@postCreateIssue')
        ->name('project.issue.create');

    Route::get('{issue}/delete', 'IssuesController@getDeleteIssue')
        ->name('project.issue.delete')->middleware('can:delete,issue');
    Route::post('{issue}/close', 'IssuesController@closeIssue')
        ->name('project.issue.close')->middleware('can:close,issue');
    Route::post('{issue}/open', 'IssuesController@openIssue')
        ->name('project.issue.open')->middleware('can:close,issue');

    Route::get('{issue}/discussion', 'IssueDiscussionController@getDiscussion')
        ->name('project.issue.discussion');
    Route::post('{issue}/discussion', 'IssueDiscussionController@createMessage')
        ->name('project.issue.discussion.create');

    Route::get('{issue}/attach/{user}', 'IssuesController@attachUser')
        ->name('project.issue.attach_user')->middleware('can:attach,issue,user');
    Route::get('{issue}/detach/{user}', 'IssuesController@detachUser')
        ->name('project.issue.detach_user')->middleware('can:attach,issue,user');

});
