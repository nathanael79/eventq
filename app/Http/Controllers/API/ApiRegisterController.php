<?php
/**
 * Created by PhpStorm.
 * Auth: nathanael79
 * Date: 23/07/18
 * Time: 23:44
 */

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Array_;

class ApiRegisterController extends Controller
{
    public function create(Request $request)
    {
        if($request->email && $request->password){
            $activeUser = User::where('email',$request->email)->first();
            if(is_null($activeUser))
            {
                $token = str_random(100);

                $user =
                    [
                        'name' => $request->name,
                        'email' => $request->email,
                        'password' => sha1($request->password),
                        'gender'=>$request->gender,
                        'status' => 0,
                        'token' => $token,
                    ];

                Validator::make($user, [
                    'name' => 'required|string|max:255',
                    'email' => 'required|email|string|max:255|unique:user',
                    'password' => 'required|string|min:6|confirmed',
                    'gender'=> 'required'
                ]);

                if (User::create($user))
                {
                    try {
                        Mail::send('email', ['token' => $token, 'name' => $request->name, 'email' => $request->email], function ($message) use ($request) {
                            $message->subject('Konfirmasi Pendaftaran User Baru');
                            $message->from('cangkrukanklas18@gmail.com', 'Kelompok Linux Arek Suroboyo (KLAS)');
                            $message->to($request->email);
                        });
                        //return back()->with('alert-success', 'Berhasil Kirim Email');
                        return response()->json([
                            "status"=>true,
                            "code"=>200,
                            "message"=>"berhasil"
                        ]);
                    } catch (Exception $e) {
                        return response(['status' => false, 'code'=>200, 'errors' => $e->getMessage()]);
                        //return view('Auth.login');
                    }
                }
                else
                {
                    return response()->json([
                        "status"=>false,
                        "code"=>500,
                        "message"=>"gagal membuat user"
                    ]);
                }
            }
            else
            {
                return response()->json([
                    "status"=>false,
                    "code"=>250,
                    "message"=>"user telah ada"
                ]);
            }
        }
        else
        {
            return response()->json([
                "status"=>"false",
                "code"=>251,
                "message"=>"email atau password belum diinputkan"
            ]);
        }

        /*
        if($request->email && $request->password)
        {
            User::create([
                "name"=>$request->name,
                "email"=>$request->email,
                "password"=>sha1($request->password),
            ]);

            return response()->json([
                "status"=>'true',
                "code"=>200
            ]);
        }
        else
        {
            return response()->json([
               "status"=>"gagal",
               "code"=>500,
            ]);
        }*/
    }
}