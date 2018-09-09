<?php
/**
 * Created by PhpStorm.
 * User: nathanael79
 * Date: 07/08/18
 * Time: 17:18
 */

namespace App\Http\Controllers\API;

use App\Models\Event;
use App\Models\EventParticipant;
use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ApiEventParticipantController extends Controller
{
    public function register(Request $request)
    {
        $event = $request->event_id;
        $user = $request->user_id;
        $activeUser = User::where('id',$user)->first();
        $activeEvent = Event::where('id',$event)->first();
        $registeredUser = EventParticipant::where('user_id',$user)->where('event_id',$event)->first();
        $registered = EventParticipant::where('user_id',$user)->where('event_id',$event)->get()->count();
        $totalEvent =$activeEvent->get()->count();
        $token = str_random(100);

        //apabila melebihi start date
        if(Carbon::now() < Carbon::parse($activeEvent->start_date))
        {
            //apabila melebihi confirmation date
            if(Carbon::now() < Carbon::parse($activeEvent->confirmation_date))
            {
                //apabila melebihi quota
                if($activeEvent->quota > $registered)
                {
                    //apabila user belum terdaftar pada event tersebut
                    if(is_null($registeredUser))
                    {
                        $eventparticipant= [
                            "user_id" => $request->user_id,
                            "event_id" => $request->event_id,
                            "attendance" => null,
                            "token"=>$token
                        ];

                        //mengirim email konfirmasi kehadiran
                        
                        if(EventParticipant::create($eventparticipant))
                        {
                        try {
                        Mail::send('email_event', ['token' => $token, 'event_id'=>$request->event_id], function ($message) use ($request) {
                            $activeUser = User::where('id',$request->user_id)->first();
                            $message->subject('Konfirmasi Pendaftaran Peserta Event');
                            $message->from('cangkrukanklas18@gmail.com', 'Kelompok Linux Arek Suroboyo (KLAS)');
                            $message->to($activeUser->email);
                        });
//                        return back()->with('alert-success', 'Berhasil Kirim Email');
                            return response()->json([
                                "status"=>true,
                                "code"=>200,
                                "message"=>"berhasil mendaftar"
                            ]);
                    } catch (Exception $e) {
                        return response(['status' => false, 'code'=>200, 'errors' => $e->getMessage()])->json(['code'=>200]);
                        //return view('Auth.login');
                    }
                        }
                        else
                        {
                            return response()->json([
                                "status"=>false,
                                "code"=>204,
                                "message"=>"gagal mendaftar pada event ini"
                            ]);
                        }
                    }
                    else
                    {
                        return response()->json([
                            "status"=>false,
                            "code"=>203,
                            "message"=>"Anda sudah terdaftar pada user ini"
                        ]);
                    }

                }
                else
                {
                    $activeEvent->avail = 0;
                    $activeEvent->save();
                    return response()->json([
                        "status"=>false,
                        "code"=>202,
                        "message"=>"Kuota untuk Event ini telah terpenuhi",
                        "data"=>$activeEvent->avail,
                        "datenow"=>Carbon::now()
                    ]);
                }

            }
            else
            {
                $activeEvent->avail = 0;
                $activeEvent->save();
                return response()->json([
                    "status"=>false,
                    "code"=>201,
                    "message"=>"Anda tidak bisa mendaftar pada event ini karena telah melebihi batas tanggal konfirmasi",
                    "data"=>$activeEvent->avail,
                    "datenow"=>Carbon::now()
                ]);
            }
        }
        else
        {
            $activeEvent->avail = 0;
            $activeEvent->save();
            return response()->json([
                "status"=>false,
                "code"=>500,
                "message"=>"Anda tidak bisa mendaftar pada Event ini",
                "data"=>$activeEvent->avail,
                "datenow"=>Carbon::now(),
                "dateDB"=>Carbon::parse($activeEvent->start_date)
            ]);
        }

    }

    /*public function getQuota(Request $request)
    {
        $quota = Event::where('id',$request->event_id)->first();
        return response()->json([
            "data"=>$quota->quota,
        ]);

        //$quota = Event::where('id',$request->event_id)->first();
        //dd($quota[0]->quota);
    }*/

    public function show(Request $request)
    {
        $registeredEvent = Eventparticipant::all();
        return response()->json([
            "status"=> true,
            "code"=>200,
            "message"=>"data berhasil ditampilkan",
            "data"=>$registeredEvent,
        ]);
    }

    public function showById($id)
    {
        $registeredEvent = EventParticipant::findOrFail($id);
        if($registeredEvent)
        {
            return response()->json([
                "status" => true,
                "code"=>200,
                "message"=>"data berhasil ditampilkan",
                "data" => "$registeredEvent"
            ]);
        }
        else
        {
            return response()->json([
                "status"=>false,
                "code"=>500,
                "message"=>"data gagal ditampilkan"
            ]);
        }
    }

}