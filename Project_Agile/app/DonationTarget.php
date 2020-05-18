<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DonationTarget extends Model
{

    public function donation() {
        return $this->hasMany('App\Donation', 'Donation_Target_id');
    }

    public function activityplanned() {
        return $this->belongsTo('App\ActivityPlanned', 'Activity_Planned_id');
    }

    public static function generic() {
        return DonationTarget::all()->where('Activity_Planned_id', null);
    }

    public static function filter($collection, $searchTerm) {
        $collection = $collection->filter(function($value, $key) use ($searchTerm) {
            if(strpos(strtolower($value->description), strtolower($searchTerm)) !== false || strpos(strtolower($value->title), strtolower($searchTerm)) !== false) {
                return true;
            }

            return false;
        });

        return $collection;
    }

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'donation_target';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['Activity_Planned_id', 'donation_item', 'donation_needed', 'donation_received', 'title', 'description', 'datetime', 'is_completed'];

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
    protected $casts = ['is_completed' => 'boolean'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['datetime'];

    public $timestamps = false;
}
