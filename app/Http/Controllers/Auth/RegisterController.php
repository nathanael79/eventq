<?php
/**
 * Created by PhpStorm.
 * Auth: nathanael79
 * Date: 23/07/18
 * Time: 14:52
 */

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Session;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function FrontEndIndex()
    {
        return view('FrontEnd.Auth.register');
    }

    public function BackEndIndex()
    {
        return view('BackEnd.Auth.register');
    }

    public function createUser(Request $request)
    {
        //$user->getVillageId();
        $activeUser = User::where('email', $request->email)->first();
        $token = str_random(100);
        if (is_null($activeUser)) {
            $user =
                [
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => sha1($request->password),
                    'gender' => $request->gender,
                    'status' => 0,
                    'token' => $token,
                ];

            Validator::make($user, [
                'name' => 'required|string|max:255',
                'email' => 'required|email|string|max:255|unique:user',
                'password' => 'required|string|min:6|confirmed',
                'gender' => 'required|string',
            ]);

            if (User::create($user)) {
                try {
                    Mail::send('email', ['token' => $token, 'name' => $request->name, 'email' => $request->email], function ($message) use ($request) {
                        $message->subject('Konfirmasi Pendaftaran User Baru');
                        $message->from('cangkrukanklas18@gmail.com', 'Kelompok Linux Arek Suroboyo (KLAS)');
                        $message->to($request->email);
                    });
                    return back()->with('alert-success', 'Berhasil Kirim Email');
                } catch (Exception $e) {
                    return response(['status' => false, 'errors' => $e->getMessage()]);
                    return view('Auth.login');
                }
            }
        }
        else
        {
            redirect('/error') ;
        }
    }
}