@extends('layout')
@section('title', 'New Article | ')
@section('content')
<div class="editor-page">
    <div class="container page">
        <div class="row">
        <div class="col-md-6 offset-md-3 col-xs-12">
            <h1 class="text-xs-center">New Article</h1>
            <ul class="error-messages">
            </ul>

            <form method="POST" action=" {{route('store')}} ">
            @csrf
            <fieldset>
                <fieldset class="form-group">
                    <input type="text" class="form-control form-control-lg" placeholder="Article Title" name="title"/>
                </fieldset>
                <fieldset class="form-group">
                    <input type="text" class="form-control" placeholder="What's this article about?" name="outline"/>
                </fieldset>
                <fieldset class="form-group">
                    <textarea
                        class="form-control"
                        rows="8"
                        placeholder="Write your article (in markdown)"
                        name="content"
                    ></textarea>
                </fieldset>
                <fieldset class="form-group">
                    <input type="text" class="form-control" placeholder="Enter tags (separated by commas)" name="tags"/>
                    <div class="tag-list">
                        <span class="tag-default tag-pill"> <i class="ion-close-round"></i> tag </span>
                    </div>
                </fieldset>
                <button type="submit" class="btn btn-lg pull-xs-right btn-primary">
                Publish Article
                </button>
            </fieldset>
            </form>
        </div>
        </div>
    </div>
</div>
@endsection
