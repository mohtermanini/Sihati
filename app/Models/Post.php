<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $fillable = ['title','slug','content','views','likes','img','post_category_id'];

    public function post_category(){
        return $this->belongsTo("App\Models\PostCategory","post_category_id");
    }
    public function users(){
        return $this->belongsToMany("App\Models\User");
    }
    public function tags(){
        return $this->belongsToMany("App\Models\Tag");
    }
}
