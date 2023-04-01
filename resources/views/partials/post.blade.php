<div class="post" id="{{ $post['id'] }}">
    <div class="vote">
        <div class="upvote"></div>
        <div class="rating">
            <p>{{ $post['rating'] }}</p>
        </div>
        <div class="downvote"></div>
    </div>
    <div class="content">
        <div class="header">
            <h2 class="title">{{ $post['title'] }}</h2>
            <div class="date">
                <div class="post">
                    <p>{{ $post['date'] }}</p>
                </div>
            </div>
        </div>
        <div class="imgs">
            <div class="selected-image">
                <img src="">
            </div>
            <div class="image-container">
                @foreach ($post['images'] as $image)
                    <div>
                        <img src="{{ $image }}">
                    </div>
                @endforeach
            </div>
        </div>
        <p>
            {{ $post['content'] }}
        </p>
        <div class="files">
            <div class="list">
                @foreach ($post['files'] as $file)
                    @include('partials.file', ['file' => $file])
                @endforeach
            </div>
        </div>
    </div>
</div>
