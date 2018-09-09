<?php
/**
 * Created by PhpStorm.
 * Auth: nathanael79
 * Date: 23/07/18
 * Time: 14:20
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

class EventParticipant extends Model
{
    protected $table = 'event_participant';
    protected $fillable =
            [
                'event_id',
                'user_id',
                'attendance',
                'token'
            ];

    public $timestamps = false;

    public function getUserId()
    {
        return $this->hasOne('App\Models\User','user_id','id');
    }

    public function getEventId()
    {
        return $this->hasOne('App\Models\Event','event_id','id');
    }
}