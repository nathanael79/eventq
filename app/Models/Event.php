<?php
/**
 * Created by PhpStorm.
 * Auth: nathanael79
 * Date: 23/07/18
 * Time: 14:23
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    public $timestamps = false;
    protected $table = 'event';
    protected $fillable =
        [
            'name',
            'address',
            'regency_id',
            'price',
            'quota',
            'category_id',
            'start_date',
            'end_date',
            'description',
            'confirmation_date',
            'created_date',
            'photo',
            'status',
            'avail'
        ];

    public function getVillageId()
    {
        return $this->hasOne('App\Models\Regency','regency_id','id');
    }

    public function getCategoryId()
    {
        return $this->hasOne('App\Models\Category','category_id','id');
    }

}