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
        $input = $request->except('password','_token','_method');
        if($request->hasFile('image')){       
            $folder_to_save = 'profile';
            $image_name = uniqid() . "." . $request->image->extension();
            $request->image->move(public_path('images/' . $folder_to_save), $image_name);
            $input['image'] = $folder_to_save . "/" . $image_name;
        }
        User::where('id', Auth::id())->update($input);
        return redirect()->back()
        ->with('success', 'Profile was updated successfully.');
    }
}
