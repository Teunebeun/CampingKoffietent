<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FooterLink extends Model
{
    protected $table = 'footer_link';
    protected $fillable = ['name', 'link'];
    protected $hidden = [];
    protected $casts = [];
    protected $dates = [];
    public $timestamps = false;
}
