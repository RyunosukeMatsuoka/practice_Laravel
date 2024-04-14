@extends('Unauth_layout')
@section('title', 'Article | ')
@section('content')
<div class="article-page">
    <div class="banner">
        <div class="container">
        <h1>{{ $article->title }}</h1>

        <div class="article-meta">
            <a href="/profile/eric-simons"><img src="http://i.imgur.com/Qr71crq.jpg" /></a>
            <div class="info">
                    <a href="/profile/eric-simons" class="author"> {{ $user->name }} </a>
            <span class="date"> {{ $article->created_at }} </span>
            </div>
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
            <a href="" class="author"> {{ $user->name }} </a>
            <span class="date">{{ $article->created_at }}</span>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection
