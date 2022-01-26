<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Utils;
use Mail;
use App\Mail\Mailer;

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
        $email = 'gracepearltesting@gmail.com';
        Mail::to($email)
        ->send(new Mailer('test'));

        return json_encode(array("response" => "success"));
    }
}
