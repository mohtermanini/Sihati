<?php

namespace App\Http\Controllers\Auth;

use Ds\Set;
use App\Models\Job;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller {

    public function create() {
        $jobs = Job::all();
        $page_title = 'إنشاء حساب' . Config::get('page_title_end');
        return view('users.signup')->with("jobs", $jobs)->with("page_title", $page_title);
    }

    public function duplicatedUserNameOrEmail($email, $user_name) {
        /* failing Cases */
        $failedMsg = null;
        $another_user = User::where('email', $email)
            ->where('id', '!=', Auth::id())->first();
        if (isset($another_user)) {
            $failedMsg = "البريد الالكتروني المُدخل مأخوذ مسبقاً";
        }
        $another_user = User::where('user_name', $user_name)
            ->where('id', '!=', Auth::id())->first();
        if (!isset($failedMsg) && isset($another_user)) {
            $failedMsg = "اسم المستخدم المُدخل مأخوذ مسبقاً";
        }
        return $failedMsg;
        /* failing Cases */
    }

    public function store(Request $request) {
        $validator = Validator::make($request->all(), [
            'email' => 'required',
            'user_name' => 'required',
            'password' => 'required',
            'type_id' => 'integer|between:2,3',
            'birthday' => 'before_or_equal:' . date("Y-m-d")
        ], [
            "type_id.integer" => "يرجى اختيار نوع الحساب من القائمة",
            "type_id.between" => "يرجى اختيار نوع الحساب من القائمة",
            "email.required" => "البريد الالكتروني مطلوب",
            "user_name.required" => "اسم المستخدم مطلوب",
            "birthday.before_or_equal" => "يرجى اختيار تاريخ قبل تاريخ اليوم الحالي"

        ]);
        if ($validator->fails()) {
            Session::flash("failed", $validator->errors()->first());;
            return redirect()->back()->withInput();
        }
        $failedMsg = $this->duplicatedUserNameOrEmail($request->email, $request->user_name);
        if (isset($failedMsg)) {
            Session::flash("failed", $failedMsg);
            $request->flash();
            return redirect()->back();
        }

        $img_name = "default.png";
        if ($request->hasFile('img')) {
            $img = $request->img;
            $img_name = time() . $img->getClientOriginalName();
            $img->move('files/profiles/', $img_name);
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
        if ($request->type_id == Config::get('type_doctor_id')) {
            $set = new Set();
            foreach ($request->specialisations as $specialise) {
                $set->add($specialise);
            }
            $profile->jobs()->attach($set->toArray());
        }
        Session::flash("success", "تم إنشاء المستخدم بنجاح");
        Auth::loginUsingId($user->id, true);
        $request->session()->regenerateToken();
        $previous_entry_url = session()->get('previous_entry_url', route('index'));
        return redirect($previous_entry_url);
    }
}
