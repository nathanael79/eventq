<?php
/**
 * Created by PhpStorm.
 * Auth: nathanael79
 * Date: 24/07/18
 * Time: 10:55
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class Regency extends Model
{
    protected $table ='regencies';
    public $timestamps=false;

    public function getProvinceId()
    {
        return $this->hasOne('App/Models/Province','province_id','id');

    }

}