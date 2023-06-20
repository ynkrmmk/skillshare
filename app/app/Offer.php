<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Offer extends Model
{
    protected $fillable = ['email', 'tel', 'content', 'date']; 
    protected $table = 'requests';
}
