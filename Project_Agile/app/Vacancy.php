<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Vacancy extends Model
{
    protected $table = 'Vacancy';
    protected $fillable = ['title', 'description', 'start_datetime', 'end_datetime', 'picture', 'vacancy_filled', 'activity_planned_id', 'people_amount_required', 'is_deleted', 'is_open'];
    protected $hidden = [];
    protected $casts = ['vacancy_filled' => 'boolean', 'is_deleted' => 'boolean'];
    protected $dates = ['start_datetime', 'end_datetime'];
    public $timestamps = false;


    public function startDateFormatted()
    {
        if ($this->start_datetime == null) {
            return null;
        }
        return Carbon::createFromFormat('Y-m-d H:i:s', $this->start_datetime)->format('d-m-Y');
    }

    public function applicationAmount()
    {
        return count($this->applications);
    }

    public function openApplicationAmount()
    {
        return count($this->applications()->where('is_accepted', '=', '0')->get());
    }

    public function applications()
    {
        return $this->hasMany(Application::class);
    }

    public function activity()
    {
        return $this->belongsTo(ActivityPlanned::class, 'activity_planned_id', 'id');
    }

    public function getAcceptedPeopleAmount()
    {
        return Application::where('vacancy_id', '=', $this->id)->where('is_accepted', '=', 1)->count();
    }
}
