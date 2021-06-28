<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function index()
    {
        $title = "Login Admin";
        return view('auth.login', compact('title'));
    }

    public function postLogin(Request $request)
    {
        $username = $request->username;
        $password = $request->password;

        $check_username = Admin::where('username', $username)->first();
        // check username
        if ($check_username) {
            if (Hash::check($password, $check_username->password)) {
                Session::put('is_admin', '1');
                Session::put('id_admin', $check_username->id_admin);
                return redirect()->route('dashboard');
            } else {
                return redirect()->back()->with('failed', 'Password salah');
            }
        } else {
            return redirect()->back()->with('failed', 'Username tidak ada');
        }
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('auth.index');
    }
}
