<?php
namespace App\Helpers;
use DateTime;
use Cache;
use Auth;
use DB;
use Mail;
use App\Mail\Mailer;
use App\Models\Category;
use App\Models\ProductPrice;
class Utils
{
    public static function sendMail($email, $order_id, $status, $payment_method) {
        
        $html = self::getEmailStatusContent($order_id, $payment_method, $status);
        $status_text = self::readStatusText($status);
        $subject = "Your order status is ".$status_text." now #" . $order_id;

        if ($email) {
            Mail::to($email)->send(new Mailer($subject, $html));
    
            return json_encode(array("response" => "email was sent"));
        }

        return json_encode(array("response" => "field_required"));
    }

    static function timeAgo($datetime, $full = false) {
        $now = new DateTime;
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);
    
        $diff->w = floor($diff->d / 7);
        $diff->d -= $diff->w * 7;
    
        $string = array(
            'y' => 'year',
            'm' => 'month',
            'w' => 'week',
            'd' => 'day',
            'h' => 'hour',
            'i' => 'minute',
            's' => 'second',
        );
        foreach ($string as $k => &$v) {
            if ($diff->$k) {
                $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
            } else {
                unset($string[$k]);
            }
        }
    
        if (!$full) $string = array_slice($string, 0, 1);
        return $string ? implode(', ', $string) . ' ago' : 'just now';
    }

    public static function getEmailStatusContent($order_id, $payment_method, $status) {
        $payment_method = self::readPaymentMethodText($payment_method);
        $html = "<br><h3>Thanks for shopping with us!</h3>";
        $status_text = self::readStatusText($status);
        if ($status == 1) {
            $html .= "<p>We received your order <b>#".$order_id."</b> on 26 ".date('F d, Y H:i:s a')." and you’ll be paying for this via <b>".$payment_method."</b>. 
                    We’re getting your order ready and will let you know once it’s on the way.</p><br>
                    You can view your order details <a target='_blank' href='".url('/my-purchase/'.$order_id)."'>here.</a>";
        }
        if ($status == 2) {
            $html .= "<p>Your order <b>#".$order_id."</b> is <b>".$status_text."</b> now and you’ll be paying for this via <b>".$payment_method.".</b></p><br>
            You can view your order details <a target='_blank' href='".url('/my-purchase/'.$order_id)."'>here.</a>";
        }
        if ($status == 3) {
            $html .= "<p>Your order <b>#".$order_id."</b> is <b>".$status_text."</b> now and you’ll be paying for this via <b>".$payment_method.".</b></p><br>
            You can view your order details <a target='_blank' href='".url('/my-purchase/'.$order_id)."'>here.</a>";
        }
        if ($status == 4) {
            $html .= "<p>Your order <b>#".$order_id."</b> is <b>".$status_text."</b>.</p><br>
            You can view your order details <a target='_blank' href='".url('/my-purchase/'.$order_id)."'>here.</a>";
        }
        if ($status == 5) {
            $html .= "<p>Your order <b>#".$order_id."</b> was cancelled <b>".$status_text."</b> now and you’ll be paying for this via <b>".$payment_method.".</b></p><br>
            You can view your order details <a target='_blank' href='".url('/my-purchase/'.$order_id)."'>here.</a>";
        }

        return $html;
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
        return ["Dashboard", "Maintenance", "Users", "Vouchers", "Manage Orders", "Archive"];
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

    public static function readCategoriesByIDs($ids) {
        $ids = explode(', ', $ids);
        $data = DB::table('category')
                ->whereIn('id', $ids)->get('name');
        $html = "";
        foreach ($data as $data) {
            $html .= '<span class="badge badge-primary m-1">'.$data->name.'</span>';
        }
        echo $html;
    }
    public static function readSubCategoriesByIDs($ids) {
        $ids = explode(', ', $ids);
        $data = DB::table('subcategory')
                ->whereIn('id', $ids)->where('status', 1)->get('name');
        $html = "";
        foreach ($data as $data) {
            $html .= '<span class="badge badge-primary m-1">'.$data->name.'</span>';
        }
        echo $html;
    }
    public static function readPackaging($packaging_ids) {
        return DB::table('products')
                ->select('name', 'size')
                ->whereIn('id', $packaging_ids)->get();
    }

    public static function readClosures($closures_ids) {
        return DB::table('closures')
                ->select('name', 'size')
                ->whereIn('id', $closures_ids)->get();
    }

    public static function readVolumes($sku) {
        $volumes = DB::table('product_price')->where('sku',$sku)->get('volume');
        $volume = "";
        if ($volumes) {
            $counter = count($volumes)-1;
            foreach($volumes as $key => $data) {
                $delimiter = $counter == $key ? '' : ',';
                $volume .= $data->volume . $delimiter;
            }
        }
        echo $volume;
    }

    public static function readImage($sku) {
        $image = DB::table('product_images')->where('sku', $sku)->value('image');
        return !empty($image) ? "images/".$image : "https://gmalcilk.sirv.com/243977931_6213185145420681_2932561991829971205_n.png";
    }

    public static function abbreviateMonthNumber($month_number) {
        switch ($month_number) {
        case 1:
            return "JAN";
            break;
        case 2:
            return "FEB";
            break;
        case 3:
            return "MAR";
            break;
        case 4:
            return "APR";
            break;
        case 5:
            return "MAY";
            break;
        case 6:
            return "JUN";
            break;
        case 7:
            return "JUL";
            break;               
        case 8:
            return "AUG";
             break;                
        case 9:
            return "SEP";
            break;
        case 10:
            return "OCT";
            break;
         case 11:
            return "NOV";
            break;
        case 12:
            return "DEC";
            break;
        }
    }
}
?>