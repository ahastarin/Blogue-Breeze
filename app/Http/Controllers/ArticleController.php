<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;


class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('article.index', [
            "articles" => Article::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('article.create', [
            "categories" => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
    {
        // upload image
        $bytes = random_bytes(5);
        $extension = $request->file('image')->getClientOriginalExtension();
        $image = $request->file('image')->storeAs('image', bin2hex($bytes) . "." . $extension, 'public');

        $article = Article::create([
            "title" => $request->title,
            "user_id" => $request->user()->id,
            "category_id" => $request->category,
            "content" => $request->content,
            "image" => $image
        ]);
        
        // create tag
        $tags = explode(",",$request->tags);

        foreach( $tags as $tag){
            if(!Tag::where('name', $tag)->exists()){
                Tag::create([
                    "name" => $tag
                ]);
            }
        }

        // get tag id
        $tagIds = Tag::whereIn("name", $tags)->get()->toArray();

        // attach to pivot table article and tag
        foreach($tagIds as $tagId) {
            $article->tags()->attach($tagId["id"]);
        }          


        return redirect('/dashboard/article');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        return view("article.show", [
            "article" => Article::find($id)
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {        
        return view('article.edit', [
            "categories" => Category::all(),
            "article" => Article::findOrFail($id)
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, $id)
    {
        $image = null;
        if(!$request->hasFile('image')){
            $image = $request->oldImage;
        } else {
            $bytes = random_bytes(5);
            $extension = $request->file('image')->getClientOriginalExtension();
            $image = $request->file('image')->storeAs('image', bin2hex($bytes) . "." . $extension, 'public');
        }
        
        Article::where("id", $id)->update([
            "title" => $request->title,
            "user_id" => $request->user()->id,
            "category_id" => $request->category,
            "content" => $request->content,
            "image" => $image
        ]);   
        

        return redirect('/dashboard/article');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $article = Article::find($id);

        // dd($article->tags[0]["name"]);

        // mengahapus relation ship di pivot table article tags
        $article->tags()->detach();

        // menghapus article
        Article::destroy($id);
        return redirect("/delete-unused-tags");
    }
}
