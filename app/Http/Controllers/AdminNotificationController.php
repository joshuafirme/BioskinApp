<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderDetail;
use Auth;
use DB;
use DateTime;
use Utils;

class AdminNotificationController extends Controller
{
    public function getNotifications()
    {
        $latest_processing_count = 0;
        $latest_otw_count = 0;
        $latest_to_receive_count = 0;
        $latest_order_received_count = 0;
        $latest_completed_count = 0;
        $latest_cancelled_count = 0;
        
        $notification_text = "";
        $time_ago = strtotime("-5 second");

        $formatted_time_ago = date('Y-m-d H:i:s', $time_ago);

        $allowed_modules_array = explode(",",Auth::user()->allowed_modules);

        $processing_text = "";
        $otw_text = "";
        $to_receive_text = "";
        $order_received_text = "";
        $completed_text = "";
        $cancelled_text = "";

        if(in_array("Processing orders", $allowed_modules_array)) {
            $latest_processing_count = OrderDetail::where('status', 1)->where('updated_at', '>=', $formatted_time_ago)->count('id');
            $today_processing_count = OrderDetail::where('status', 1)->whereDate('updated_at', '>=', date('Y-m-d'))->count('id');
            $latest_processing_dt = OrderDetail::where('status', 1)->latest()->value('updated_at');

            if ($today_processing_count > 0) {
                $processing_text = "{$today_processing_count} <b>processing</b> orders today <br> ";
            }
            if (isset($latest_processing_dt) && $latest_processing_dt) {
                $processing_text .= "<small>Last <b>processing</b> order was made " . Utils::timeAgo($latest_processing_dt) . "</small>";
            }
        }
        if(in_array("On the way", $allowed_modules_array)) {
            $latest_otw_count = OrderDetail::where('status', 2)->where('updated_at', '>=', $formatted_time_ago)->count('id');
            $today_otw_count = OrderDetail::where('status', 2)->whereDate('updated_at', '>=', date('Y-m-d'))->count('id');
            $latest_otw_dt = OrderDetail::where('status', 2)->latest()->value('updated_at');
            if ($today_otw_count > 0) {
                $otw_text = "<small>{$today_otw_count} new on the way orders today <br> </small>";
            }
            if (isset($latest_otw_dt) && $latest_otw_dt) {
                $otw_text .= "<small>Last <b>on the way</b> order was made " . Utils::timeAgo($latest_otw_dt) . "</small>";
            }
        }
        if(in_array("To receive", $allowed_modules_array)) {
            $latest_to_receive_count = OrderDetail::where('status', 3)->where('updated_at', '>=', $formatted_time_ago)->count('id');
            $today_to_receive_count = OrderDetail::where('status', 3)->whereDate('updated_at', '>=', date('Y-m-d'))->count('id');
            $latest_to_receive_dt = OrderDetail::where('status', 3)->latest()->value('updated_at');
            if ($today_to_receive_count > 0) {
                $to_receive_text = "{$today_to_receive_count} to receive orders today <br> ";
            }
            if (isset($latest_to_receive_dt) && $latest_to_receive_dt) {
                $to_receive_text .= "<small>Last <b>to receive</b> order was made " . Utils::timeAgo($latest_to_receive_dt) . "</small>";
            }
        }
        if(in_array("Order received", $allowed_modules_array)) {
            $latest_order_received_count = OrderDetail::where('status', 6)->where('updated_at', '>=', $formatted_time_ago)->count('id');
            $today_order_received_count = OrderDetail::where('status', 6)->whereDate('updated_at', '>=', date('Y-m-d'))->count('id');
            $latest_order_received_dt = OrderDetail::where('status', 6)->latest()->value('updated_at');
            if ($today_order_received_count > 0) {
                $order_received_text = "{$today_order_received_count} received orders today <br> ";
            }
            if (isset($latest_order_received_dt) && $latest_order_received_dt) {
                $order_received_text .= "<small>Last <b>order received</b> order was made " . Utils::timeAgo($latest_order_received_dt) . "</small>";
            }
        }
        if(in_array("Completed", $allowed_modules_array)) {
            $latest_completed_count = OrderDetail::where('status', 4)->where('updated_at', '>=', $formatted_time_ago)->count('id');
            $today_completed_count = OrderDetail::where('status', 4)->whereDate('updated_at', '>=', date('Y-m-d'))->count('id');
            $latest_completed_dt = OrderDetail::where('status', 4)->latest()->value('updated_at');
            
            if ($today_completed_count > 0) {
                $completed_text = "{$today_completed_count} completed orders today <br> ";
            }
            if (isset($latest_completed_dt) && $latest_completed_dt) {
                $completed_text .= "<small>Last <b>completed</b> order was made " . Utils::timeAgo($latest_completed_dt) . "</small>";
            }
        }
        if(in_array("Cancelled", $allowed_modules_array)) {
            $latest_cancelled_count = OrderDetail::where('status', 5)->where('updated_at', '>=', $formatted_time_ago)->count('id');
            $today_cancelled_count = OrderDetail::where('status', 5)->whereDate('updated_at', '>=', date('Y-m-d'))->count('id');
            $latest_cancelled_dt = OrderDetail::where('status', 5)->latest()->value('updated_at');
            
            if ($today_cancelled_count > 0) {
                $cancelled_text = "{$today_cancelled_count} cancelled orders today <br> ";
            }
            if (isset($latest_cancelled_dt) && $latest_cancelled_dt) {
                $cancelled_text .= "<small>Last <b>cancelled</b> order was made " . Utils::timeAgo($latest_cancelled_dt) . "</small>";
            }
        }
        
        
  
        $notif_contents = array(
            "processing" => $processing_text,
            "otw" => $otw_text,
            "to_receive" => $to_receive_text,
            "order_received" => $order_received_text,
            "completed" => $completed_text,
            "cancelled" => $cancelled_text,
        );
       
        $notif_counts = array(
            "processing_count" => $latest_processing_count,
            "otw_count" => $latest_otw_count ,
            "to_receive_count" => $latest_to_receive_count,
            "order_receive_count" => $latest_order_received_count,
            "completed_count" => $latest_completed_count,
            "cancelled_count" => $latest_cancelled_count,
        );

        return json_encode(array("response" => 1, "message" => "Showing Result", "notif_counts"=> $notif_counts, "notif_content" => $notif_contents));
    }
}
