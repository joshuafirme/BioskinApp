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
       /* $email = isset(request()->email) ? request()->email : "";
        $name = isset(request()->name) ? request()->name : "No name";
        $subject = isset(request()->subject) ? request()->subject : "No subject";
        $message = isset(request()->message) ? request()->message : "";

        $html = "From: {$name} <br>";
        $html .= "Email: {$email} <br>";
        $html .= "Message: {$message} <br>";

        if ($email && $message) {
            Mail::to("csr@bioskinphilippines.com")->send(new Mailer($subject, $html));
    
            return json_encode(array("response" => "email was sent"));
        }

        return json_encode(array("response" => "field_required"));*/

        $client = new PostmarkClient("861ffb96-74fe-4d55-9dd5-e15c67831659");
        $fromEmail = "csr@bioskinphilippines.com";
        $toEmail = "csr@bioskinphilippines.com";
        $subject = "Hello from Postmark";
        $htmlBody = "<strong>Hello</strong> dear Postmark user.";
        $textBody = "Hello dear Postmark user.";
        $tag = "example-email-tag";
        $trackOpens = true;
        $trackLinks = "None";
        $messageStream = "outbound";

        // Send an email:
        $sendResult = $client->sendEmail(
        $fromEmail,
        $toEmail,
        $subject,
        $htmlBody,
        $textBody,
        $tag,
        $trackOpens,
        NULL, // Reply To
        NULL, // CC
        NULL, // BCC
        NULL, // Header array
        NULL, // Attachment array
        $trackLinks,
        NULL, // Metadata array
        $messageStream
        );
    }
}
