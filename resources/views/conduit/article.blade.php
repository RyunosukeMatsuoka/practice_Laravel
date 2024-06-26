@extends('layout')
@section('title', 'Article | ')
@section('content')
<form method="POST" action="{{ route('delete', $article->id) }}">
@csrf
@method('DELETE')
<div class="article-page">
    <div class="banner">
        <div class="container">
        <h1>{{ $article->title }}</h1>

        <div class="article-meta">
            <a href="/profile/{{ $user->id }}"><img src="http://i.imgur.com/Qr71crq.jpg" /></a>
            <div class="info">
                    <a href="/profile/{{ $user->id }}" class="author"> {{ $user->name }} </a>
            <span class="date"> {{ $article->created_at }} </span>
            </div>
            <button class="btn btn-sm btn-outline-secondary">
            <i class="ion-plus-round"></i>
                    &nbsp; Follow {{ $user->name }} <span class="counter">(10)</span>
            </button>
            &nbsp;&nbsp;
            <button class="btn btn-sm btn-outline-primary">
            <i class="ion-heart"></i>
            &nbsp; Favorite Post <span class="counter">(29)</span>
            </button>
            @if ($user->id === Auth::user()->id)
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="location.href='/editor/{{ $article->id }}'">
                <i class="ion-edit"></i> Edit Article
                </button>
                <button type="submit" class="btn btn-sm btn-outline-danger">
                <i class="ion-trash-a"></i> Delete Article
                </button>
            @endif
        </div>
        </div>
    </div>

    <div class="container page">
        <div class="row article-content">
        <div class="col-md-12">
            <p>
                {{ $article->content }}
            </p>
            <ul class="tag-list">
                @foreach ($tags as $tag)
                    <li class="tag-default tag-pill tag-outline">{{ $tag->name }}</li>
                @endforeach
            </ul>
        </div>
        </div>

        <hr />

        <div class="article-actions">
        <div class="article-meta">
            <a href="profile.html"><img src="http://i.imgur.com/Qr71crq.jpg" /></a>
            <div class="info">
            <a href="/profile/{{ $user->id }}" class="author"> {{ $user->name }} </a>
            <span class="date">{{ $article->created_at }}</span>
            </div>

            <button class="btn btn-sm btn-outline-secondary">
            <i class="ion-plus-round"></i>
            &nbsp; Follow {{ $user->name }}
            </button>
            &nbsp;
            <button class="btn btn-sm btn-outline-primary">
            <i class="ion-heart"></i>
            &nbsp; Favorite Article <span class="counter">(29)</span>
            </button>
            @if ($user->id === Auth::user()->id)
                <button type="button" class="btn btn-sm btn-outline-secondary" onclick="location.href='/editor/{{ $article->id }}'">
                <i class="ion-edit"></i> Edit Article
                </button>
                <button type="submit" class="btn btn-sm btn-outline-danger">
                <i class="ion-trash-a"></i> Delete Article
                </button>
            @endif
        </div>
        </div>

        <div class="row">
        <div class="col-xs-12 col-md-8 offset-md-2">
            <form class="card comment-form">
            <div class="card-block">
                <textarea class="form-control" placeholder="Write a comment..." rows="3"></textarea>
            </div>
            <div class="card-footer">
                <img class="comment-author-img" src="https://api.realworld.io/images/smiley-cyrus.jpeg">
                <button class="btn btn-sm btn-primary">Post Comment</button>
            </div>
            </form>
        </div>
        </div>
    </div>
</div>
@endsection
