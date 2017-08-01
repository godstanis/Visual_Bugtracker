
@foreach($discussion as $post)
    <div class="issue-discussion-box">

        <span class="issue-discussion-text">
            {{ $post->text }}
        </span>
        <div class="issue-discussion-credentials text-muted">
            <div class="issue-discussion-created-at">
                {{ $post->created_at->diffForHumans() }}
            </div>
            <div class="issue-discussion-user pull-right">
                <a href="{{ route('user', ['user_name'=>$post->creator->name]) }}">
                    <span>@</span>{{ $post->creator->name }}
                    <img class="user-profile-image" src="https://s3.eu-central-1.amazonaws.com/bugwall.ru/user_profile_images/{{ $post->creator->profile_image }}" alt="" width="20px"></a>
                </a>
            </div>
        </div>

    </div>
@endforeach
