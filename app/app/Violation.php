<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Violation extends Model
{
    protected $fillable = ['content']; 

    public function post() {
      return $this->belongsTo('App\Post', 'post_id', 'id');
  }
}
