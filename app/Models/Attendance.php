<?php

namespace App\Models;

use App\Models\Employees;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model {
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'attendance';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'date',
        'shift_id',
        'time_in',
        'time_out',
        'attendance_method_id',
        'attendance_status_id',
        'remark',
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

    public function entryby() {
        return $this->hasOne(User::class, 'id', 'entryby_id');
    }

    public function user() {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function attendance_method() {
        return $this->hasOne(AttendanceMethod::class, 'id', 'attendance_method_id');
    }

    public function attendance_status() {
        return $this->hasOne(AttendanceStatus::class, 'id', 'attendance_status_id');
    }

    public function shift() {
        return $this->hasOne(Shifts::class, 'id', 'shift_id');
    }
}
