<?php
/**
 * Created by PhpStorm.
 * User: nathanael79
 * Date: 26/07/18
 * Time: 12:07
 */

namespace App\Http\Controllers;


class ProfileController extends Controller
{
    public function index()
    {
        return view('BackEnd.profile');
    }

}