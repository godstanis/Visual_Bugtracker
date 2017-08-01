<form action="{{route('project.issue.discussion.create', compact('project', 'issue'))}}" method="POST">
    <div class="form-group{{ $errors->has('message_text') ? ' has-error' : '' }}">
        <textarea class="form-control" name="message_text" id="" style="width: 100%" placeholder="Message"></textarea>
        @if ($errors->has('message_text'))
            <span class="help-block">
                <strong>{{ $errors->first('message_text') }}</strong>
            </span>
        @endif
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <button class="btn btn-success pull-right">Send</button>
        <br>
    </div>
</form>
