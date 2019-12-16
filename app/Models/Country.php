<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model {
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'countries';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'country_code_2',
        'country_code_3',
        'name',
        'currency_id',
        'timezone_id',
        'latitude',
        'longitude',
        'active'
    ];
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [];
}
