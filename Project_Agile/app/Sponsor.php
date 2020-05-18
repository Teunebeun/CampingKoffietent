<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    protected $table = 'sponsor';
    protected $fillable = ['name', 'logo', 'description', 'link'];
    protected $hidden = [];
    protected $casts = [];
    protected $dates = [];
    public $timestamps = false;
}
