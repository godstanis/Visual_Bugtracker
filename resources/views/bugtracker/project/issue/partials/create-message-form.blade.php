<form action="{{route('project.issue.discussion.create', compact('project', 'issue'))}}" method="POST">
    <div class="form-group{{ $errors->has('message_text') ? ' has-error' : '' }}" style="margin:0">
        <textarea class="form-control" name="message_text" placeholder="Message" rows="3" style="border:none"></textarea>
        @if ($errors->has('message_text'))
            <span class="help-block">
                <strong>{{ $errors->first('message_text') }}</strong>
            </span>
        @endif
        <input type="hidden" name="_token" value="{{csrf_token()}}">

        <div class="message-form-controls" style="height:30px">
            <button class="btn btn-success" style="float: right">Send</button>
        </div>
    </div>
</form>
