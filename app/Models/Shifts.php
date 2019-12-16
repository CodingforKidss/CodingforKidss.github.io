<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Shifts extends Model {
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'shifts';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
        'day_id',
        'time_from',
        'time_to',
        'duration',
        'break_time_from',
        'break_time_to',
        'duration_break',
        'description',
        'photo',
        'branch_id',
        'entryby_id',
        'entry_type_id',
        'active',
        'status',
        'comment',
        'api_ver',
        'app_ver',
        'app_build_ver',
        'u_agent',
        'device_log',
        'ipAddress',
        'created_at',
        'updated_at',
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'device_log' => 'array',
    ];

    public function entryby() {

        return $this->hasOne(User::class, 'id', 'entryby_id');
    }

    public function day() {
        return $this->hasOne(SchedulingDays::class, 'id', 'day_id');
    }

    public function employees() {

        return $this->hasMany(User::class, 'shift_id', 'id');
    }
}
