<?php

namespace App;

use App\EncryptAttributes;
use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    use EncryptAttributes;

    protected $with = ['donationtarget'];

    public function donationtarget() {
        return $this->belongsTo('App\DonationTarget', 'Donation_Target_id');
    }
    public $timestamps = false;

    public static function allGenericDonations() {
        return Donation::all()->where('donationtarget.Activity_Planned_id', '=', null);
    }

    public function fullName() {
        return ($this->donator_name !== null) ? $this->donator_name.' '.$this->donator_middlename.' '.$this->donator_lastname : 'Anoniem';
    }

    public static function filter($collection, $searchTerm) {
        $collection = $collection->filter(function($value, $key) use ($searchTerm) {
            if(strpos(strtolower($value->description), strtolower($searchTerm)) !== false || strpos(strtolower($value->fullName()), strtolower($searchTerm)) !== false || strpos(strtolower($value->donationtarget->title), strtolower($searchTerm)) !== false) {
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
    protected $table = 'donation';

    /**
     * Attributes that should be mass-assignable.
     *
     * @var array
     */
    protected $fillable = ['Donation_Target_id', 'donator_name', 'donator_middlename', 'donator_lastname', 'description', 'donation_amount', 'donator_email', 'donator_phonenumber', 'datetime', 'is_received'];
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
    protected $casts = ['is_received' => 'boolean'];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['datetime'];

    protected $encryptable = ['donator_name', 'donator_middlename', 'donator_lastname', 'description', 'donator_email', 'donator_phonenumber'];
}
