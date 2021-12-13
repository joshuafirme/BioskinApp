<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserAddress;
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

    public function addAddress()
    {
        UserAddress::create([
            'user_id' => Auth::id(),
            'name' => request()->fullname,
            'address' => request()->address,
            'phone_no' => request()->phone_no
        ]);
        return 'address created';
    }

    public function readAddresses()
    {
        return UserAddress::where('user_id', Auth::id())->get();
    }

    public function deleteAddress($id)
    {
        UserAddress::where('id', $id)->delete();
    }

    public function setAddressDefault($id) {
        UserAddress::where('user_id', Auth::id())
            ->where('is_active', 1)
            ->update([
                'is_active' => 0
            ]);

        UserAddress::where('id', $id)
            ->update([
                'is_active' => 1
            ]);
    }
}
