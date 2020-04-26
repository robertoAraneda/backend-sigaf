<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $guarded = [];

    protected $table = 'courses';

    public function category(){
        return $this->belongsTo(Category::class);
    }

    public function activities(){
        return $this->hasMany(Activity::class);
    }
}
