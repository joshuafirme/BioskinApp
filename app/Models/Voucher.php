<?php

namespace App\Models;
use DB;
use Auth;

use Illuminate\Database\Eloquent\Model;

class Voucher extends Model
{
    protected $table = 'voucher';

    protected $fillable = [
        'voucher_code',
        'discount',
        'minimum_purchase_amount',
        'status',
        'limit'
    ];

    public function readVoucherByUserID(){
        return DB::table('user_voucher as uv')
        ->select('v.*', 'uv.used', 'v.voucher_code')
        ->leftJoin('voucher as v', 'v.voucher_code', '=', 'uv.voucher_code')
        ->where('uv.user_id', Auth::id())
        ->get();
    }

    public function initVoucher($voucher_code, $total) {
        if ($this->isActive($voucher_code) == 1) {
            if ($this->voucherMinimumAmount($voucher_code) > $total) {
                return "minimum_amount_exceeded";
            }
            else {
                $used = DB::table('user_voucher')
                ->where('user_id', Auth::id())
                ->where('voucher_code', $voucher_code)
                ->value('used');
    
                if ($used >= $this->voucherLimit($voucher_code)) {
                    return "voucher_limit_exceeded";
                }
                else {
                    if (isset($used) && $used) {
                        DB::table('user_voucher')
                        ->where('user_id', Auth::id())
                        ->where('voucher_code', $voucher_code)
                        ->update([
                            'used' => DB::raw('used + 1')
                        ]);
                        return "voucher_applied";
                    }
                    else {
                        DB::table('user_voucher')->insert([
                            'user_id' => Auth::id(),
                            'voucher_code' => $voucher_code,
                            'used' => 1
                        ]);
                        return "voucher_applied";
                    }
                }
            }
        }
        else {
            return "not_valid";
        }
       
    }

    public function isActive($voucher_code) {
        return DB::table('voucher')->where('voucher_code', $voucher_code)->value('status');
    }
    
    public function voucherLimit($voucher_code) {
        return DB::table('voucher')->where('voucher_code', $voucher_code)->value('limit');
    }

    public function voucherMinimumAmount($voucher_code) {
        return DB::table('voucher')->where('voucher_code', $voucher_code)->value('minimum_purchase_amount');
    }
}
