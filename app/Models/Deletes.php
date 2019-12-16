<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Deletes extends Model {
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'deletes';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'table',
        'model',
        'dbDestroy',
        'data_id',
        'data',
        'action_type',
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
        'dbDestroy' => 'array',
        'data'      => 'array',
    ];

    public function entryby() {

        return $this->hasOne(User::class, 'id', 'entryby_id');
    }
}
