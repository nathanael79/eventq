<?php
/**
 * Created by PhpStorm.
 * User: nathanael79
 * Date: 14/08/18
 * Time: 2:49
 */

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;

class ErrorController extends Controller
{
    public function index()
    {
        return view('error_page');
    }
}