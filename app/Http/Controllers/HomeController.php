<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Article_tag;
use App\Models\Tag;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * 記事一覧を表示
     * @return view
     */
    public function showList()
    {
        $articles = Article::orderBy('created_at', 'desc')->paginate(25);
        $article_tags = Article_tag::all();
        $tags = Tag::all();
        $users = User::all();

        return view('conduit.home', compact('articles', 'article_tags', 'tags', 'users'));
    }

    /**
     * タグごとに記事を表示
     * @param int $id
     * @return view
     */
    public function showSortList($id)
    {
        $tag = Tag::find($id);
        $tag_articles = Article_tag::where('tag_id', $tag->id)->get();
        $article_ids = $tag_articles->pluck('article_id')->toArray();
        $articles = Article::whereIn('id', $article_ids)->orderBy('created_at', 'desc')->paginate(25);

        $users = User::all();
        $article_tags = Article_tag::all();
        $tags = Tag::all();

        return view('conduit.home_tag', compact('articles', 'article_tags', 'tag','tags', 'users'));
    }

    /**
     * ユーザーの記事を表示
     * @param int $user_id
     * @return view
     */
    public function showOwnList($user_id)
    {
        $articles = Article::where('user_id', $user_id)->orderBy('created_at', 'desc')->paginate(25);
        $user = User::where('id', $user_id)->first();
        $article_tags = Article_tag::all();
        $tags = Tag::all();

        return view('conduit.home_own', compact('articles', 'article_tags', 'tags', 'user'));
    }
}
