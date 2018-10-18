@foreach($discussion as $post)
    <div class="issue-discussion-box">
        <span class="issue-discussion-text">
            {{ $post->text }}
        </span>
        <div class="issue-discussion-credentials text-muted">
            <div class="issue-discussion-created-at">
                {{ $post->created_at->diffForHumans() }}
            </div>
            <div class="issue-discussion-user">
                <a href="{{ route('user', ['user_name'=>$post->creator->name]) }}">
                    <span>@</span>{{ $post->creator->name }}
                    <img src="{{ $post->creator->imageLink() }}" alt="" width="20px">
                </a>
            </div>
        </div>
    </div>
@endforeach
