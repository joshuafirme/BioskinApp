<?php
namespace App\Helpers;
use DateTime;
use Cache;
use Auth;
use App\Models\Category;
use App\Models\ProductPrice;
class Utils
{

    public static function validateAllowedPages($page) {
        
    }

    public static function readOnePriceBySKUAndVolume($sku, $volume) {
        $p = new ProductPrice;
        return  $p->readOnePriceBySKUAndVolume($sku, $volume);
    }

    public static function curlRequest($url) {
		$c = curl_init();
		curl_setopt($c, CURLOPT_URL, $url);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, true);
		$data = curl_exec($c);
		curl_close($c);
		return $data;
	}

    public static function getModules() {
        return ["To pay", "Processing orders", "On the way", "To receive", "Order received", "Completed", "Cancelled"];
    }
    
    public static function getPages() {
        return ["Dashboard", "Maintenance", "Users", "Vouchers", "Manage Orders"];
    }

    public static function readCategories() {
        $cache_categories = Cache::get('categories-cache');
        if (!$cache_categories) {
            $cache_categories = Category::where('status', 1)->get();
            Cache::put('categories-cache', $cache_categories);
        } 
        return $cache_categories;
    }
    public static function isValidForPayment($expiry_date) {
        if (!empty($expiry_date)) {
            $datetime_now = new DateTime(date('Y-m-d h:m:s'));
            $expiry_date = new DateTime($expiry_date);
            
            return $datetime_now < $expiry_date ? true : false;
        }
        return false;
    }

    public static function concatAddress($address) {
        $province       = isset($address->province) ? $address->province : "";
        $municipality   = isset($address->municipality) ? $address->municipality : "";
        $brgy           = isset($address->brgy) ? $address->brgy : "";
        $detailed       = isset($address->detailed) ? $address->detailed : "";
        $notes          = isset($address->notes) ? $address->notes : "";
       
        return $province." ".$municipality." ".$brgy." ".$detailed;
    }
    
    public static function readStatusText($status) {
        $text = "";
        switch ($status) {
            case 0:
                $text = 'To Pay';
                break;
            case 1:
                $text = 'Processing';
                break;
            case 2:
                $text = 'On the way';
                break;
            case 3:
            case 6:
                $text = 'To receive';
                break;
            case 4:
                $text = 'Completed';
                break;
            case 5:
                $text = 'Cancelled';
                break;
                    
            default:
                $text = "";
                break;
        } 
        return $text;
    }


    public static function readPaymentMethodText($payment_method) {
        
        switch ($payment_method) {
            case 'COD':
                $text = "Cash on Delivery";
                break;
            case 'cc':
                $text = 'Credit/Debit Card';
                break;
            case 'gc':
                $text = 'GCash';
                break;
            case 'bpionline':
                $text = 'BPI Online';
                break;
            case 'br_bdo_ph':
                $text = "BDO Online";
                break;
            case 'ceb':
                $text = "Cebuana";
                break;
            default:
                $text = $payment_method;
                break;
          }

        return $text;
    }
}
?>