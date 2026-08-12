<?php

namespace App\Http\Controllers;

use App\Models\Blogs;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request) {
        $blogs= Blogs::where('status',true)->get();
        $latestBlog = Blogs::where('status',true)->latest()->first();
        return view('web.blogs.all-blog',compact('blogs','latestBlog'));
    }
}
