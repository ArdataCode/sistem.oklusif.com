<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserCtrl extends Controller
{
    public function index()
    {
        $data_users = User::where('role', '=', 'Owner')->orWhere('role', '=', 'Admin')->get();
        $countData = User::where('role', '=', 'Owner')->orWhere('role', '=', 'Admin')->count();
        return view('user', compact('data_users', 'countData'));
    }

    public function store(Request $request)
    {
        $imageName = time() . '.' . $request->image->getClientOriginalExtension();
        $request->image->move(public_path('/uploadedimages'), $imageName);

        User::create([
            "nama" => $request->nama,
            "email" => $request->email,
            "role" => $request->role,
            "password" => bcrypt($request->password),
            "image" => $imageName
        ]);

        return back()->with("success", "Berhasil menambahkan user baru");
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return back()->with("error", "User tidak ditemukan");
        }

        $imageName = "";
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('/uploadedimages'), $imageName);
            File::delete(public_path('uploadedimages/' . $user->image));
        }

        $user->update([
            "nama" => $request->nama ?? $user->nama,
            "email" => $request->email ?? $user->email,
            "role" => $request->role ?? $user->role,
            "password" => $request->new_password != null ? bcrypt($request->new_password) : $user->password,
            "image" => $request->hasFile('image') ? $imageName : $user->image
        ]);

        return back()->with("success", "Berhasil mengubah user");
    }

    public function delete($id)
    {
        $user = User::find($id);

        if (!$user) {
            return back()->with("error", "User tidak ditemukan");
        }

        File::delete(public_path('uploadedimages/' . $user->image));
        $user->destroy($id);

        return back()->with("success", "Berhasil menghapus user");
    }
}
