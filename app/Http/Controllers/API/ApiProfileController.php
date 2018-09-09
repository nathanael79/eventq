<?php
/**
 * Created by PhpStorm.
 * User: nathanael79
 * Date: 07/08/18
 * Time: 21:19
 */

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use http\Env\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class ApiProfileController extends Controller
{
    public function getRegenciesId()
    {
        return response()->json([
            'status'=>true,
            'code'=>200,
            'data'=>DB::table('regencies')->get()
        ]);
    }

    public function update(Request $request, $id)
    {
        //$user = User::where('id',$id);
        $user = User::find($id);
        $token = str_random(100);

        /*$this->validate($request,[
            'name'=> 'required|string|max:255',
            'email'=> 'required|email|max:255|unique:users',
            'password'=> 'required|string|min:6|confirmed',
            'gender'=>'required|string'
        ]);*/

        if($user!=null)
        {
            if(sha1($request->password)== $user->password) {
                if ($request->file("photo")) {
                    $time = Carbon::now();
                    $extension = $request->file('photo')->getClientOriginalExtension();
                    $directory = 'Account/';
                    $filename = str_slug($request->input('name')) . '-' . date_format($time, 'd') . rand(1, 999) . date_format($time, 'h') . "." . $extension;
                    $upload_success = $request->file("photo")->storeAs($directory, $filename, 'public');

                    $user->update([
                        'name' => $request->name,
                        'email' => $request->email,
                        //'password'=>sha1($request->password),
                        'address' => $request->address,
                        'gender' => $request->gender,
                        //'birthdate'=>$request->birthdate,
                        'regency_id' => $request->regency_id,
                        'photo' => $filename,
                    ]);

                    return response()->json([
                        "status" => true,
                        "code" => 200,
                        "message" => "berhasil diupdate menggunakan foto",
                        "data" => $user
                    ]);
                } else {
                    //$filename = '';
                    $user->update([
                        'name' => $request->name,
                        'email' => $request->email,
                        //'password'=>sha1($request->password),
                        'address' => $request->address,
                        'gender' => $request->gender,
                        //'birthdate'=>$request->birthdate,
                        'regency_id' => $request->regency_id,
                        //'photo' => $filename,
                    ]);

                    return response()->json([
                        "status" => true,
                        "code" => 300,
                        "message" => "berhasil diupdate tanpa foto",
                        "data" => $user
                    ]);
                }

                /*if($request->email != $user->email)
                {
                    Mail::send('email', ['token' => $token, 'name' => $request->name, 'user' => $user], function ($message) use ($request) {
                        $message->subject('Konfirmasi Pendaftaran Email Baru');
                        $message->from('cangkrukan.klas@gmail.com', 'Kelompok Linux Arek Suroboyo (KLAS)');
                        $message->to($request->email);
                    });
                }*/

            }
            else
            {
                return response()->json([
                    "status"=>false,
                    "code"=>500,
                    "message"=>"password tidak sesuai"
                ]);
            }
        }
    }

    public function updatePassword(Request $request, $id)
    {
        $user = User::where('id',$id)->first();
        $user->password = sha1($request->password);
        $user->save();

        return response()->json([
            "status"=>true,
            "code"=>200,
            "message"=>"berhasil diupdate password",
            "data"=>$request->password
        ]);
    }

    public function show() //Read All
    {
        //User::update()->all()
        return response()->json([
            'status'=>'berhasil',
            'code'=>200,
            'data'=>User::all()
        ]);
    }

    public function detailuser($id){
        $cekuser=User::where(['id'=>$id])->first();
        if (is_null($cekuser)){
            $params = [
                'code' => 500,
                'status'=>false,
                'message' => 'data user gagal ditampilkan',
            ];
            return response()->json($params);
        }
        $params=[
            'code' => 200,
            'status'=>true,
            'message' => 'data user berhasil ditampilkan',
            'data'=>$cekuser
        ];
        return response()->json($params);
    }

}