<?php

namespace App;

use App\EncryptAttributes;
use Illuminate\Database\Eloquent\Model;

class Campingbaas extends Model
{
    use EncryptAttributes;

    protected $table = 'campingbaas';
    protected $fillable = ['firstname', 'middlename', 'lastname', 'picture_small', 'picture_big', 'description', 'personal_color', 'personal_font', 'personal_font_size', 'is_oppercampingbaas', 'email', 'phonenumber'];
    protected $encryptable = ['firstname', 'middlename', 'lastname', 'email', 'phonenumber', 'picture_small', 'picture_big', 'description'];
    protected $hidden = [];
    protected $casts = ['is_oppercampingbaas' => 'boolean'];
    protected $dates = [];
    public $timestamps = false;

    public function planned_activities()
    {
        return $this->belongsToMany(ActivityPlanned::class, 'campingbaas_activitiy_planned');
    }
}
