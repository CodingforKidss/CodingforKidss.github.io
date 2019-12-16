<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Edits extends Model {
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'edits';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'table',
        'model',
        'form_data',
        'dbInsert',
        'data_id',
        'prev_data',
        'new_data',
        'changed_data',
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
        'form_data'    => 'array',
        'dbInsert'     => 'array',
        'prev_data'    => 'array',
        'new_data'     => 'array',
        'changed_data' => 'array',
    ];

    public function entryby() {

        return $this->hasOne(User::class, 'id', 'entryby_id');
    }
}
