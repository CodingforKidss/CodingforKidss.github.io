<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifications extends Model {
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'notifications';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'type',
        'priority',
        'user_from_id',
        'user_to_id',
        'topics',
        'title',
        'body',
        'sound',
        'tag',
        'color',
        'icon',
        'click_action',
        'data',
        'table_data',
        'table_data_id',
        'table',
        'model',
        'read',
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
        'sound'      => 'boolean',
    ];

    public function entryby() {

        return $this->hasOne(User::class, 'id', 'entryby_id');
    }

    public function user_from() {

        return $this->hasOne(User::class, 'id', 'user_from_id');
    }

    public function user_to() {

        return $this->hasOne(User::class, 'id', 'user_to_id');
    }
}
