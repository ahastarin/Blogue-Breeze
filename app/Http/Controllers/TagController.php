<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Http\Requests\StoreTagRequest;
use App\Http\Requests\UpdateTagRequest;

class TagController extends Controller
{
    public function deleteUnusedTags()
    {
        // Get tags that are not associated with any post
        $unusedTags = Tag::doesntHave('articles')->get();

        // Delete the unused tags
        foreach ($unusedTags as $unusedTag) {
            $unusedTag->delete();
        }

        return redirect('/dashboard/article');
    }
}
