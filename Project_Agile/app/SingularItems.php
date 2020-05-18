<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SingularItems extends Model
{



    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'singular_items';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['homepage_logo', 'homepage_title', 'homepage_text', 'homepage_picture', 'opentime_monday', 'opentime_tuesday', 'opentime_wednesday', 'opentime_thursday', 'opentime_friday', 'opentime_saturday', 'opentime_sunday', 'coffee_title', 'coffee_picture', 'coffee_text', 'coffee_button',
        'activity_title', 'activity_picture', 'activity_text', 'activity_button',
        'help_title', 'help_picture', 'help_text', 'help_button',
        'donate_title', 'donate_picture', 'donate_text', 'donate_button', 'instagram_api_key',
        'facebook_link', 'instagram_link', 'twitter_link', 'email_link',
        'adres_street', 'adres_place', 'location_link', 'contactpage_text'];

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
