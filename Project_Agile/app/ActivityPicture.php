<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ActivityPicture extends Model
{

    public function activityPlanned()
    {
        return $this->belongsTo(ActivityPlanned::class, 'Activity_Planned_id');
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'activity_picture';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['Activity_Planned_id', 'picture'];

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
    protected $dates = [];

    public $timestamps = false;
}
