<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = ['first_name','last_name','avatar','birthday','gender','description'];

    public function titleFromGender(){
        if($this->gender == -1){
            return null;
        }
        return $this->gender == 0? "الدكتور" : "الدكتورة";
    }

    public function genderString(){
        return $this->gender?"أنثى":"ذكر";
    }

    public function userAge(){
        if($this->birthday === null){
            return null;
        }
        return Carbon::now()->diffInYears(Carbon::parse($this->birthday));
    }

    public function getFullName(){
        return $this->first_name . " " . $this->last_name;
    }

    public function jobs(){
        return $this->belongsToMany("App\Models\Job");
    }

}
