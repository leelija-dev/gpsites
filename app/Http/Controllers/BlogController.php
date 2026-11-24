<?php

namespace App\Http\Controllers;

use App\Models\BlogCategory;
use App\Models\Blogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
class BlogController extends Controller
{
    public function index(Request $request)
{
    $search = $request->input('search');

    $blogs = Blogs::published()
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
        ->orderByDesc('published_at')->orderBy('id', 'DESC')
        ->get();

    $latestBlog = Blogs::published()
        ->with('blogCategory','faq')
        ->latest('published_at')
        ->first();

    $blogCategory = BlogCategory::where('status', true)
        ->get();

    return view('web.blogs.all-blog-new',
        compact('blogs', 'latestBlog', 'blogCategory')
    );
}
public function singleBlog($slug){
    // Unknown slugs return a real 404 instead of a server error.
    // Drafts and scheduled posts are hidden from visitors; a logged-in admin can still preview them.
    $blog = Blogs::where('slug', $slug)
        ->when(! auth('admin')->check(), fn ($q) => $q->published())
        ->with('admin','blogCategory','faq')
        ->firstOrFail();
    $latestBlogs = Blogs::published()->with('admin','faq')->latest('published_at')->limit(5)->get();
    $categories = BlogCategory::where('status', true)->get();
    return view('web.blogs.single-blog',compact('blog','latestBlogs','categories'));
}

public function category($slug){
    // Unknown categories return a 404 (previously an empty 200 page).
    $category = BlogCategory::where('slug', $slug)->firstOrFail();
    try{
    $blogs = Blogs::where('category', $category->id)->published()->with('admin','blogCategory','faq')->orderByDesc('published_at')->orderBy('id', 'DESC')->get();
     $latestBlog = Blogs::published()
        ->with('blogCategory','faq')
        ->latest('published_at')
        ->first();

    $blogCategory = BlogCategory::where('status', true)
        ->get();
    return view(
        'web.blogs.all-blog',
        compact('category','blogs', 'latestBlog', 'blogCategory')
    );
    }catch(\Exception $e){       
        Log::info($e->getMessage());
    }
}
public function Tag($tag)
{
    
    try {

        $tag = urldecode($tag);
        $blogs = Blogs::where('tags', 'like', '%' . $tag . '%')->published()->with('admin','blogCategory','faq')->orderByDesc('published_at')->orderBy('id', 'DESC')->get();

        $latestBlog = Blogs::published()
            ->with('blogCategory', 'faq')
            ->latest('published_at')
            ->first();

        $blogCategory = BlogCategory::where('status', true)
            ->get();
       
        
        return view(
            'web.blogs.all-blog',
            compact(
                'blogs',
                'latestBlog',
                'blogCategory'
            )
        );

    } catch (\Exception $e) {

        Log::error('Blog Tag Error: ' . $e->getMessage());

        abort(404);
    }
}
}
