<?php

namespace App;

use App\EncryptAttributes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Application extends Model
{
    use EncryptAttributes;

    protected $table = 'application';
    protected $fillable = ['vacancy_id', 'firstname', 'middlename', 'lastname', 'email', 'phonenumber', 'application_letter', 'datetime', 'seen', 'is_accepted'];
    protected $encryptable = ['firstname', 'middlename', 'lastname', 'email', 'phonenumber', 'application_letter'];
    protected $with = ['vacancy'];
    protected $hidden = [];
    protected $casts = ['seen' => 'boolean'];
    protected $dates = ['datetime'];
    public $timestamps = false;

    public function vacancy()
    {
        return $this->belongsTo(Vacancy::class, 'vacancy_id');
    }

    public function dateFormatted()
    {
        if ($this->datetime == null) {
            return '-';
        }
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->datetime)->format('d-m-Y');
    }

    public static function filter($collection, $searchTerm) {
        $collection = $collection->filter(function($value, $key) use ($searchTerm) {
            if(strpos(strtolower($value->fullName()), strtolower($searchTerm)) !== false || strpos(strtolower($value->vacancy->title), strtolower($searchTerm)) !== false || strpos(strtolower($value->application_letter), strtolower($searchTerm)) !== false) {
                return true;
            }

            return false;
        });

        return $collection;
    }

    public function fullName() {
        return $this->firstname . ' ' . $this->middlename . ' ' . $this->lastname;
    }
}
