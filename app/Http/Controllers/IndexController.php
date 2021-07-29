<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slide;
use App\Models\Post;
use App\Models\Consultation;
use App\Models\PostCategory;
use Config;

class IndexController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $slidesNum = 5;
        $slides = Slide::limit($slidesNum)->orderBy("id")->get();
        $postCategories = PostCategory::all();
        $most_viewed_posts_num = 7;
        $most_viewed_posts = Post::with('post_category')->orderBy("views","desc")
                    ->limit($most_viewed_posts_num)->get();
        $consultations_num = 3;
        $consultations = Consultation::with("consultation_category",
                    "comments.user.profile","user.profile")->
                    has("comments")
                    ->limit($consultations_num)->get();
        
        $page_title = 'الصفحة الرئيسية' . Config::get('page_title_end');
        return view('index')->with(['page_title'=>$page_title, 
                                    'slides'=>$slides,
                                    'postCategories' => $postCategories,
                                    'most_viewed_posts' => $most_viewed_posts,
                                    'consultations' => $consultations]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
}
