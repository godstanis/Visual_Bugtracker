@extends('user.layouts.main')
@section('styles')
<link rel="stylesheet" href="{{ asset('css/croppie.css') }}" />
@endsection

@section('scripts')
<script src="{{ asset('js/croppie.js') }}"></script>
<script src="{{ asset('js/image-upload-input.js') }}"></script>
@endsection

@section('user-page-content')



    <div class="span2 text-center">
        <img class="image-update" src="{{$profileImagePath}}" width="124px" height="124px">
    </div>

    <form action="{{ route('user.update') }}" method="post" enctype="multipart/form-data">
        <div class="image-input-block">
            <input type="file" id="image-input" name="profile_image">
            <label for="image-input"><span class="glyphicon glyphicon-picture"></span> @lang('custom.choose_image_file')</label>
            <button class="btn btn-success image-upload-submit hidden">OK</button>
        </div>
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
    </form>
    
    <div class="span8">
        <h5>Email: {{$userEmail}}</h5>
    </div>


<script>

</script>

@endsection