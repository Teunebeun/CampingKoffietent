<?php

namespace App;

use App\EncryptAttributes;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use EncryptAttributes;

    protected $fillable = ['name', 'email', 'message'];
    protected $table = 'messages';
    public $timestamps = false;
    protected $encryptable = ['name', 'email', 'message'];
}
