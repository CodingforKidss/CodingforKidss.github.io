<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseEnrolment extends Model {
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'course_enrolment';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'course_id',
        'user_id',
        'enrol_date',
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
    protected $casts = [
        'device_log' => 'array',
    ];

    public function course() {
        return $this->hasOne(Courses::class, 'id', 'course_id');
    }

    public function enrolment() {

        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
