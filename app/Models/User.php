<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable {
    use HasApiTokens, Notifiable;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'facebookId',
        'fb_access_token',
        'googlePlusId',
        'google_access_token',

        'username',
        'email',
        'email_verified_at',
        'password',
        'name',
        'address',
        'city_id',
        'post_code',
        'country_id',
        'phone',
        'role_id',
        'parent_id',

        'employee_no',
        'date_of_birth',
        'gender',
        'religion',
        'blood_group',
        'marital_status',
        'nationality_id',
        'passport_no',
        'driving_license',
        'nid',
        'emergency_name',
        'emergency_address',
        'emergency_city_id',
        'emergency_post_code',
        'emergency_country_id',
        'emergency_phone',
        'designation_id',
        'joining_date',
        'resign_date',
        'pay_rate',
        'pay_rate_unit_type_id',
        'shift_id',
        'work_days',
        'employement_type',
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
        'ipAddress_signup'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];
    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'device_log'        => 'array',
        'work_days'         => 'array',
    ];

    public function entryby() {

        return $this->hasOne(User::class, 'id', 'entryby_id');
    }

    public function role() {

        return $this->hasOne(UserRoles::class, 'id', 'role_id');
    }

    public function branch() {

        //return $this->hasOne(Branch::class, 'id', 'branch_id');
    }

    public function city() {

        //return $this->hasOne(City::class, 'id', 'city');
    }

    public function emergency_city() {

        //return $this->hasOne(City::class, 'id', 'emergency_city_id');
    }

    public function country() {

        return $this->hasOne(Country::class, 'id', 'country_id');
    }

    public function emergency_country() {

        return $this->hasOne(Country::class, 'id', 'emergency_country_id');
    }

    public function nationality() {

        return $this->hasOne(Country::class, 'id', 'nationality_id');
    }

    public function fcm_tokens() {

        return $this->hasMany(FCMTokens::class, 'user_id', 'id');
    }

    public function enrolments() {

        return $this->hasMany(CourseEnrolment::class, 'user_id', 'id');
    }

    public function parent() {

        return $this->hasOne(User::class, 'id', 'parent_id');
    }

    public function login_sessions() {

        return $this->hasMany(LoginSessions::class, 'user_id', 'id');
    }
}
