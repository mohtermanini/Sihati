<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\GeneralController;
use Illuminate\Support\Facades\RateLimiter;

class LoginController extends Controller {
    public function login() {
        $page_title = 'تسجيل الدخول' . Config::get('page_title_end');
        return view('users.login')->with("page_title", $page_title);
    }
    public function loginCheck(Request $request) {

        $this->validate($request, [
            'emailOrUserName' => 'required',
            'password' => 'required'
        ]);

        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => '6LdndykfAAAAABl5UYLHfPOQg0G7_8dSUor8cOE0',
            'response' => $request['g-recaptcha-response']
        ]);
        if (!json_decode($response)->success) {
            Session::flash('recaptcha-error', 'خطأ في التحقق، الرجاء إعادة المحاولة');
            return redirect()->back();
        }

        $rate_limiter_name = $request->emailOrUserName . "|" . GeneralController::getIp();
        if (RateLimiter::tooManyAttempts($rate_limiter_name, $maxAttempts = 5)) {
            $time_left = RateLimiter::availableIn($rate_limiter_name);
            $min = floor($time_left / 60);
            $sec = $time_left % 60;
            $failedMsg = "لقد تجاوزت العدد الأقصى من المحاولات من أجل اسم المستخدم أو البريد الالكتروني المدخل " .
                "يرجى إعادة المحاولة بعد " . ($min > 0 ? " {$min} دقيقة و" : "") . "${sec} ثانية";
            Session::flash("failed", $failedMsg);
            Session::flash("emailOrUserName", $request->emailOrUserName);
            return redirect()->back();
        }

        $col = "user_name";
        if (filter_var($request->emailOrUserName, FILTER_VALIDATE_EMAIL)) {
            $col = "email";
        }
        $user = User::where($col, $request->emailOrUserName)->first();
        if (!isset($user) || !password_verify($request->password, $user->password)) {
            $failedMsg = "";
            RateLimiter::hit($rate_limiter_name, $decaySeconds = 300);

            if ($col == "user_name") {
                $failedMsg .= "اسم المستخدم ";
            } else {
                $failedMsg .= "البريد الالكتروني ";
            }
            $failedMsg .= "أو كلمة السر غير صحيحان";
            Session::flash("failed", $failedMsg);
            Session::flash("emailOrUserName", $request->emailOrUserName);
            return redirect()->back();
        }
        RateLimiter::clear($rate_limiter_name);
        Auth::loginUsingId($user->id, true);
        $request->session()->regenerateToken();
        $previous_entry_url = session()->get('previous_entry_url', route('index'));
        return redirect()->intended($previous_entry_url);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->back();
    }
}
