<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash;
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function doSignup(Request $request) {

        $alert = 'success';
        $message = 'You have successfully registered!';

        $phone_no = $request->phone_no;
        $request['phone_no'] = $phone_no[0] == '0' ? substr($phone_no, 1) : $phone_no;

        if ($this->isEmailExists($request->input('email'))) {
            $alert = 'danger';
            $message = 'Email is already exists.';
        }
        else if ($this->isUsernameExists($request->input('username'))) {
            $alert = 'danger';
            $message = 'Username is already exists.';
        }
        else if ($this->isPhoneNoExists($request['phone_no'])) {
            $alert = 'danger';
            $message = 'Phone number is already exists.';
        }
        else {
            $request['password'] = Hash::make($request['password']);
            User::create($request->all());
        }

        return redirect()->back()
            ->with($alert, $message);
    
    }

    public function isEmailExists($email)
    {
        $res = User::where('email', $email)->get();
        return count($res) == 1 ? true : false;
    }

    public function isUsernameExists($username)
    {
        $res = User::where('username', $username)->get();
        return count($res) == 1 ? true : false;
    }

    public function isPhoneNoExists($phone_no)
    {
        $res = User::where('phone_no', $phone_no)->get();
        return count($res) == 1 ? true : false;
    }

    public function login_view(){
        return view('login');
    }

    public function signup_view(){
        return view('signup');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
