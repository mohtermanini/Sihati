<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Consultation;
use App\Models\Comment;
use App\Models\User;
use App\Models\ConsultationCategory;
use App\Models\ConsultationView;
use Config,Session,Auth;

class ConsultationsController extends Controller
{

    public function __construct(){
        $this->middleware('type:admin-doctor-normal,يجب عليك تسجيل الدخول أولاً',
                ['except' => ['index','show','destroy'] ]);
        $this->middleware('type:admin',['only' => ['destroy'] ]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = ['created_at','views'];
        $orderCol = $orders[request()->query("orderCol",0)]; 
        $orderType = request()->query("orderType",'desc');
        $answered = request()->query("answered",-1);
        $consultationsQuery = Consultation::with("user.profile","comments","consultation_category")
                        ->orderBy($orderCol,$orderType);
        if($answered == 0){
            $consultationsQuery = $consultationsQuery->doesntHave("comments");
        }elseif($answered == 1){
            $consultationsQuery = $consultationsQuery->has("comments");
        }
        $selected_tags = null;
        if(request()->has('tags')){
            $consultationsQuery = $consultationsQuery->whereIn('consultation_category_id',request()->tags);
            $selected_tags = ConsultationCategory::whereIn('id',request()->tags)->get();
        }
        $consultations = $consultationsQuery->paginate(Config::get('pagination_num'));
        $famousWritersNum = 4;
        $famousWriters = User::with("profile.jobs")
                        ->select("users.id","profile_id")->selectRaw('count(*) as "commentsNum"')
                        ->join("comments","users.id","user_id")
                        ->where("type_id",Config::get("type_doctor_id"))
                        ->groupBy("users.id","profile_id")
                        ->orderBy("commentsNum","desc")
                        ->limit($famousWritersNum)
                        ->get();
        
        $tags = ConsultationCategory::all();
        $page_title = "الاستشارات الطبية" . Config::get("page_title_end");
        request()->flash();
        return view('consultations.index')->with(['consultations' => $consultations,
                    'answered' => $answered,
                    'famousWriters' => $famousWriters,
                    'tags' => $tags,
                    'selected_tags' => $selected_tags,
                    'page_title' => $page_title]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $page_title = 'كتابة استشارة طبية' . Config::get('page_title_end');
        $consultation_categories = ConsultationCategory::all();
        return view('consultations.create',[
            'consultation_categories' => $consultation_categories,
            'page_title' => $page_title
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
        $this->validate($request,[
            'title' => 'required',
            'content' => 'required',
            'consultation_category_id' => 'required|int'
        ]);
        $consultation = Consultation::create([
            'title' => $request->title,
            'slug' => GeneralController::make_slug($request->title),
            'content' => $request->content,
            'user_id' => Auth::id(),
            'consultation_category_id' => $request->consultation_category_id
        ]);
        Session::flash("success","تم إرسال الاستشارة بنجاح");
        return redirect()->route('consultations.show',[
            'id'=>$consultation->id,
            'slug'=>$consultation->slug
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id,$slug)
    {
        $consultation = Consultation::with('user.profile')->find($id);
         //Update views
         if(Auth::check()){
            $view = ConsultationView::where('user_id',Auth::id())->where('consultation_id',$id)->first();
            if(!isset($view)){
                ConsultationView::create([
                    'user_id' => Auth::id(),
                    'consultation_id' => $id
                ]);
                $consultation->views++;
                $consultation->save();
            }
        }
        else{
            $ip = GeneralController::getIp();
            $view = ConsultationView::where('ip',$ip)->where('consultation_id',$id)->first();
            if(!isset($view)){
                ConsultationView::create([
                    'ip' => $ip,
                    'consultation_id' => $id
                ]);
                $consultation->views++;
                $consultation->save();
            }
        }
        //Update views

        $comments = Comment::with("user.profile")->where("consultation_id",$id)
                 ->orderBy("best","desc")->orderBy("created_at")
                ->get();
        $best_exists = $comments->count() != 0 && $comments[0]->best? 1: 0;
        $page_title = $consultation->title . Config::get("page_title_end");
        $related_consultations_num = 4;
        $related_consultations = 
                Consultation::where('consultation_category_id',$consultation->consultation_category_id)
                                ->where('id','!=',$consultation->id)
                                ->inRandomOrder()
                                ->limit($related_consultations_num)
                                ->get();
        return view('consultations.show')
                    ->with(["consultation" => $consultation,
                            "comments" => $comments,
                            "best_exists" => $best_exists,
                            "related_consultations"=>$related_consultations,
                            "page_title" => $page_title
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
        $consultation = Consultation::find($id);
        $consultation->comments()->delete();
        $consultation->delete();
        Session::flash("success","تم حذف الاستشارة بنجاح");
        return redirect()->route('consultations.index');
    }
}
