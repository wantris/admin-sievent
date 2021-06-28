<?php

namespace App\Http\Controllers;

use App\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\AdminStoreRequest;

class adminController extends Controller
{
    public function index()
    {
        $title = "Admin";
        $headerTitle = "Data Admin";

        $admins = Admin::all();
        return view('admin.index', compact('title', 'headerTitle', 'admins'));
    }

    public function add()
    {
        $title = "Admin";
        $headerTitle = "Tambah Admin";
        return view('admin.add', compact('title', 'headerTitle'));
    }

    public function save(AdminStoreRequest $req)
    {
        $validated = $req->validated();

        $admin = new Admin();
        $admin->nama = $req->nama;
        $admin->username = $req->username;
        $admin->password = Hash::make($req->password);
        $admin->save();

        return redirect()->route('admin.index')->with('success', 'Data admin berhasil disimpan');
    }

    public function edit($id)
    {
        $title = "Admin";
        $headerTitle = "Tambah Admin";
        $admin = Admin::where('id_admin', $id)->first();
        return view('admin.edit', compact('title', 'headerTitle', 'admin', 'id'));
    }

    public function update(Request $req, $id)
    {
        $newPassword = $req->newPassword;
        if ($newPassword == null) {
            $admin = Admin::find($id);
            $admin->nama = $req->nama;
            $admin->username = $req->username;
            $admin->password = $req->oldPassword;
            $admin->save();
        } else {
            $admin = Admin::find($id);
            $admin->nama = $req->nama;
            $admin->username = $req->username;
            $admin->password = Hash::make($req->newPassword);
            $admin->save();
        }

        return redirect()->route('admin.index')->with('success', 'Data admin berhasil disimpan');
    }

    public function delete($id)
    {
        Admin::where('id', $id)->delete();
        return redirect()->route('admin.index');
    }
}
