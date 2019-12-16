<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FCMTokens extends Model {
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'fcm_tokens';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'fcm_token',
        'os_type',
        'device_udid',
        'device_name',
        'description',
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
    protected $casts = [
        'device_log' => 'array',
    ];

    public function entryby() {

        return $this->hasOne(User::class, 'id', 'entryby_id');
    }

    public function user() {

        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
