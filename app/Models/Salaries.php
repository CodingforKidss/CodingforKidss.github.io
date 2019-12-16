<?php

namespace App\Models;

use App\Models\Employees;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class Salaries extends Model {
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'salaries';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'total_amount',
        'amount',
        'date_from',
        'date_to',
        'date',
        'payment_method_id',
        'payment_status_id',
        'reference_no',
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

    public function payment_method() {
        return $this->hasOne(PaymentMethod::class, 'id', 'payment_method_id');
    }

    public function payment_status() {
        return $this->hasOne(PaymentStatus::class, 'id', 'payment_status_id');
    }
}
