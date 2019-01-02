<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['parent_id', 'name', 'description', 'url', 'status', 'remember_token'];

    public function categories(){
        return $this->hasMany('App\Category', 'parent_id');
    }
}
