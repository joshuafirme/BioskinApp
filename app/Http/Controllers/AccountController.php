<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class AccountController extends Controller
{
    public function index()
    {
        $user = User::where('id', Auth::id())->first();
        return view('account', compact('user'));
    }

    public function update(Request $request)
    {
        User::where('id', Auth::id())->update($request->except('password','_token','_method'));
        return redirect()->back()
        ->with('success', 'Profile was updated successfully.');
    }
}
