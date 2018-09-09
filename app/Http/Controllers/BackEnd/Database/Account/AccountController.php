<?php
/**
 * Created by PhpStorm.
 * User: nathanael79
 * Date: 25/07/18
 * Time: 1:18
 */

namespace App\Http\Controllers\BackEnd\Database\Account;


use App\Http\Controllers\Controller;
use App\Models\User;
use DataTables;
use DB;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Validator;

class AccountController extends Controller
{
    public function index()
    {
        return view('BackEnd.Database.Account.account');
    }

    public function getDataTable()
    {
        return DataTables::of(User::all())->make(true);
    }

    public function create()
    {
        $data = [
            'regency'=> DB::table('regencies')->get(),
            //'provinces'=>DB::table('provinces')->get()
        ];

        return view('BackEnd.Database.Account.insert',$data);
    }

    public function store(Request $request)
    {
        if($request->file("photo"))
        {
            $time = Carbon::now();
            $extension = $request->file('photo')->getClientOriginalExtension();
            $directory = 'Account/';
            $filename = str_slug($request->input('name')).'-'.date_format($time,'d').rand(1,999).date_format($time,'h').".".$extension;
            $upload_success = $request->file("photo")->storeAs($directory,$filename,'public');
        }
        else
        {
            $filename = '';
        }

        Validator::make($request->only(['name','address','email','password','gender','user_role','birthdate','regency']),[
           'name'=>'required',
           'address'=>'required',
           'email'=>'required',
           'password'=>'required',
           'gender'=>'required',
           'user_role'=>'required',
           'birthdate'=>'required', 
           'regency'=>'required',
        ]);

        $activeUser = User::where('email',$request->email)->first();
            if(is_null($activeUser))
            {
                $user = [
                    'name' => $request->name,
                    'address'=> $request->address,
                    'email'=>$request->email,
                    'password'=>sha1($request->password),
                    'gender'=>$request->gender,
                    'user_role'=>$request->user_role,
                    'birthdate'=>$request->birthdate,
                    'regency_id'=>$request->regency,
                    'photo'=>$filename,
                ];

                if(User::create($user))
                {
                    //Mail::send()
                    return view('BackEnd.Database.Account.account');
                }
            }
            else
            {
                echo "user telah ada";
            }
    }

    public function edit($id)
    {
        $data = [
            'user' => User::find($id),
            'regencies'=> DB::table('regencies')->get(),
        ];
        return view('BackEnd.Database.Account.edit',$data);
    }

    public function update(Request $request, $id)
    {
        if($request->file("photo"))
        {
            $time = Carbon::now();
            $extension = $request->file('photo')->getClientOriginalExtension();
            $directory = 'Account/';
            $filename = str_slug($request->input('name')).'-'.date_format($time,'d').rand(1,999).date_format($time,'h').".".$extension;
            $upload_success = $request->file("photo")->storeAs($directory,$filename,'public');
        }
        else
        {
            $filename = '';
        }

        $account = [
            'name'=>$request->name,
            'address'=> $request->address,
            'email'=>$request->email,
            'password'=>sha1($request->password),
            'gender'=>$request->gender,
            'user_role'=>$request->user_role,
            'birthdate'=>$request->birthdate,
            'regency_id'=>$request->regency,
            'photo'=>$filename,

        ];

        Validator::make($account,[
            'name'=>'required',
            'address'=>'required',
            'email'=>'required',
            'password'=>'required',
            'gender'=>'required',
            'user_role'=>'required',
            'birthdate'=>'required',
            'regency'=>'required',
        ]);

        if(User::find($id)->update($account))
        {
            return redirect('/admin/account/');
        }
    }

    public function delete($id)
    {
        if(User::destroy($id))
        {
            return view('BackEnd.Database.Account.account');
        }
    }

}