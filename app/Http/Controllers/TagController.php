<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Tag;

class TagController extends Controller
{
    public function show()
    {
        return view('products.tags');
    }
}
