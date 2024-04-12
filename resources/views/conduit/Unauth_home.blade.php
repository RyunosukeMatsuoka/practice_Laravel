@extends('Unauth_layout')
@section('title', '')
@section('content')
<div class="home-page">
    <div class="banner">
        <div class="container">
        <h1 class="logo-font">conduit</h1>
        <p>A place to share your knowledge.</p>
        </div>
    </div>

    <div class="container page">
        <div class="row">
        <div class="col-md-9">
            <div class="feed-toggle">
            <ul class="nav nav-pills outline-active">
                <li class="nav-item">
                <a class="nav-link active" href="/">Global Feed</a>
                </li>
            </ul>
            </div>
            @foreach($articles as $article)
            <div class="article-preview">
            <div class="article-meta">
                <a href="/profile/eric-simons"><img src="http://i.imgur.com/Qr71crq.jpg" /></a>
                <div class="info">
                @foreach($users as $user)
                    @if($article->user_id === $user->id)
                    <a href="/profile/{{ $user->id }}" class="author">{{ $user->name }}</a>
                    @endif
                @endforeach
                <span class="date">{{ $article->created_at }}</span>
                </div>
                <button class="btn btn-outline-primary btn-sm pull-xs-right">
                <i class="ion-heart"></i> 29
                </button>
            </div>
            <a href="/article/{{ $article->id }}" class="preview-link">
                <h1>{{ $article->title }}</h1>
                <p>{{ $article->outline }}</p>
                <span>Read more...</span>
                <ul class="tag-list">
                @php $stockTags = []; @endphp
                @foreach ($article_tags as $article_tag)
                    @if ($article_tag->article_id === $article->id)
                        @php $stockTags[] = $article_tag->tag_id; @endphp
                    @endif
                @endforeach
                @if (!is_null($stockTags))
                    @foreach ($stockTags as $stockTag)
                        @foreach ($tags as $tag)
                            @if ($stockTag === $tag->id)
                                <li class="tag-default tag-pill tag-outline">{{ $tag->name }}</li>
                            @endif
                        @endforeach
                    @endforeach
                @endif
                </ul>
            </a>
            </div>
            @endforeach

            {{ $articles->links() }}
        </div>

        <div class="col-md-3">
            <div class="sidebar">
            <p>Popular Tags</p>

            <div class="tag-list">
                @foreach ($tags as $tag)
                <a href="/tag/{{ $tag->id }}" class="tag-pill tag-default">{{ $tag->name }}</a>
                @endforeach
            </div>
            </div>
        </div>
        </div>
    </div>
</div>
@endsection
