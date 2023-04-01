@extends('layouts.app')
@section('head')
    <link rel="stylesheet" href="{{ URL::asset('css/users.css') }}">
@endsection
@section('content')
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Can Publish Posts</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
        @foreach ($users as $user)
            <tr>
                <td>
                    {{ $user['id'] }}
                </td>
                <td>
                    {{ $user['name'] }}
                </td>
                <td>
                    {{ $user['email'] }}
                </td>
                <td>
                    {{ $user['canPublishPosts'] ? 'Yes' : 'No' }}
                </td>
                <td>
                    {{ $user['createdAt'] }}
                </td>
                <td>
                    <a href="user?id={{ $user['id'] }}" class="btn btn-primary">Edit</a>
                    @if ($user['id'] != 1)
                        <a href="user?id={{ $user['id'] }}&event=delete" class="btn btn-danger">Delete</a>
                    @endif
                </td>
        @endforeach
    </table>
@endsection