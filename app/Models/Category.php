<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'category';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'category_no',
        'name',
        'description',
        'photo',
        'branch_id',
        'entryby_id',
        //        'entry_type_id',
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

    public function entryby() {

        return $this->hasOne(User::class, 'id', 'entryby_id');
    }

    /*public function entry_type() {

        return $this->hasOne(EntryTypes::class, 'id', 'entry_type_id');
    }*/

    public function category_items() {

        return $this->hasMany(CategoryItem::class, 'category_id', 'id');
    }
}
