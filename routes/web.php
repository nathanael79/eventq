<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Routing dasar untuk tampilan awal web - FrontEnd
Route::group(['prefix'=>'/'],function()
{
    //-----------------FRONTEND------------------------------//
    //Routing ke arah halaman frontend User
    Route::get('/',function ()
    {
        return view('FrontEnd.index');
    });

    Route::get('/login',
        [
            "uses"=>"Auth\LoginController@FrontEndIndex",
            "as"=>"frontloginpage"
        ]);

    Route::post('/login',
        [
            "uses"=>"Auth\LoginController@loginuser",
            "as"=>"frontlogin"
        ]);

    Route::get('/register',
        [
            "uses"=>"Auth\RegisterController@FrontEndIndex",
            "as"=>"frontregisterpage"
        ]);

    Route::post('/register',
        [
            "uses" => "Auth\RegisterController@createUser",
            "as" => 'frontregister'
        ]);



    //-----------------FRONTEND------------------------------//


    //-----------------BACKEND------------------------------//
    //Routing dasar untuk tampilan awal web admin - Backend
    Route::group(['prefix'=>'/admin'],function ()
    {

        //testing
        Route::get('/testing/{id}',[
            "uses"=>"BackEnd\Database\Event\EventController@list_peserta",
            "as"=>"testing ambil data"
        ]);

        //Routing ke arah halaman login admin
        Route::get('/',
            [
                "uses"=>"Auth\LoginController@BackEndIndex",
                "as"=>'backloginpage'
            ]);

        //Routing post halaman login admin
        Route::post('/login',
            [
                "uses"=>"Auth\LoginController@loginuser",
                "as"=>'login'
            ]);

        //Routing ke arah halaman register admin
        Route::get('/register',
            [
                "uses" => 'Auth\RegisterController@BackEndIndex',
                "as" => 'registerpage'
            ]);

        //Routing post halaman register admin
        Route::post('/register',
            [
                "uses" => "Auth\RegisterController@createUser",
                "as" => 'register'
            ]);

        //Routing ke arah halaman error
        Route::get('/error',
            [
                "uses"=>'Auth\ErrorController@index',
                "as"=>"errorpage",
            ]);

        Route::post('/logout',
            [
                "uses"=>'Auth\LoginController@logoutuser',
                "as"=>"logout"
            ]);

        //Routing ke arah profile atau halaman pertama setelah login
        Route::get('/profile',
            [
                "uses"=>"ProfileController@index",
                "as"=>"profilepage"
            ]);


        //Routing halaman Account
        Route::group(['prefix' => '/account'],function()
        {
            //Routing ke arah halaman akun
            Route::get('/', [
                "uses" => "BackEnd\Database\Account\AccountController@index",
                "as" => "accountpage"
            ]);

            //Routing untuk menampilkan datatable
            Route::get('/data_table',[
                "uses"=>"BackEnd\Database\Account\AccountController@getDataTable",
                "as"=>"account.dt"
            ]);

            //Routing untuk menampilkan page create akun baru
            Route::get('/add',[
                "uses"=>"BackEnd\Database\Account\AccountController@create",
                "as"=>"account.dt.cr.page"
            ]);

            //Routing untuk mengirimkan data yang telah diinput di halaman create
            Route::post('/store',[
                "uses"=>"BackEnd\Database\Account\AccountController@store",
                "as"=>"account.pst"
            ]);

            //Routing untuk menampilkan halaman edit akun
            Route::get('/edit/{id}',[
                "uses"=>"BackEnd\Database\Account\AccountController@edit",
                "as"=>"account.edt"
            ]);

            //Routing untuk update akun dengan data dari halaman edit akun
            Route::post('/update/{id}',[
                "uses"=>"BackEnd\Database\Account\AccountController@update",
                "as"=>"account.upd"
            ]);

            //Routing untuk delete akun
            Route::get('/delete/{id}',[
                "uses"=>"BackEnd\Database\Account\AccountController@delete",
                "as"=>"account.del"
            ]);
        });


        //Routing untuk halaman Event
        Route::group(['prefix'=>'/event'],function ()
        {
            Route::get('/',[
                "uses"=>"BackEnd\Database\Event\EventController@index",
                "as"=>"event"
            ]);

            Route::get('/data_table',[
                "uses"=>"BackEnd\Database\Event\EventController@getDataTable",
                "as"=>"event.dt"
            ]);

            Route::post('/get-detail',[
                "uses"=>"BackEnd\Database\Event\EventController@getDetail",
                "as"=>"event.detail"
            ]);

            Route::get('/add',[
                "uses"=>"BackEnd\Database\Event\EventController@create",
                "as"=>"event.dt.cr"
            ]);

            Route::post('/store',[
                "uses"=>"BackEnd\Database\Event\EventController@store",
                "as"=>"event.pst"
            ]);

            Route::get('/edit/{id}',[
                "uses"=>"BackEnd\Database\Event\EventController@edit",
                "as"=>"event.edt"
            ]);

            Route::post('/update/{id}',[
                "uses"=>"BackEnd\Database\Event\EventController@update",
                "as"=>"event.upd"
            ]);

            Route::get('/delete/{id}',[
                "uses"=>"BackEnd\Database\Event\EventController@delete",
                "as"=>"eventss.del"
            ]);

            Route::get('/list-peserta/{id}',[
                "uses"=>"BackEnd\Database\Event\EventController@list_peserta",
                "as"=>"event.list"
            ]);

            Route::get('list-peserta/data_table/{id}',[
                "uses"=>"BackEnd\Database\Event\EventController@getDataTableList",
                "as"=>"event.list-peserta"
            ]);


            //Route::get('/list-peserta/data-table/{id}',[
                //"uses"=>"BackEnd\Database\Event\EventController@list_peserta",
                //"as"=>"events.list-peserta"
            //]);
        });
    });

    //Routing untuk pengiriman EMAIL
    Route::get('/email', function () {
        return view('send_email');
    });
    Route::post('/sendEmail', 'EmailController@sendEmail');

    //-----------------BACKEND------------------------------//
});



