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
        $validator = Validator::make($request->all(),[
            'email' => 'required',
            'user_name' => 'required',
            'password' => 'required',
            'type_id' => 'integer|between:2,3',
            'birthday' => 'before_or_equal:'.date("Y-m-d")
        ], [
            "type_id.integer" => "يرجى اختيار نوع الحساب من القائمة",
            "type_id.between" => "يرجى اختيار نوع الحساب من القائمة",
            "email.required" => "البريد الالكتروني مطلوب",
            "user_name.required" => "اسم المستخدم مطلوب",
            "birthday.before_or_equal" => "يرجى اختيار تاريخ قبل تاريخ اليوم الحالي"

        ]);
        if( $validator->fails() ){
            Session::flash("failed",$validator->errors()->first());;
            return redirect()->back()->withInput();
        }
        $failedMsg = $this->duplicatedUserNameOrEmail($request->email,$request->user_name);
        if(isset($failedMsg)){
            Session::flash("failed",$failedMsg);
            $request->flash();
            return redirect()->back();
        }

        $img_name = "default.png";
        if($request->hasFile('img')){ 
            $img = $request->img;
            $img_name = time().$img->getClientOriginalName();
            $img->move('files/profiles/',$img_name);
        }
        $profile = Profile::create([
            'first_name' => $request->fname,
            'last_name' => $request->lname,
            'birthday' => $request->birthday,
            'gender' => $request->gender,
            'avatar' => 'files/profiles/' . $img_name,
            'description' => $request->description
        ]);
        $user = User::create([
            'email' => $request->email,
            'user_name' => $request->user_name,
            'password' => bcrypt($request->password),
            'profile_id' => $profile->id,
            'type_id' => $request->type_id
        ]);
        if($request->type_id == Config::get('type_doctor_id')){
            $set = new Set();
            foreach($request->specialisations as $specialise){
                $set->add($specialise);
            }
            $profile->jobs()->attach($set->toArray());
        }
        Session::flash("success","تم إنشاء المستخدم بنجاح");
        Auth::loginUsingId($user->id,true);
        $request->session()->regenerateToken();
        $previous_entry_url = session()->get('previous_entry_url', route('index'));
        return redirect($previous_entry_url);
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

    public function duplicatedUserNameOrEmail($email, $user_name){
            /* failing Cases */
            $failedMsg = null;
            $another_user = User::where('email',$email)
                                ->where('id','!=',Auth::id())->first();
            if(isset($another_user)){
                $failedMsg = "البريد الالكتروني المُدخل مأخوذ مسبقاً";
            }
            $another_user = User::where('user_name',$user_name)
                                ->where('id','!=',Auth::id())->first();
            if(!isset($failedMsg) && isset($another_user)){
                $failedMsg = "اسم المستخدم المُدخل مأخوذ مسبقاً";   
            }
            return $failedMsg;
            /* failing Cases */
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

    public function login(){
        $page_title = 'تسجيل الدخول' . Config::get('page_title_end');
        return view('users.login')->with("page_title",$page_title);
    }

    public function loginCheck(Request $request){

        $this->validate($request,[
            'emailOrUserName' => 'required',
            'password' => 'required'
        ]);
       
         $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify',[
            'secret' => '6LdndykfAAAAABl5UYLHfPOQg0G7_8dSUor8cOE0',
            'response' => $request['g-recaptcha-response']
        ]);
        if(!json_decode($response)->success){
            Session::flash('recaptcha-error','خطأ في التحقق، الرجاء إعادة المحاولة');
            return redirect()->back();
        }

        $rate_limiter_name = $request->emailOrUserName."|".GeneralController::getIp();
        if( RateLimiter::tooManyAttempts($rate_limiter_name, $maxAttempts = 5) ){
            $time_left = RateLimiter::availableIn($rate_limiter_name);
            $min = floor($time_left/60);
            $sec = $time_left%60;
            $failedMsg = "لقد تجاوزت العدد الأقصى من المحاولات من أجل اسم المستخدم أو البريد الالكتروني المدخل ".
                        "يرجى إعادة المحاولة بعد ". ($min>0?" {$min} دقيقة و":""). "${sec} ثانية";
            Session::flash("failed",$failedMsg);
            Session::flash("emailOrUserName", $request->emailOrUserName);
            return redirect()->back();
        }
        
        $col = "user_name";
        if(filter_var($request->emailOrUserName, FILTER_VALIDATE_EMAIL) ){
            $col = "email";
        }
        $user = User::where($col,$request->emailOrUserName)->first();
        if(!isset($user)|| !password_verify($request->password,$user->password)){
            $failedMsg = "";
            RateLimiter::hit($rate_limiter_name, $decaySeconds = 300);

            if($col == "user_name"){
                $failedMsg .= "اسم المستخدم ";
            }else{
                $failedMsg .= "البريد الالكتروني ";
            }
            $failedMsg .= "أو كلمة السر غير صحيحان";
            Session::flash("failed",$failedMsg);
            Session::flash("emailOrUserName", $request->emailOrUserName);
            return redirect()->back();
        }
        RateLimiter::clear($rate_limiter_name);
        Auth::loginUsingId($user->id,true);
        $request->session()->regenerateToken();
        $previous_entry_url = session()->get('previous_entry_url', route('index'));
        return redirect()->intended($previous_entry_url);
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->back();
    }

    public function signup(){
        $jobs = Job::all();
        $page_title = 'إنشاء حساب' . Config::get('page_title_end');
        return view('users.signup')->with("jobs",$jobs)->with("page_title",$page_title);
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
