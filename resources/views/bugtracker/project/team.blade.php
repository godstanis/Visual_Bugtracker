@extends('layouts.project')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/bugtracker/project.css') }}" />
<link rel="stylesheet" href="{{ asset('css/bugtracker/team.css') }}" />
@endsection

@section('scripts')
<script>
$(document).ready(function() {

    var delay = (function(){
        var timer = 0;
        return function(callback, ms){
            clearTimeout (timer);
            timer = setTimeout(callback, ms);
        };
    })();

    $('.user-name-search-input').keyup(function(e){
        var input_element = $(e.target);
        var input_val = $(e.target).val();
        console.log (input_val);

        var url = "{{route('project.team.search', ['project_id'=>$project->id, 'search_query'=>'query_string'])}}";

        url = url.replace('query_string', input_val);

        delay(function(){
            if(input_val===""){
                showResults('');
                return false;
            }
            $.ajax({
                type: "GET",
                url: url,
                success: function(data){
                    console.log (data);
                    showResults(data)
                }
            });
        }, 200);

        function showResults(results)
        {
            $('.user-name-search-results').html('');
            var users_view = formTableView(results);

            $('.user-name-search-results').append(users_view);

            setFoundUserAddEvent(input_element);
        }

        function formTableView(users)
        {
            var view;
            var user_link = returnLink;

            for(var i=0; i<users.length; i++){
                //view += '<tr><td>'+returnLink(users[i])+'</tr></tr>';
                view += '<tr><td>'+returnLink(users[i]['name'], users[i]['avatar'])+'</tr></tr>';
            }

            return view;

            function returnLink(user_name, profile_image)
            {
                var link = '\
                <a href="{{ route("user", ["user_name"=>"user_name_string"]) }}"> \
                    <span>@</span>user_name_string \
                    <img class="user-profile-image" src="{{ config('images.amazon_base_link') . config('images.user_avatar_dir') }}/'+profile_image+'" alt="" width="20px"> \
                </a> \
                <span class="insert-in-input-block"><a href="user_name_string" class="btn btn-success btn-xs insert-user-in-input"><span class="glyphicon glyphicon-plus"></span></a></span>\
                ';

                link = link.replace(/user_name_string/g, user_name);

                return link;
            }
        }

        function setFoundUserAddEvent(input)
        {
            $('.insert-in-input-block a.insert-user-in-input').click({input_element: input},function(e){
                e.preventDefault();
                var user_name = $(e.target).attr('href');

                if(user_name === undefined){ // if clicked on icon inside a
                    user_name = $(e.target).closest('a').attr('href');
                }

                var input = e.data.input_element;

                input.val(user_name);
            });
        }
        
    });
});
</script>
@endsection

@section('project-content')
{!! Breadcrumbs::render('team', $project) !!}

<table class="table">
    <tbody>
    @foreach($project_access as $access)
      <tr>
        <td>
            <a href="{{ route('user', ['user_name'=>$access->user->name]) }}">
                <span>@</span>{{ $access->user->name }}
                <img class="user-profile-image" src="{{ $access->user->imageLink() }}" alt="" width="20px"></a>
            </a>
            @if($access->user->can('delete', $project))
                <div class="project-creator-badge" title="Project creator"><b>@lang('projects.team_creator_badge')</b></div>
            @else
                @can('delete', $project)
                <form class="member-delete-form" action="{{ route('project.team.remove', ['project'=>$project, 'user'=>$access->user]) }}" method="POST">
                <button class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></button>
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                </form>
                <!--
                    <a href="{{ route('project.team.remove', ['project'=>$project, 'user'=>$access->user]) }}" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></a>
                    -->
                    
                @endcan
            @endif
        </td>
      </tr>
    @endforeach
    </tbody>
</table>

@can('delete', $project)
<form action="{{ route('project.team.add', ['project'=>$project]) }}" method="POST" class="col-md-6 col-md-offset-3 {{$errors->has('user_name') ? ' has-error' : ''}}">
    <div class="input-group ">
        <span class="input-group-addon" id="sizing-addon2">@</span>
        <input class="form-control user-name-search-input" type="text" name="user_name" placeholder="@lang('projects.team_username_placeholder')">
        <span class="input-group-btn">
            <button class="btn btn-success ">@lang('projects.team_add')</button>
        </span>

        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </div>
    @if ($errors->has('user_name'))
            <span class="help-block">
                <strong>{{ $errors->first('user_name') }}</strong>
            </span>
        @endif
    <div class="col-md-6">
        <table class="table table-inverse">
            <tbody class="user-name-search-results">
                
            </tbody>
        </table>
    </div>
</form>

@endcan

@endsection
