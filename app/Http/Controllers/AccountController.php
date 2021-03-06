<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\PhilippineArea;
use App\Models\Order;
use App\Models\Voucher;
use Auth;
use Cache;
use Utils;
use Hash;
use DB;

class AccountController extends Controller
{
    public function index(PhilippineArea $pa, Voucher $vouchers)
    {
        $order_mdl = new Order;
        $user = User::where('id', Auth::id())->first();
        $vouchers = $vouchers->readVoucherByUserID();

        return view('account', compact('user', 'order_mdl', 'vouchers'));
    }

    public function getProvinces($region) {
        $pa = new PhilippineArea;
        return $pa->getProvinces($region);
    }

    public function getMunicipalities() {
        $pa = new PhilippineArea;
        return $pa->getMunicipalities(request()->region, request()->province);
    }

    public function getBrgys() {
        $pa = new PhilippineArea;
        return $pa->getBrgys(request()->region, request()->province, request()->municipality);
    }

    public function update(Request $request)
    {
        $input = $request->except('password','_token','_method', 'phone_no', 'email');
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

    public function changePassword()
    {
        User::where('id', Auth::id())->update([
            'password' => Hash::make(request()->password)
        ]); 
        
        return response()->json([
            'status' => 'success',
        ]);
    }

    public function addAddress()
    {
        Cache::forget('addresses-cache');
        UserAddress::create([
            'user_id' => Auth::id(),
            'name' => request()->fullname,
            'phone_no' => request()->phone_no,
            'region' => request()->region,
            'province' => request()->province,
            'municipality' => request()->municipality,
            'brgy' => request()->brgy,
            'detailed_loc' => request()->detailed_loc,
            'notes' => request()->notes,
        ]);
        return 'address created';
    }

    public function updateAddress($id)
    {
        Cache::forget('addresses-cache');
        UserAddress::where('id', $id)
        ->update([
            'user_id' => Auth::id(),
            'name' => request()->fullname,
            'phone_no' => request()->phone_no,
            'region' => request()->region,
            'province' => request()->province,
            'municipality' => request()->municipality,
            'brgy' => request()->brgy,
            'detailed_loc' => request()->detailed_loc,
            'notes' => request()->notes,
        ]);

        return response()->json([
            'status' => 'success',
        ]);
    }

    public function readAddresses()
    {
        return UserAddress::where('user_id', Auth::id())->get();
    }

    public function deleteAddress($id)
    {
        Cache::forget('addresses-cache');
        UserAddress::where('id', $id)->delete();
    }

    public function setAddressDefault($id) {
        Cache::forget('addresses-cache');
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
