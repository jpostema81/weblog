<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\BlogPost;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;

class BlogPostsController extends Controller
{
    /**
     * Register Auth middleware for this controller
     */
    public function __contruct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userId = Auth::user()->id;
        $blogPosts = BlogPost::orderBy('created_ad', 'desc')->where('author_id', $userId)->get();

        return view('admin.blog_posts.index', ['posts' => $blogPosts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $blogpost = new BlogPost();
        return view('admin.blog_posts.form', compact('blogpost'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        // validate user input
        $validatedData = $request->validate($this->rules());

        // create new blogpost and store it
        $userId = Auth::user()->id;

        $blogPost = new BlogPost();
        $blogPost->title = Input::get('title');
        $blogPost->content = Input::get('content');
        $blogPost->author_id = $userId;
        $blogPost->save();

        return redirect()->route('admin.blogposts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(BlogPost $blogpost)
    {
        return view('admin.blog_posts.form', compact('blogpost'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Blogpost $blogpost)
    {
        // validate user input
        $validatedData = $request->validate($this->rules());

        // update blogpost with new data
        $userId = Auth::user()->id;

        $blogpost->title = Input::get('title');
        $blogpost->content = Input::get('content');
        $blogpost->author_id = $userId;
        $blogpost->save();

        return redirect()->route('admin.blogposts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Validate form user input
     */
    public function rules() {
        return [
            'title' => 'required|unique:blog_posts|max:255',
            'content' => 'required',
        ];
    }
}
