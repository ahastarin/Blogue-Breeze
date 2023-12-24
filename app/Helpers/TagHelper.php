<?php

namespace App\Helpers;

use App\Http\Requests\UpdateArticleRequest;
use App\Models\Tag;
use App\Models\Article;

class TagHelper{
    public static function handle(UpdateArticleRequest $request, $id) {
        
        $article = Article::Find($id);
        $allTags = $article->tags->all();
        $oldTags = [];
        foreach($allTags as $tag) {
            array_push($oldTags, $tag->name);
        }

        // ubah request dari string ke array   
        $inputTags = explode(",",$request->tags);
        
        // mengambil tags yg baru dan yg dihapus
        $newTags = array_diff($inputTags, $oldTags);     
        $deletedTags = array_diff($oldTags, $inputTags);

        // hapus tag
        foreach($deletedTags as $tag) {
           $tagId = Tag::where("name", $tag)->value("id");

           //delete tag
           Tag::destroy($tagId);
           $article = Article::find($id);
           $article->tags()->detach($tagId);


        } 

       // tambahkan array baru
        foreach($newTags as $tag) {
           // cek apakah tag sudah ada di tabel tag atau belum
           $newCreatedTag = Tag::create([
               "name" => $tag
           ]);

           $article = Article::find($id);
           $article->tags()->attach($newCreatedTag->id);
           // dd($article->tags());
        }        
    }
}