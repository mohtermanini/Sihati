<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConsultationView extends Model
{
    use HasFactory;
    protected $fillable = ['ip','user_id','consultation_id'];
}
