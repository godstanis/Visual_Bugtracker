@extends('layouts.project')

@section('styles')
<link rel="stylesheet" href="{{ asset('css/bugtracker/project.css') }}" />
<link rel="stylesheet" href="{{ asset('css/bugtracker/team.css') }}" />
@endsection

@section('scripts')
<script> // TODO: Refactor this madness
$(document).ready(function() {

    let delay = (function() {
        let timer = 0;
        return function(callback, ms) {
            clearTimeout (timer);
            timer = setTimeout(callback, ms);
        };
    })();

    $('.user-name-search-input').keyup(function(e) {
        let input_element = $(e.target);
        let input_val = $(e.target).val();
        console.log (input_val);

        let url = "{{route('project.team.search', ['project'=>$project, 'name'=>'query_string'])}}";

        url = url.replace('query_string', input_val);

        delay(function() {
            if(input_val==="") {
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

        function showResults(results) {
            $('.user-name-search-results').html('');
            let users_view = formTableView(results);

            $('.user-name-search-results').append(users_view);

            setFoundUserAddEvent(input_element);
        }

        function formTableView(users)
        {
            let view;

            for(let i=0; i<users.length; i++) {
                view += returnLink(users[i]['name'], users[i]['profile_url'], users[i]['profile_image_url']);
            }

            function returnLink(user_name, profile_url, profile_image_url) {
                return '<tr><td>\
                <a href="'+profile_url+'"> \
                    <span>@</span>'+user_name+' \
                </a> \
                <img class="user-profile-image" src="'+profile_image_url+'" alt="" width="20px"> \
                <span class="insert-in-input-block"><a href="'+user_name+'" class="btn btn-success btn-xs insert-user-in-input"><span class="glyphicon glyphicon-plus"></span></a></span>\
                </tr></tr>';
            }

            return view;
        }

        function setFoundUserAddEvent(input)
        {
            $('.insert-in-input-block a.insert-user-in-input').click({input_element: input},function(e){
                e.preventDefault();
                let user_name = $(e.target).attr('href');

                if(user_name === undefined) { // if clicked on icon inside a
                    user_name = $(e.target).closest('a').attr('href');
                }

                let input = e.data.input_element;

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

    @foreach($members as $member)
      <tr>
        <td>
            <a href="{{ route('user', ['user_name'=>$member->name]) }}">
                <span>@</span>{{ $member->name }}
                <img class="user-profile-image" src="{{ $member->imageLink() }}" alt="" width="20px">
            </a>
            @if($member->can('delete', $project))
                <div class="project-creator-badge" title="Project creator"><b>@lang('projects.team_creator_badge')</b></div>
            @else
                @can('delete', $project)
                <form class="member-delete-form" action="{{ route('project.team.remove', ['project'=>$project, 'user'=>$member]) }}" method="GET">
                <button class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></button>
                    <input type="hidden" name="_token" value="{{csrf_token()}}">
                </form>
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
    <div class="col-md-12">
        <table class="table table-inverse">
            <tbody class="user-name-search-results">
                
            </tbody>
        </table>
    </div>
</form>

@endcan

@endsection
