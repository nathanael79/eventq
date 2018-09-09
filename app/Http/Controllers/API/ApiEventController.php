<?php
/**
 * Created by PhpStorm.
 * User: nathanael79
 * Date: 26/07/18
 * Time: 16:25
 */

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Models\Event;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ApiEventController extends Controller
{
    public function create(Request $request)
    {
        if($request->name)
        {
            $activeEvent = Event::where('name',$request->name)->first();
            if(is_null($activeEvent))
            {
                Event::create([
                    "name"=> $request->name,
                    "address"=>$request->address,
                    "regency_id"=>$request->regency_id,
                    "price"=>$request->price,
                    "quota"=>$request->quota,
                    "category_id"=>$request->category_id,
                    "start_date"=>$request->start_date,
                    "end_date"=>$request->end_date,
                    "description"=>$request->description,
                    "confirmation_date"=>$request->confirmation_date,
                    "photo"=>$request->photo,
                    "status"=>$request->event,
                ]);

                return response()->json([
                    "status"=>true,
                    "code"=>200,
                    "message"=>"event telah berhasil dibuat"
                ]);
            }
            //jika event sudah ada
            else
            {
                return response()->json([
                    "status"=>false,
                    "code"=>500,
                    "message"=>"event pernah didaftarkan"
                ]);
            }
        }
        //jika event tidak diisi dengan nama
        else
        {
            return response()->json([
                "status"=>false,
                "code"=>250,
                "message"=>"anda belum mengisi nama event"
            ]);
        }

    }

    public function update(Request $request, $id)
    {
        $event = Event::find($id);

        if($event!=null)
        {
            $event->update([
                'name'=>$request->name,
                'address'=>$request->address,
                'regency_id'=>$request->regency_id,
                'price'=>$request->price,
                'quota'=>$request->quota,
                'category_id'=>$request->category_id,
                'start_date'=>$request->start_date,
                'end_date'=>$request->end_date,
                'description'=>$request->description,
                'confirmation_date'=>$request->confirmation_date,
                'photo'=>$request->photo, //belum fix
                'status'=>$request->status,
                'gender'=>$request->gender,
            ]);

            if(Event::where('event',$event)->first->updated())
            {
                return response()->json([
                    'status'=>'true',
                    'code'=>200,
                    'data'=>$event,
                    'message'=>"event berhasil diupdate"
                ]);
            }
            else
            {
                return response()->json([
                    'status'=>'gagal',
                    'code'=>500,
                    //'data'=>$event,
                    'message'=>"event gagal diupdate"
                ]);
            }
        }
    }

    public function show()
    {
        return response()->json([
            "status"=>true,
            "code"=>200,
            'data'=>Event::all()
        ]);
    }

    /*public function search(Request $request, $name)
    {
        $query = $request->get('$name');
        $hasil = Event::where('name','LIKE','%'.$query.'%');

        return response()->json([
            "status"=>"berhasil",
            "code"=>200,
            "data"=>$hasil,
        ]);
    }*/

    public function search(Request $request)
    {
        /*$events = Event::when($request->keyword, function ($query) use ($request) {
            $query->Where('name', 'like', "%{$request->keyword}%");
        })->get();*/
        $search = $request->get('keyword');
        $events = Event::where('name','LIKE','%'.$search.'%')
            ->get();

        if(!$events)
        {
            return response()->json([
                "status"=>false,
                "code"=>500,
                "message"=>"data tidak ditemukan"
            ]);
        }
        else 
        {
            return response()->json([
                "status" => true,
                "code" => 200,
                "message" => "pencarian berhasil",
                "data" => $events
            ]);
        }
    }


    public function showById($id)
    {
        $event = Event::where('id',$id);
        if($event)
        {
            return response()->json([
                'status' => true,
                'code' => 200,
                "message"=>"data berhasil ditampilkan berdasarkan id",
                'data' => $event
            ]);
        }
        else
        {
            return response()->json([
                "status"=>false,
                "code"=>500,
                "message"=>"data gagal ditampilkan berdasarkan id"
            ]);
        }
    }

    public function delete($id)
    {
        $event = Event::findOrFail($id);
        if($event->delete())
        {
            return response()->json([
                "status"=>true,
                "code"=>200,
                "message"=>"data berhasil dihapus"
            ]);
        }
        else
        {
            return response()->json([
                "status"=>false,
                "code"=>500,
                "message"=>"data gagal dihapus"
            ]);
        }
    }

}