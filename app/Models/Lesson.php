<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function price(){
        return $this->morphOne(Price::class,'priceable');
    }

    public function course(){
        return $this->belongsTo(Course::class);
    }
}
