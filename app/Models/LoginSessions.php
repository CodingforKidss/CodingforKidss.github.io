<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginSessions extends Model {
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'login_sessions';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'role_id',
        'token_id',
        'time_login',
        'time_logout',
        'description',
        'photo',
        'branch_id',
        'entryby_id',
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
}
