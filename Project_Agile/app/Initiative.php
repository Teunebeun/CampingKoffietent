<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Initiative extends Model{

    public function initiator() {
        return $this->belongsTo('App\Initiator', 'Initiator_id');
    }

	protected $table = "initiative";
	public $timestamps = false;
	protected $fillable = ['initiator_id', 'title', 'description', 'datetime', 'seen'];
	protected $with = ['initiator'];
}

?>
