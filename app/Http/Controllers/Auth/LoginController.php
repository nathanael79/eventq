<?php
/**
 * Created by PhpStorm.
 * Auth: nathanael79
 * Date: 23/07/18
 * Time: 14:57
 */

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class LoginController extends Controller
{
    public function BackEndIndex()
    {
        return view('BackEnd.Auth.login');
    }

    public function FrontendIndex()
    {
        return view('FrontEnd.Auth.login');
    }

    public function loginUser(Request $request)
    {
        //sreturn view('Auth.login');

        $email = $request->input('email');
        $password = sha1($request->input('password'));

        $activeUser = User::where([
            'email'=>$email,
            'password'=>$password
        ])->firstOrFail();

        if($activeUser->status == 1) {
            if (is_null($activeUser)) {
                return "<div class='alert alert-danger'>Pengguna Tidak Ditemukan!</div>";
            } else {
                if ($activeUser->password != $password) {
                    return "<div class='alert alert-danger'>Password Salah!</div>";
                } else {
                    $request->session()->put('activeUser', $activeUser);
                    return redirect("/admin/profile");
                }
            }
        }
        else
        {
            return "<div class='alert alert-danger'>Anda belum konfirmasi email</div>";
        }
    }

    public function logoutUser(Request $request)
    {
        $request->session()->flush();
        return redirect('/');
    }

}