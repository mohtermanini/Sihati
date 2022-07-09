<?php

namespace App\Http\Controllers;

use Ds\Set;
use App\Models\Job;
use App\Models\Post;
use App\Models\User;
use App\Models\Profile;
use App\Models\Consultation;

use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;
use App\Http\Controllers\GeneralController;
use Illuminate\Support\Facades\RateLimiter;
use Config,Session, Auth, stdClass, DB, Validator, Http;

class UsersController extends Controller
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::with("profile")->findOrFail($id);
        if(
            $user->type_id != Config::get("type_doctor_id")
            && $user->type_id != Config::get("type_admin_id")
            ){
            return redirect()->back();
        }
        $page_title = $user->profile->getFullName() . Config::get('page_title_end');
        return view("users.show")->with([
            'user' => $user,
            'page_title' => $page_title
        ]);
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
    public function update(Request $request)
    {        
        $this->validate($request,[
            'email' => 'required',
            'user_name' => 'required',
            'gender' => 'required|int'
        ]);
        /* failing Cases */
        $failedMsg = $this->duplicatedUserNameOrEmail($request->email,$request->user_name);
        if(isset($failedMsg)){
            Session::flash("failed",$failedMsg);
        }
        /* failing Cases */
        /* updating */
        else{
            $user = User::find(Auth::id());
            if($user->type_id == Config::get("type_normal_id")){
                $request->description = null;
            }
            $user->update([
                'email' => $request->email,
                'user_name' => $request->user_name
            ]);
            $user->profile->update([
                'first_name' => $request->fname,
                'last_name' => $request->lname,
                'birthday' => $request->birthday,
                'gender' => $request->gender,
                'description' => $request->description,
                'email_visible' => $request->filled('email_visible')? 1:0,
                'birthday_visible' => $request->filled('birthday_visible')? 1:0
            ]);
            Session::flash("success","تم تعديل الملف الشخصي بنجاح");
        }
        Session::flash("updateRequest", true);
        /* updating */
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

    public function profilePage(){
        if(!Auth::check()){
            Session::flash("failed","يجب تسجيل الدخول أولاً");
            return redirect()->back();
        }
        $user = User::with("profile.jobs")->find(Auth::id());
        $consultations = Consultation::with("comments","user.profile")
                        ->where('user_id',Auth::id())
                        ->paginate(Config::get("pagination_num"), ["*"], "consultations_page")
                        ->withQueryString()
                        ->appends(['tab' => 2]);

        $posts = Post::select("posts.*")->join('post_user','post_id','=','posts.id')->
                        where('user_id',$user->id)
                        ->orderBy("created_at","desc")
                        ->paginate(Config::get("pagination_num"), ["*"], "posts_page")
                        ->withQueryString()
                        ->appends(['tab' => 3]);

        $firstTabUpdate = Session::get("updateRequest", false);
        if ($firstTabUpdate) {
            $tab = 1;
        } else {
            $tab = request()->query('tab',1);
        }
        $page_title = "الصفحة الشخصية" . Config::get("page_title_end");
        return view("users.profile")->with(["user"=>$user,
                            "consultations" => $consultations,
                            "posts"=>$posts,
                            "tab" => $tab,
                            "page_title"=>$page_title]);
    }
    
    public function doctorsSearch(){
        $num_per_page = 10;
        $name = request()->query('name');
        $page =request()->query('page');
        $offset = $num_per_page * ($page - 1);
        $count = DB::select("select count(*) as cnt from profiles join users on profile_id = profiles.id
        where CONCAT(first_name,' ',COALESCE(last_name,'')) like '%$name%'
        and users.type_id = :type",[
            'type' => Config::get("type_doctor_id")
        ])[0]->{'cnt'};
        $results = DB::select("
        select users.id, CONCAT(first_name,' ',COALESCE(last_name,'')) as text 
        from profiles join users on profile_id = profiles.id 
        where CONCAT(first_name,' ',COALESCE(last_name,'')) like '%$name%'
        and users.id != :id
        and users.type_id = :type limit $num_per_page offset $offset
        ",[
            'type' => Config::get("type_doctor_id"),
            'id' => Auth::id()
        ]);
        $more = $page * $num_per_page < $count;
        $ret = new stdClass();
        $ret->results = $results;
        $pagination = new stdClass();
        $pagination->more = $more;
        $ret->pagination = $pagination;
        return json_encode($ret);
    }
}
