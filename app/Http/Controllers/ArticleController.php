<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Article_tag;
use App\Models\Tag;
use App\Models\User;
use App\Http\Requests\ArticleRequest;
use Illuminate\Support\Facades\DB;
class ArticleController extends Controller
{
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

        // return view('conduit.article', compact('article', 'tags', 'user'));
        return view('conduit.Unauth_article', compact('article', 'tags', 'user'));
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
    public function exeStore(ArticleRequest $request)
    {
        $inputs = $request->all();
        $tags = explode(',', $inputs['tags']);

        // 認証認可で修正
        $inputs['user_id'] = 4;

        DB::beginTransaction();
        try {
            $article = Article::create($inputs);
            $article->tags()->sync($this->saveTags($tags));
            DB::commit();
        } catch(\Throwable $e) {
            DB::rollback();
            abort(500);
        }

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
        $user = User::where('id', $article->user_id)->first();
        $article_tags = Article_tag::where('article_id', $article->id)->get();
        $tag_ids = $article_tags->pluck('tag_id')->toArray();
        $tags = Tag::whereIn('id', $tag_ids)->get();
        foreach ($tags as $tag) {
            $Tags[] = $tag->name;
        }
        $tags = implode(',', $Tags);

        return view('conduit.editor', compact('article', 'user', 'tags'));
    }

    /**
     * 記事を更新する
     * @param object $request
     * @return view
     */
    public function exeUpdate(ArticleRequest $request)
    {
        $inputs = $request->all();
        $article = Article::find($inputs['id']);

        $article->fill($inputs);
        $tags = explode(',', $inputs['tags']);

        DB::beginTransaction();
        try {
            $article->tags()->sync($this->saveTags($tags));
            $article->save();
            DB::commit();
        } catch(\Throwable $e) {
            DB::rollBack();
            abort(500);
        }

        return redirect(route('articles'));
    }

    /**
     * 記事を削除
     * @param int $id
     * @return view
     */
    public function exeDelete($id)
    {
        $article = Article::findOrFail($id);

        $tags = $article->tags;

        $article->delete();

        // 記事に紐づいていたタグが他の記事に紐づいていない場合は、タグを削除
        foreach ($tags as $tag) {
            if ($tag->articles()->count() === 0) {
                $tag->delete();
            }
        }

        return redirect(route('articles'));
    }
}
