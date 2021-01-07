<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    //
    public function index() {
        return view('admin.dashboard');
    }
    public function login() {
        return view('admin_login');
    }
    public function checkLogin(Request $request) {
        if(Auth::attempt(['email' => $request->admin_email, 'password' => $request->admin_password])) {
            return redirect()->route('admin');
        } else {
            return redirect()->route('admin.login');
        }
    }

}
