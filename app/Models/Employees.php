<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employees extends Model {
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'employees';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'employee_no',
        'name',
        'email',
        'date_of_birth',
        'gender',
        'religion',
        'blood_group',
        'marital_status',
        'nationality_id',
        'passport_no',
        'driving_license',
        'nid',
        'address',
        'city_id',
        'post_code',
        'country_id',
        'phone',
        'emergency_name',
        'emergency_address',
        'emergency_city_id',
        'emergency_post_code',
        'emergency_country_id',
        'emergency_phone',
        'department_id',
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
    protected $casts = [
        'device_log' => 'array',
        'work_days'  => 'array',
    ];

    public function entryby() {

        return $this->hasOne(User::class, 'id', 'entryby_id');
    }

    /*public function entry_type() {
        return $this->hasOne(EntryTypes::class, 'id', 'entry_type_id');
    }*/

    public function city() {
        //return $this->hasOne(City::class, 'id', 'city_id');
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

    public function shift() {
        return $this->hasOne(Shifts::class, 'id', 'shift_id');
    }

    public function department() {
        return $this->hasOne(Departments::class, 'id', 'department_id');
    }

    public function designation() {
        return $this->hasOne(Designations::class, 'id', 'designation_id');
    }

    public function pay_rate_unit_type() {
        return $this->hasOne(TimeUnits::class, 'id', 'pay_rate_unit_type_id');
    }
}
