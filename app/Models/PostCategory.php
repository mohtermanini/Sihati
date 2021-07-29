<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCategory extends Model
{
    use HasFactory;
    protected $fillable = ['name','slug','img'];

    public function posts(){
        return $this->hasMany('App\Models\Post');
    }
}
