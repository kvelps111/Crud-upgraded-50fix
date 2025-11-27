<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Models\Product;

class TagController extends Controller
{
    public function search(Request $request)
    {
        $q = $request->query('q', '');
        $tags = Tag::where('name', 'like', "%{$q}%")->pluck('name');
        return response()->json($tags);
    }

    public function destroy(Tag $tag)
    {
        $tag->products()->detach();
        $tag->delete();
        return response()->json(['success' => true]);
    }

}
