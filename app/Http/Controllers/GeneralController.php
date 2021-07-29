<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Pagination\Paginator;
use Illuminate\Pagination\LengthAwarePaginator;

use DB,Auth, stdClass,Config;
use App\Models\Profile;
class GeneralController extends Controller
{

    public function test(){
        return \App\Models\Slide::all();
    }

    public static function make_slug($string = null, $separator = "-") {
        if (is_null($string)) {
            return "";
        }
        $string = trim($string);
        $string = mb_strtolower($string, "UTF-8");;
        $string = preg_replace("/[^a-z0-9_\s\-ءاأإآؤئبتثجحخدذرزسشصضطظعغفقكلمنهويةى]/u", "", $string);
        $string = preg_replace("/[\s-]+/", " ", $string);
        $string = preg_replace("/[\s_]/", $separator, $string);
        return $string;
    }

    public static function toArabicDate($date){
      if(!isset($date)){
          return '';
      }
        $months_ar = [
            'كانون الثاني', 'شباط', 'آذار', 'نيسان', 'أيار', 'حزيران', 'تموز', 'آب', 'أيلول', 'تشرين الأول',
             'تشرين الثاني', 'كانون الأول'
        ];
        return $date->day . " ". $months_ar[$date->month - 1] . " " . $date->year;
    }
    public static function paginate($items, $perPage, $pageName = 'page')
    {
        $page = LengthAwarePaginator::resolveCurrentPage($pageName);
        //path
        $path = request()->url();
        if(count(request()->query()) > 0 ){
            $path .= "?";
            $i = 0;
            foreach(request()->query() as $key=>$val){
                if($key !== 'page'){
                    if(is_array($val)){
                        foreach($val as $key2=>$val2){
                            $path .= ($i++>0?"&":"") . $key2 . "=" . $val2;
                        }
                    }
                    else{
                        $path .= ($i++>0?"&":"") . $key . "=" . $val;
                    }
                }
            }
        }
        
        return new LengthAwarePaginator(
            $items->forPage($page, $perPage),
            $items->count(),
            $perPage,
            $page,
            [
                'path' =>  $path,
                'pageName' => $pageName,
            ]
        );
    }

    public static function checkIfPostWriter($post){
        $id = Auth::id();
        foreach($post->users as $user){
            if($user->id == $id){
                return true;
            }
        }
        return false;
    }

    public static function getIp(){
        foreach (array('HTTP_CLIENT_IP', 'HTTP_X_FORWARDED_FOR', 'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED', 'REMOTE_ADDR') as $key){
            if (array_key_exists($key, $_SERVER) === true){
                foreach (explode(',', $_SERVER[$key]) as $ip){
                    $ip = trim($ip); // just to be safe
                    if (filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) !== false){
                        return $ip;
                    }
                }
            }
        }
        return request()->ip(); // it will return server ip when no client ip found
    }

}
