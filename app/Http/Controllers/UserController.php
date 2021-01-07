<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    //
    private $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    public function login() {
        return view('login');
    }
    public function getStatusLogin() {
        return response()->json(['status' => Auth::check()],200);
    }
    public function checkLogin(Request $request) {
        if(Auth::attempt(['email' => $request->username,'password' => $request->password])) {
            return redirect()->route('index');
        } else {
            return redirect()->route('user.login');
        }
    }
    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('index');
    }
    public function sigup(Request $request) {
        try {
            DB::beginTransaction();
            $this->user->create([
                'name' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'phone' => $request->phone,
            ]);
            DB::commit();
            if(Auth::attempt(['email' => $request->email,'password' => $request->password])) {
                return redirect()->route('index');
            } else {
                return redirect()->route('user.login');
            }
        }catch (\Exception $exception) {
            DB::rollBack();
            Log::error('error ' . $exception->getMessage() . ' line ' . $exception->getLine() );
        }
    }
}
