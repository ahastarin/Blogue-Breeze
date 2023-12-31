<?php

namespace App\Helpers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Tag;
use App\Models\Article;

trait TagHelper{
    public static function create(StoreArticleRequest $request, $article){

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
    }

    public static function update(UpdateArticleRequest $request, $id) {
        
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
            $article = Article::find($id);

           // cek apakah tag sudah ada di tabel tag atau belum
           // jika tidak ada
           if(!Tag::where("name", $tag)){
                // maka buat tag baru
                $newCreatedTag = Tag::create([
                    "name" => $tag
                ]);
                // attach dengan id tag baru
                $article->tags()->attach($newCreatedTag->id);
           } else {
            // jika tidak ada 
            // attach dengan id tag lama
            $existedTagId = Tag::select("id")->where("name", $tag)->value("id");
            $article->tags()->attach($existedTagId);
           }
       
          
           // dd($article->tags());
        }        
    }
}