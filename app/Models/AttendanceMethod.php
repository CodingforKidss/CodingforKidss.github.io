<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceMethod extends Model {
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'attendance_method';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'name',
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
}
