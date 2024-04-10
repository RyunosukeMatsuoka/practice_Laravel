<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Article_tag;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;

class ConduitController extends Controller
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

        return view('conduit.home', [
                'articles' => $articles,
                'article_tags' => $article_tags,
                'tags' => $tags,
                'users' => $users,
            ]
        );
    }

    /**
     * 記事詳細を表示
     * @param int $id
     * @return view
     */
    public function showDetail($id)
    {
        $article = Article::find($id);
        $users = User::all();

        return view('conduit.article', [
                'article' => $article,
                'users' => $users,
            ]
        );
    }

    /**
     * 記事作成画面を表示
     * @return view
     */
    public function showCreate()
    {
        return view('conduit.create');
    }

    /**
     * 記事を登録する
     * @param object $request
     * @return view
     */
    public function exeStore(Request $request)
    {
        $inputs = $request->all();
        // 認証認可で修正
        $inputs['user_id'] = 4;
        Article::create($inputs);

        return redirect(route('articles'));
    }

    /**
     * 記事編集画面を表示
     * @param int $id
     * @return view
     */
    public function showEditor($id)
    {
        $article = Article::find($id);
        $users = User::all();

        return view('conduit.editor', [
                'article' => $article,
                'users' => $users,
            ]
        );
    }

    /**
     * 記事を更新する
     * @param object $request
     * @return view
     */
    public function exeUpdate(Request $request)
    {
        $inputs = $request->all();
        $article = Article::find($inputs['id']);

        $article->title = $inputs['title'];
        $article->outline = $inputs['outline'];
        $article->content = $inputs['content'];

        $article->save();

        return redirect(route('articles'));
    }

    /**
     * 記事を削除
     * @param int $id
     * @return view
     */
    public function exeDelete($id)
    {
        Article::destroy($id);

        return redirect(route('articles'));
    }
}
