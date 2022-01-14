<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Utils;

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
}
