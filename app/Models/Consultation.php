<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Config,Auth;
class Consultation extends Model
{
    use HasFactory;
    protected $fillable = ['title','slug','content','user_id','consultation_category_id'];

    public function comments(){
        return $this->hasMany('App\Models\Comment');
    }
    public function consultation_category(){
        return $this->belongsTo("App\Models\ConsultationCategory");
    }
    public function user(){
        return $this->belongsTo("App\Models\User");
    }
  

    public function personalInfo(){
        $profile = $this->user->profile;
        $age = $profile->userAge();
        $str = $profile->genderString();
        if($age !== null){
            $str .= " | $age سنة";
        }
        return $str;
    }
    public function commentWriterName(){
        $user = Auth::user();
        $name = null;
        if ($user->type_id  == Config::get('type_doctor_id')) {
            $name = $user->profile->first_name . " " . $user->profile->last_name;
        } elseif($user->id ==  $this->user_id) {
            $name =  $user->user_name;
        } elseif ($user->type_id == Config::get("type_admin_id")) {
            $name = $user->profile->first_name;
        }
        return $name;
    }
}
