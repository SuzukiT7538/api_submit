<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\Tag;
use App\Models\TagArticle;
use Carbon\Carbon;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $currentUser = auth()->user();
        if ($currentUser !== NULL) {
            $article = new Article;
            $form = $request->article;
            $slug = $request->article['title'];
            $description = $request->article['description'];
            $body = $request->article['body'];
            unset($form['tagList']);
            $article->fill($form);
            $article->fill(
                ['slug' => $slug,
                'description' => $description,
                'body' => $body,
                'author' => $currentUser->name,
                ])->save();
            $tagList = $request->article['tagList'];
            foreach ($tagList as $data) {
                    $tag = new TagArticle;
            $tag->fill([
                'articleId' => $article->id,
                'tagId' => $data,
            ]);
            $tag->save();
            }

            return ['article' => [
                'title' => $article->title,
                'slug' => $article->slug,
                'body' => $article->body,
                'createdAt' => new Carbon($article->createdAt),
                'updatedAt' => new Carbon($article->updatedAt),
                'description' =>$article->description,
                'tagList' => $tagList,
                'author' => $article->author,
                'favorited' => 'notemake',
                'favoritesCount' => 999,
            ]];
        } else {
            return ['error' => '認証エラー'];
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showAll()
    {
        $articles = Article::all();
        foreach ($articles as &$article) {
            $article->createdAt = new Carbon($article->createdAt);
            $article->updatedAt = new Carbon($article->updatedAt);
            $tagList = [];
            $tagList[] = TagArticle::where('id', $article->id)->get();
            $article->tagList = $tagList;
            $article->author = '';
            $article->favorited = '';
            $article->favoritesCount = 0;
        }
        unset($article);
        return response()->json([
            'articles' => $articles,
            'articlesCount' => 999,
        ]);
    }

    public function showArticle($slug)
    {
            $article = Article::where('slug', $slug)->first();
            $tags = TagArticle::where('articleId', $article->id)->get();
            $tagList = [];
            foreach ($tags as $tag) {
                $tagList[] = $tag->tagId;
            }
            return response()->json([
                'article' => [
                    'title' => $article->title,
                    'slug' => $article->slug,
                    'body' => $article->body,
                    'createdAt' => new Carbon($article->createdAt),
                    'updatedAt' => new Carbon($article->updatedAt),
                    'description' => $article->description,
                    'tagList' => $tagList,
                    'author' => $article->author,
                    'favorited' => 'testfav',
                    'favoritesCount' => 999,
                ],
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $currentUser = auth()->user();
        if ($currentUser !== NULL) {
            $input = $request->article;
            $article = Article::where('slug', $slug)->first();
            // return $article;
            if (array_key_exists('body', $input)) {
                $article->fill(['body' => $input['body']]);
            }
            if (array_key_exists('title', $input)) {
                $article->fill([
                    'title' => $input['title'],
                    'slug' => $input['title'],
                ]);
            }
            if (array_key_exists('description', $input)) {
                $article->fill(['description' => $input['description']]);
            }
            $article->save();

            return response()->json([
                'article' => $article,
            ]);

        } else {
            return ['error' => '認証エラー'];
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($slug)
    {
        $currentUser = auth()->user();
        if ($currentUser !== NULL) {
            Article::where('slug', $slug)->delete();
        } else {
            return ['error' => '認証エラー'];
        }
    }
}
