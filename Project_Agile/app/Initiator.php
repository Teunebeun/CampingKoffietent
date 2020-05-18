<?php

namespace App;

use App\EncryptAttributes;
use Illuminate\Database\Eloquent\Model;

class Initiator extends Model
{
    use EncryptAttributes;

    public function initiatives() {
        return $this->hasMany('App\Initiative');
    }
    protected $fillable = ['name', 'middlename', 'lastname', 'email', 'phonenumber'];
    protected $encryptable = ['name', 'middlename', 'lastname', 'email', 'phonenumber'];
	protected $table = "initiator";
	public $timestamps = false;

}

?>
