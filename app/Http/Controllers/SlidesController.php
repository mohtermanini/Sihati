<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Slide;
use Config,Session;

class SlidesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function edit()
    {
        $page_title = 'تعديل الشرائح' . Config::get('page_title_end');
        return view('slides.edit')->with(["slides"=>Slide::orderBy("id")->get(), "page_title"=>$page_title]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request,[
            'id' => "required|int",
            'title' => "required",
            'img' => "image"
        ]);
        if(strlen($request->content) > config('values.slides.max_len') ){
            Session::flash("failed","تم تجاوز الطول الأعظمي لنص الشريحة");
            $request->flash();
            return redirect()->back(); 
        }
        $slide = Slide::findOrfail($request->id);
        if($request->hasFile('img')){
            if(file_exists($slide->img)){
                unlink($slide->img);
            }
            $img_new_name = time().$request->img->getClientOriginalName();
            $request->img->move('files/slides/',$img_new_name);
            $slide->img = 'files/slides/' . $img_new_name;
        }
        //updating
        $slide->update([
            "title" => $request->title,
            "content" => $request->content
        ]);

        Session::flash('success','تم تعديل الشريحة بنجاح');
        $request->flash();
        return redirect()->back();  
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
