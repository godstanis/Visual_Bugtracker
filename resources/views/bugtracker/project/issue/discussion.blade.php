@extends('layouts.project')

@section('styles')
    <link rel="stylesheet" href="{{ asset('css/bugtracker/issue-discussion.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/bugtracker/issue.css') }}" />
@endsection

@section('project-content')
{!! Breadcrumbs::render('discussion', $project, $issue) !!}
<h1 class="text-muted"><span class="glyphicon glyphicon-comment"></span> @lang('projects.issue_discussion',['id'=>$issue->title])</h1>
<div class="col-md-6 col-xs-12">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4>{{$issue->title}}</h4>

        </div>
        <div class="panel-body">

            <table class="table table-issues-mobile table-bordered table-hover table-responsive">
             
                <tbody>
            
                    <tr>
                        <th colspan=2>Id: {{ $issue->id }}</th>
                    </tr>
                    <tr>
                        <td colspan=2><b>@lang('projects.issue_title'): </b> {{ $issue->title }}</td>
                    </tr>
                    <tr>
                        <td colspan=2 class="table-issue-description"><b>@lang('projects.issue_description'): </b> {{ $issue->description }}</td>
                    </tr>
                    <tr>
                        <td>
                            <b>@lang('projects.issue_type')</b>
                            <div class="issue-badge {{ $issue->type->title }}-type">{{ $issue->type->title }}</div>
                        </td>
                
                        <td >
                            <b>@lang('projects.issue_priority')</b>
                            <div class="issue-badge {{ $issue->priority->title }}-priority">{{ $issue->priority->title }}</div>
                        </td>
                    </tr>
                    <tr>
                        <td colspan=2>
                            <b>@lang('projects.issue_creator'): </b>
                            <a href="{{ route('user', ['user_name'=>$issue->creator->name]) }}">
                                <span>@</span>{{ $issue->creator->name }}
                                <img class="user-profile-image" src="{{ $issue->creator->imageLink() }}" alt="" width="20px">
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td colspan=2>
                            <b>@lang('projects.issue_assigned_to'): </b>
                            <a href="{{ route('user', ['user_name'=>$issue->assignedUser->name]) }}">
                                <span>@</span>{{ $issue->assignedUser->name }}
                                <img class="user-profile-image" src="{{ $issue->assignedUser->imageLink() }}" alt="" width="20px"></a>
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td><b>@lang('projects.issue_created_at'): </b> {{ date('m-d-Y, h:s', strtotime($issue->created_at)) }}</td>
                    </tr>
                    <tr>
                        <td><b>@lang('projects.issue_updated_at'): </b>{{ $issue->updated_at->diffForHumans() }}</td>
                    </tr>
                </tbody>
            </table>
            @can('delete', $issue)
                @if(!$issue->closed)
                <form action="{{route('project.issue.close', compact('project', 'issue'))}}" method="POST">
                <button class="btn btn-success pull-right"><span class="glyphicon glyphicon-ok"></span> Close issue</button>
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                </form>
                @endif
                @if($issue->closed)
                <form action="{{route('project.issue.open', compact('project', 'issue'))}}" method="POST">
                <button class="btn btn-warning pull-right"><span class="glyphicon glyphicon-repeat"></span> Re-open issue</button>
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                </form>
                @endif
            @endcan
        </div>
        
    </div>

</div>
<div class="col-md-6">
    <h3 class="text-muted">Сообщения</h3>
    <div class="issue-discussion-container">
        @include('bugtracker.project.issue.partials.messages-block')
    </div>
    <hr>
    <div class="alert">
        @include('bugtracker.project.issue.partials.create-message-form')
    </div>
</div>



@endsection