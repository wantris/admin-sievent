<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Admin;
use App\Pengguna;
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

        if ($request->role == "admin") {
            $check_username = Admin::where('username', $username)->first();
            // check username
            if ($check_username) {
                if (Hash::check($password, $check_username->password)) {
                    Session::put('is_admin', '1');
                    Session::put('is_wadir3', '0');
                    Session::put('id_pengguna', $check_username->id_admin);
                    return redirect()->route('dashboard');
                } else {
                    return redirect()->back()->with('failed', 'Password salah');
                }
            } else {
                return redirect()->back()->with('failed', 'Username tidak ada');
            }
        } elseif ($request->role == "wadir3") {
            $check = Pengguna::where('username', $username)->first();

            if ($check) {
                if (Hash::check($password, $check->password)) {
                    Session::put('is_admin', '0');
                    Session::put('is_wadir3', '1');
                    Session::put('id_pengguna', $check->id_pengguna);
                    return redirect()->route('dashboard');
                } else {
                    return redirect()->back()->with('failed', 'Password salah');
                }
            } else {
                return redirect()->back()->with('failed', 'Username tidak ada');
            }
        }
    }


    public function logout(Request $request)
    {
        $request->session()->flush();
        return redirect()->route('auth.index');
    }
}
