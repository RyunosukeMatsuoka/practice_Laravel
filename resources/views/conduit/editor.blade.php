@extends('layout')
@section('title', 'Edit Article | ')
@section('content')
<div class="editor-page">
    <div class="container page">
        <div class="row">
        <div class="col-md-10 offset-md-1 col-xs-12">
            <ul class="error-messages">
            </ul>

            <form method="POST" action=" {{route('update')}} ">
            @csrf
            <input type="hidden" name="id" value="{{ $article->id }}"/>
            <fieldset>
                <fieldset class="form-group">
                    <input type="text" class="form-control form-control-lg" placeholder="Article Title" name="title" value="{{ $article->title }}"/>
                </fieldset>
                <fieldset class="form-group">
                    <input type="text" class="form-control" placeholder="What's this article about?" name="outline" value="{{ $article->outline }}"/>
                </fieldset>
                <fieldset class="form-group">
                    <textarea
                        class="form-control"
                        rows="8"
                        placeholder="Write your article (in markdown)"
                        name="content"
                    >{{ $article->content }}</textarea>
                </fieldset>
                <fieldset class="form-group">
                    <input type="text" class="form-control" placeholder="Enter tags" />
                    <div class="tag-list">
                        <span class="tag-default tag-pill"> <i class="ion-close-round"></i> tag </span>
                    </div>
                </fieldset>
                <button type="submit" class="btn btn-lg pull-xs-right btn-primary">
                Edit Article
                </button>
            </fieldset>
            </form>
        </div>
        </div>
    </div>
</div>
@endsection
