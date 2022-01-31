<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Utils;
use Mail;
use App\Mail\Mailer;
use Postmark\PostmarkClient;

class PagesController extends Controller
{
    public function termsAndConditions() {
        return view('pages.terms-and-conditions');
    }

    public function aboutUs() {
        return view('pages.about-us');
    }

    public function contactUs() {
        return view('pages.contact-us');
    }

    public function notAuth() {
        return view('admin.pages.not-auth');
    }

    public function sendMail(){
        $email = isset(request()->email) ? request()->email : "";
        $name = isset(request()->name) ? request()->name : "No name";
        $subject = isset(request()->subject) ? request()->subject : "No subject";
        $message = isset(request()->message) ? request()->message : "";

        $html = "Customer name: {$name} <br>";
        $html .= "Email: {$email} <br>";
        $html .= "Message: {$message} <br>";

        $toEmail = "csr@bioskinphilippines.com";

        if ($email && $message) {
            Utils::posmarkMail($toEmail, $subject, $html);
    
            return json_encode(array("response" => "email was sent"));
        }

        return json_encode(array("response" => "field_required"));

        
    }
}
