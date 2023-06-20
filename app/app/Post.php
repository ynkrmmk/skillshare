<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = ['image', 'title', 'content', 'price']; 

    public function user() {
      return $this->belongsTo('App\User', 'user_id', 'id');
    }

    public function violation() {
      return $this->belongsTo('App\Violation', 'id', 'post_id');
    }

    public function request() {
      return $this->belongsToMany('App\Request', 'id', 'post_id');
    }
}
