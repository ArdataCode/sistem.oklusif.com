<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthCtrl extends Controller
{
    public function loginView()
    {
        return view('login');
    }

    public function auth(Request $request)
    {
        $request->password = bcrypt($request->password);
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->route("dashboard")->with("success", "Login successfuly!");
        }

        return redirect()->route("login")->with("error", "Email atau Password Salah!");
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You are now logged out!');
    }

    public function updateFotoProfile(Request $request)
    {
        $imageName = time() . '.' . $request->image->getClientOriginalExtension();
        $request->image->move(public_path('/uploadedimages'), $imageName);
        User::find(auth()->user()->id)->update(["image" => $imageName]);
        return back();
    }
}
