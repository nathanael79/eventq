<?php
/**
 * Created by PhpStorm.
 * Auth: nathanael79
 * Date: 23/07/18
 * Time: 14:11
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    protected $table = 'user';
    public $timestamps = false;
    protected $fillable =
        [
            'name',
            'address',
            'email',
            'password',
            'gender',
            'user_role',
            'birthdate',
            'regency_id',
            'photo',
            'date_created',
            'status',
            'token'
        ];

    public function getRegencyId()
    {
        return $this->hasOne('App\Models\Regency','regency_id','id');
    }

}