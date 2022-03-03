<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\User;
use App\Models\PostCategory;
use App\Models\PostUser;
use App\Models\PostTag;
use App\Models\Tag;
use App\Models\PostView;
use Config,Session,DB,Auth, Validator;

class PostsController extends Controller
{
    public function __construct(){
        $this->middleware('type:admin-doctor',['except'=>['index','show'] ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($slug = null)
    {
        
        $orders = ['created_at','views'];
        $orderCol = 'posts.' . $orders[request()->query("orderCol",0)]; 
        $orderType = request()->query("orderType",'desc');
        $postCategory = null;
        if(isset($slug)){
            $postCategory = PostCategory::where('slug',$slug)->firstOrFail();
        }
        $postsQuery = Post::with('post_category','users.profile.jobs')
                    ->whereRaw('post_category_id'. (isset($slug)?' = '.$postCategory->id:' is not null'))
                    ->orderBy($orderCol,$orderType);
        $selected_tags = null;
        if(request()->has('tags')){
            $postsQuery = $postsQuery->whereIn("id",function($query){
                $query->select("post_id")->from("post_tag")->whereIn("tag_id",request()->tags);
            });
            $selected_tags = Tag::whereIn("id",request()->tags)->get();
        }
        $posts = $postsQuery->get();
        $posts = GeneralController::paginate($posts,Config::get("pagination_num"));

        $famousWritersNum = 4;
        $famousWriters = $this->getFamousWriters(
            $famousWritersNum, ( $postCategory != null ?  $postCategory->id : -1)
        );
        
        $tags = Tag::all();
        request()->flash();
        $page_header = isset($slug)? $postCategory->name : "كافة الأقسام";
        $page_title = $page_header . Config::get("page_title_end");
        return view('posts.index')->with(["posts" => $posts, "page_header"=>  $page_header,
                "postCategory" => $postCategory,
                "famousWriters" => $famousWriters,
                "tags" => $tags,
                "selected_tags" => $selected_tags,
                "page_title" => $page_title]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = 'كتابة مقالة' . Config::get("page_title_end");
        $postCategories = PostCategory::all();
        $user = User::with("profile")->find(Auth::id());
        $tags = Tag::all();
        return view('posts.create')->with([
                        "postCategories"=>$postCategories, 
                        "user" => $user,
                        "tags" => $tags,
                        "page_title" => $page_title
                        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'title' => "required",
            'post_category_id' => "required|int"
        ], [
            "title.required" => "يرجى تعبئة حقل عنوان المقالة",
            "post_category_id.required" => "يرجى اختيار فئة من القائمة",
            "post_category_id.int" => "يرجى اختيار فئة من القائمة",
        ]);
        if( $validator->fails() ){
            Session::flash("failed",$validator->errors()->first());
            $request->flash();
            return redirect()->back();
        }

        $img_name = 'default.png';
        if($request->hasFile('img')){
            $img_name = time().$request->img->getClientOriginalName();
            $request->img->move('files/posts/',$img_name);
        }
        
        $post = Post::create([
            'title' => $request->title,
            'slug' => GeneralController::make_slug($request->title),
            'content' => $this->replacePostContent($request->content),
            'img' => 'files/posts/' . $img_name,
            'post_category_id' => $request->post_category_id
        ]);
        //Add writers
        if(isset($request->writers)){
            $writers = $request->writers;
        }
        if(!isset($writers)){
            $writers = [strval(Auth::id())];
        }
        else{
            array_push($writers,strval(Auth::id()));
        }
        $post->users()->attach(array_unique($writers));
        //Add writers
        if(isset($request->tags)){
            $post->tags()->attach(array_unique($request->tags));
        }
        Session::flash("success","تم إنشاء المقالة بنجاح");
        return redirect()->route('posts.show',["id"=>$post->id, "slug"=>$post->slug]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,$slug)
    {
        $post = Post::with('users.profile.jobs','post_category','tags')->findOrFail($id);
        //Update views
        if(Auth::check()){
            $view = PostView::where('user_id',Auth::id())->where('post_id',$id)->first();
            if(!isset($view)){
                PostView::create([
                    'user_id' => Auth::id(),
                    'post_id' => $id
                ]);
                $post->views++;
                $post->save();
            }
        }
        else{
            $ip = GeneralController::getIp();
            $view = PostView::where('ip',$ip)->where('post_id',$id)->first();
            if(!isset($view)){
                PostView::create([
                    'ip' => $ip,
                    'post_id' => $id
                ]);
                $post->views++;
                $post->save();
            }
        }
        //Update views
        $page_title = $post->title . Config::get('page_title_end');
        $post_tags = [];
        foreach($post->tags as $tag){
            $post_tags[] = $tag->id;
        }
        $related_posts_num = 4;
        $related_posts = Post::whereIn('id',function($query) use ($post_tags){
                                    $query->select('post_id')->from('post_tag')
                                        ->whereIn('tag_id',$post_tags);
                                })->where('id','!=',$post->id)
                                    ->inRandomOrder()
                                    ->limit($related_posts_num)
                                    ->get();
        return view('posts.show')->with(
                                    ["post"=>$post,
                                    "related_posts"=>$related_posts,
                                    "page_title"=>$page_title]
                                    );
    }

  
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id,$slug)
    {
        $post = Post::with("users.profile")->findOrFail($id);
        $postCategories = PostCategory::all();
        $page_title = "تعديل المقالة" . Config::get("page_title_end");
        return view('posts.edit')->with(["post"=>$post,"postCategories"=>$postCategories, 
                            "page_title"=>$page_title]);
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
        $this->validate($request,[
            'title' => 'required',
            'post_category_id' => 'required|int'
        ]);
        $post = Post::find($id);
        if($request->hasFile('img')){
            if(Post::where('img',$post->img)->get()->count() == 1){
                unlink($post->img);
            }
            $img_new_name = time().$request->img->getClientOriginalName();
            $request->img->move('files/posts/',$img_new_name);
            $post->img = 'files/posts/'.$img_new_name;
        }
        $post->update([
            'title' => $request->title,
            'slug' => GeneralController::make_slug($request->title),
            'content' => $this->replacePostContent($request->content),
            'post_category_id' => $request->post_category_id
        ]);
        Session::flash("success","تم تعديل المقالة بنجاح");
        return redirect()->route('posts.show',["id"=>$post->id, "slug"=>$post->slug]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::with("post_category")->find($id);
        $post->users()->detach();
        $post->tags()->detach();
        $post->delete();
        Session::flash("success","تم حذف المقالة بنجاح");
        return redirect()->route('posts.index',['slug'=>$post->post_category->slug]);
    }

    public function getFamousWriters($famousWritersNum, $post_category_id){
        $famousWriters = PostUser::with('user.profile.jobs')
                    ->join('posts','post_id','=','posts.id')
                    ->select('user_id', DB::raw("count(*) as num_posts"))
                    ->whereRaw(
                        'post_category_id'
                        . ($post_category_id !== -1?' = '.$post_category_id:' is not null'))
                    ->groupby('user_id')
                    ->orderBy('num_posts','desc')
                    ->limit($famousWritersNum)
                    ->get();
        $arr = array();
        foreach($famousWriters as $famousWriter){
            if($famousWriter->user->type_id === Config::get('type_doctor_id'))
                $arr[] = $famousWriter->user;
        }
        return collect($arr);
    }

    public function replacePostContent($content){
        $new_content = "";
        for($i=0;$i<strlen($content);$i++){
            switch($content[$i]){
                case "'":
                    $new_content .= "&apos;";
                break;
                default:
                $new_content .= $content[$i];
            }
        }
        return $new_content;
    }
}
