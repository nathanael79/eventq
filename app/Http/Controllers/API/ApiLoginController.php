<?php
/**
 * Created by PhpStorm.
 * Auth: nathanael79
 * Date: 23/07/18
 * Time: 23:42
 */

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class ApiLoginController extends Controller
{
    public function login(Request $request)
    {
        $email = $request->email;
        $password = sha1($request->password);

        $activeUser = User::where('email',$email)->first();
        if(is_null($activeUser))
        {
            return response()->json([
                "status"=>false,
                "code"=>500,
                "message"=>"email belum terdaftar"
            ]);
        }
        else {
            //if($activeUser->status == 1)
            $status = $activeUser->status;
            if ($status == 1)
            {
                if ($password == $activeUser->password) {
                    return response()->json([
                        "status" => true,
                        "code" => 200,
                        "message" => "login berhasil dilakukan",
                        "data" => $activeUser
                    ]);
                } else {
                    return response()->json([
                        "status" => false,
                        "code" => 300,
                        "message" => "password yang anda masukkan salah"
                    ]);
                }
            }
            else
            {
                return response()->json([
                    "status"=>false,
                    "code"=>400,
                    "message"=>"anda belum konfirmasi email"
                ]);
            }
        }
    }

}