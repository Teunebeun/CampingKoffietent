<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{

    public function activitiesPlanned()
    {
        return $this->hasMany(ActivityPlanned::class, 'existing_activity_id', 'id');
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'activity';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'creator', 'description', 'picture'];

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
