<?php

namespace App\Http\Controllers\Auth;


use App\Http\Controllers\Controller;


class RootController
{
    public function login()
    {
        return view('login.index');
    }

    public function index()
    {
        return view('entry.index');
    }

    public function addlist()
    {
        return view('entry.index');
    }

}