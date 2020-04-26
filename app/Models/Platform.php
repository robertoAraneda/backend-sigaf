<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{
    protected $guarded = [];

    protected $table = 'platforms';

    public function categories(){
        return $this->hasMany(Category::class);
    }



}
