<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class ActivityPlanned extends Model
{
    public function campingbazen()
    {
        return $this->belongsToMany(Campingbaas::class, 'campingbaas_activitiy_planned');
    }

    public function activity()
    {
        return $this->belongsTo(Activity::class, 'existing_activity_id', 'id');
    }

    public function vacancies()
    {
        return $this->hasMany(Vacancy::class);
    }

    public function startDateFormatted()
    {
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->start_datetime)->format('d-m-Y H:i');
    }

    public function endDateFormatted(){
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->end_datetime)->format('d-m-Y H:i');
    }

    public function donationtargets()
    {
        return $this->hasMany('App\DonationTarget');
    }


    public function activityPictures()
    {
        return $this->hasMany(ActivityPicture::class);
    }
    public function pictures()
    {
        return $this->hasMany('App\ActivityPicture');
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'activity_planned';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'description', 'display_picture', 'existing_activity_id', 'start_datetime', 'end_datetime'];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['start_datetime', 'end_datetime'];

    public $timestamps = false;
}
