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

        return view('conduit.home-tag', compact('articles', 'article_tags', 'tag','tags', 'users'));
    }

    /**
     * 記事詳細を表示
     * @param int $id
     * @return view
     */
    public function showDetail($id)
    {
        $article = Article::find($id);
        $article_tags = Article_tag::where('article_id', $article->id)->get();
        $tag_ids = $article_tags->pluck('tag_id')->toArray();
        $tags = Tag::whereIn('id', $tag_ids)->get();
        $user = User::where('id', $article->user_id)->first();

        return view('conduit.article', compact('article', 'tags', 'user'));
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

        $article = Article::create($inputs);

        $tags = explode(',', $inputs['tags']);
        $article->tags()->sync($this->saveTags($tags));

        return redirect(route('articles'));
    }

    /**
     * タグを保存する
     * @param array $tags
     * @return array
     */
    private function saveTags(array $tags)
    {
        $tagIds = [];
        foreach ($tags as $tagName) {
            $tag = Tag::firstOrCreate(['name' => trim($tagName)]);
            $tagIds[] = $tag->id;
        }
        return $tagIds;
    }

    /**
     * 記事編集画面を表示
     * @param int $id
     * @return view
     */
    public function showEditor($id)
    {
        $article = Article::find($id);
        // ここでユーザーを絞りたい
        $users = User::all();

        return view('conduit.editor', compact('article', 'users'));
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

        $article->fill($inputs);

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
