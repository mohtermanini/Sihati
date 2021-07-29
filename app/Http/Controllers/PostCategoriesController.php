<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PostCategory;

use Config, Session, Validator;

class PostCategoriesController extends Controller
{

    public function __construct(){
        $this->middleware('type:admin',['except'=> ['index'] ] );
    }
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
        $page_title = 'إضافة قسم' . Config::get('page_title_end');
        return view('post_categories.create')->with("page_title",$page_title);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validation
        $validator = Validator::make($request->all(),[
            'name' => "required",
            'img' => "required|image"
        ], [
            "name.required" => "يرجى تعبئة حقل اسم القسم",
            "img.required" => "يرجى تحميل صورة القسم",
            "img.image" => "الملف يجب أن يكون صورة"
        ]);
        if( $validator->fails() ){
            Session::flash("failed",$validator->errors()->first());
            return redirect()->back();
        }
        //Validation
        if(PostCategory::where('name',$request->name)->get()->count() > 0){
            Session::flash("failed","يوجد قسم بهذا الاسم");
            return redirect()->back();
        }
        $img_new_name = time() . $request->img->getClientOriginalName();
        $request->img->move("files/post_categories/",$img_new_name);
        PostCategory::create([
            'name' => $request->name,
            'slug' => GeneralController::make_slug($request->name),
            'img' => 'files/post_categories/' . $img_new_name
        ]);  

        Session::flash("success","تم إنشاء القسم بنجاح");
        return redirect()->route('index');
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
    public function edit($slug)
    {
        $category = PostCategory::where('slug',$slug)->first();
        $page_title = 'تعديل القسم' . Config::get("page_title_end");
        return view('post_categories.edit')->with('category',$category)->with("page_title",$page_title);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
        $validator = Validator::make($request->all(),[
            'name' => "required",
            'img' => "image"
        ], [
            "name.required" => "يرجى تعبئة حقل اسم القسم",
            "img.image" => "الملف يجب أن يكون صورة"
        ]);
        if($validator->fails()){
            Session::flash("failed",$validator->errors()->first());
            return redirect()->back();
        }
        $category = PostCategory::where('slug',$slug)->first();
        if($request->hasFile('img')){
            if(file_exists($category->img)){
                unlink($category->img);
            }
            $img_new_name = time().$request->img->getClientOriginalName();
            $request->img->move('files/post_categories/',$img_new_name);
            $category->img = 'files/post_categories/' . $img_new_name;
        }
        //updating
        $category->update([
            "name" => $request->name,
            'slug' => GeneralController::make_slug($request->name),
        ]);
        Session::flash('success','تم تعديل القسم بنجاح');
        return redirect()->route('postCategories.edit',['postCategory'=>$category->slug]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $postCategory = PostCategory::with('posts')->where("slug",$slug)->first();
        if($postCategory->posts->count() > 0){
            Session::flash("failed","يجب حذف كل المنشورات في هذا القسم أولاً");
            return redirect()->back();    
        }
        $postCategory->delete();
        Session::flash("success","تم حذف القسم بنجاح");
        return redirect()->route('index');
    }
}
