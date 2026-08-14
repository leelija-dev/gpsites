<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\Blogs;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');

    $blogs = Blogs::where('status', true)
        ->with(['admin', 'blogCategory','faq'])
        ->when($search, function ($query, $search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                  ->orWhere('excerpt', 'like', '%' . $search . '%')
                  ->orWhere('slug', 'like', '%' . $search . '%')
                  ->orWhere('tags', 'like', '%' . $search . '%')
                  ->orWhereHas('blogCategory', function ($categoryQuery) use ($search) {
                      $categoryQuery->where('slug', 'like', '%' . $search . '%')
                          ->orWhere('name', 'like', '%' . $search . '%')
                          ->orWhere('description', 'like', '%' . $search . '%');
                  });
            });
        })
        ->orderBy('id', 'DESC')
        ->get();

    $latestBlog = Blogs::where('status', true)
        ->with('blogCategory','faq')
        ->latest()
        ->first();

    $blogCategory = BlogCategory::where('status', true)
        ->get();

    return view(
        'web.blogs.all-blog',
        compact('blogs', 'latestBlog', 'blogCategory')
    );
}
public function singleBlog($slug){
    $blog = Blogs::where('slug', $slug)->with('admin','blogCategory','faq')->first();
    $latestBlogs = Blogs::where('status', true)->with('admin','faq')->latest()->limit(5)->get();
    $categories = BlogCategory::where('status', true)->get();
    return view('web.blogs.single-blog',compact('blog','latestBlogs','categories'));
}
}
