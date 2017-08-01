@extends('layouts.project')


@section('project-content')
{!! Breadcrumbs::render('activity', $project) !!}

<table class="table">
    <thead>
      <tr>
        <th>@lang('projects.activity_action')</th>
        <th>@lang('projects.activity_date')</th>
      </tr>
    </thead>
    <tbody>
    @foreach($activities as $activity)
      <tr>
        <td>{{ $activity->description }}</td>
        <td>{{ date('F d, Y', strtotime($activity->created_at)) }}</td>
      </tr>
    @endforeach
    </tbody>
</table>
@endsection