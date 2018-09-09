<?php
/**
 * Created by PhpStorm.
 * User: nathanael79
 * Date: 10/08/18
 * Time: 4:31
 */

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventParticipant;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ApiFilterEventController extends Controller
{
    public function latest_event()
    {
        //$date_now = Carbon::now();
        $eventCheck = Event::where('start_date','>=',Carbon::now())->first();

        if($eventCheck)
        {
            return response()->json([
                "status"=>true,
                "code"=>200,
                "message"=>"data event terbaru berhasil ditampilkan",
                "data"=>Event::where('start_date', '>=',Carbon::now())
                    ->orderBy('start_date','desc')
                    ->limit(7)
                    ->get(),
            ]);
        }
        else
        {
            return response()->json([
                "status"=>false,
                "code"=>500,
                "message"=>"tidak ada event terbaru"
            ]);
        }

        /*$latest_event = DB::table('event')
            ->orderBy('created_date','desc')
            //->limit(3)
            ->get();*/
        //$latest_event = DB::table('event')->latest()->get();
    }

    public function done_event()
    {
        /*$done_event = Event::where('end_date','<=',Carbon::now())
            ->orderBy('end_date','desc')
            ->limit(7)
            ->get();*/
        $done_event = Event::where('avail',0)->get();

        if($done_event)
        {
            return response()->json([
                "status" => true,
                "code" => 200,
                "message"=>"data event yang telah selesai berhasil ditampilkan",
                "data" => $done_event,
            ]);
        }
        else
        {
            return response()->json([
                "status"=>false,
                "code"=>500,
                "message"=>"data event yang telah selesai gagal ditampilkan"
            ]);
        }
    }

    public function event_byUser($id)
    {
        $eventparticipant = EventParticipant::where('user_id',$id)->get();
        if($eventparticipant)
        {
            return response()->json([
                "status" => true,
                "code" => 200,
                "message"=>"Data Event yang telah diikuti user berhasil ditampilkan",
                "data" => $eventparticipant
            ]);
        }
        else
        {
            return response()->json([
                "status"=>false,
                "code"=>500,
                "message"=>"Data Event yang telah diikuti user gagal ditampilkan"
            ]);
        }
    }

}