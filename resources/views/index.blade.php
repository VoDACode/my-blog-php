@extends('layouts.app')

@section('head')
    <link rel="stylesheet" href="{{ URL::asset('css/index.css') }}">
@endsection

@section('content')
    <main>
        @include('partials.pub-create-form')
        <div class="post-box">
            @include('partials.post',[
                'post' =>[
                    'id' => 1,
                    'title' => 'Title 1',
                    'date' => '2020-01-01',
                    'rating' => 0,
                    'images' => [
                        'http://placeimg.com/640/480/any',
                        'http://placeimg.com/640/480',
                        'http://placeimg.com/640/480/random',
                        'http://placeimg.com/640/480/food',
                        'http://placeimg.com/640/480/animals',
                        'http://placeimg.com/640/480/any',
                        'http://placeimg.com/640/480',
                        'http://placeimg.com/640/480/random',
                        'http://placeimg.com/640/480/food',
                        'http://placeimg.com/640/480/animals'
                    ],
                    'content' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisl sit amet ultricies lacinia, nisl nisl aliquam libero, eget lacinia nisl nisl eget nisl. Sed euismod, nisl sit amet ultricies lacinia, nisl nisl aliquam libero, eget lacinia nisl nisl eget nisl.',
                    'user' => [
                        'id' => 1,
                        'name' => 'User 1'
                    ],
                    'files' =>[
                        [
                            'id' => 1,
                            'name' => 'file1',
                            'size' => 5946,
                        ]
                    ]
                ]
            ])
            <div class="comments">
                <div class="input-form">
                    <form action="" method="POST">
                        <textarea name="text" placeholder="Comment"></textarea>
                        <input type="submit" value="Submit">
                    </form>
                </div>
                <div class="content">
                    @include('partials.comment', ['comment' => [
                        'id' => 1,
                        'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisl sit amet ultricies lacinia, nisl nisl aliquam libero, eget lacinia nisl nisl eget nisl. Sed euismod, nisl sit amet ultricies lacinia, nisl nisl aliquam libero, eget lacinia nisl nisl eget nisl.',
                        'date' => '2020-01-01',
                        'modified' => '2020-01-01',
                        'rating' => 0,
                        'user' => [
                            'id' => 1,
                            'name' => 'User 1'
                        ],
                        'comments' => [
                            [
                                'id' => 2,
                                'text' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed euismod, nisl sit amet ultricies lacinia, nisl nisl aliquam libero, eget lacinia nisl nisl eget nisl. Sed euismod, nisl sit amet ultricies lacinia, nisl nisl aliquam libero, eget lacinia nisl nisl eget nisl.',
                                'date' => '2020-01-01',
                                'rating' => 0,
                                'user' => [
                                    'id' => 2,
                                    'name' => 'User 2'
                                ],
                                'comments' => []
                            ]
                        ]
                    ]])
                </div>
            </div>
        </div>
    </main>
    <script src="{{ URL::asset('js/index.js') }}"></script>
@endsection
