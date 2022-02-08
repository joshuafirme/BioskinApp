<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentSetting;
use Auth;

class PaymentSettingsController extends Controller
{
    private $page = "Payment Settings";

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            
            if (Auth::check()) {
                $allowed_pages = explode(",",Auth::user()->allowed_pages);
                if (!in_array($this->page, $allowed_pages)) {
                    return redirect('/not-auth');
                }
            }
            return $next($request);
        });
    }
    public function index()
    {
        $payment_settings = PaymentSetting::all();

        return view('admin.payment-settings.index', compact('payment_settings'));
    }

    public function update($id)
    {
        if (isset(request()->enable_on_retail)) {
            PaymentSetting::where('id', $id)->update([
                'enable_on_retail' => request()->enable_on_retail
            ]);
        }
        if (isset(request()->enable_on_rebrand)) {
            PaymentSetting::where('id', $id)->update([
                'enable_on_rebrand' => request()->enable_on_rebrand
            ]);
        }

        return json_encode(array("response" => "success"));
    }

    
}
