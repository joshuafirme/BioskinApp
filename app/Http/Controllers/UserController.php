<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Courier;
use Hash;
use Auth;
use Session;
use Utils;
class UserController extends Controller
{
    private $page = "Users";

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::check()) {
            $allowed_pages = explode(",",Auth::user()->allowed_pages);
            if (!in_array($this->page, $allowed_pages)) {
                return redirect('/not-auth');
            }
        }
        return view('admin.user.index');
    }

    public function readUsers() {
        if (Auth::check()) {
            $allowed_pages = explode(",",Auth::user()->allowed_pages);
            if (!in_array($this->page, $allowed_pages)) {
                return redirect('/not-auth');
            }
        }
        $user = User::where('status', 1)->get();
        
        if(request()->ajax())
        { 
            return datatables()->of($user)
                ->addColumn('action', function($user)
                {
                    $button = '<a class="btn btn-sm" data-id="'. $user->id .'" href="'. route('users.edit',$user->id) .'"><i class="fa fa-edit"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a data-id="'. $user->id .'" class="btn btn-archive" data-toggle="modal" data-target="#confirmModal"><i class="fas fa-trash"></i></a>';
                    return $button;
                })
                ->addColumn('access_rights', function($user){
                    $html = "";
                    if($user->access_rights == 1) {
                        $html = "Sales Admin";
                    }
                    elseif($user->access_rights == 2) {
                        $html = "Customer";
                    }
                    elseif($user->access_rights == 3) {
                        $html = "Sales Department";
                    }
                    elseif($user->access_rights == 4) {
                        $html = "Accounting";
                    }
                    elseif($user->access_rights == 5) {
                        $html = "Production";
                    }
                    elseif($user->access_rights == 6) {
                        $html = "Finish Goods";
                    }
                    elseif($user->access_rights == 7) {
                        $html = "Logistics/Warehousing";
                    }
                    elseif($user->access_rights == 8) {
                        $html = "CSR";
                    }
                    return $html;
                })
                ->rawColumns(['action','access_rights'])
                ->make(true);
        }
    }

    public function doLogin(Request $data) {
        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) 
        {
            return redirect()->intended('/shop');  
        }
        else {
            return redirect()->back()->with('danger', 'Invalid username or password.');  
        }
    }
    public function doLoginAjax() {
        if (Auth::attempt(['email' => request()->email, 'password' => request()->password])) 
        {
            return response()->json(['status' => 200, 'message' => 'authorized']);
        }
        else {
            return response()->json(['status' => 200, 'message' => 'unauthorized']);
        }
    }
    public function logout() {
        Auth::logout();
        Session::flush();
        return redirect()->intended('/shop');
    }

    public function doSignup(Request $request) {

        $alert = 'success';
        $message = 'You have successfully registered!';

        $phone_no = $request->phone_no;
        $request['phone_no'] = $phone_no[0] == '0' ? substr($phone_no, 1) : $phone_no;
        // customer access
        $request['access_rights'] = 2;

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
        if (Auth::check()) {
            $allowed_pages = explode(",",Auth::user()->allowed_pages);
            if (!in_array($this->page, $allowed_pages)) {
                return redirect('/not-auth');
            }
        }
        $courier = Courier::where('status', 1)->get();
        return view('admin.user.create', compact('courier'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::check()) {
            $allowed_pages = explode(",",Auth::user()->allowed_pages);
            if (!in_array($this->page, $allowed_pages)) {
                return redirect('/not-auth');
            }
        }
        $request['allowed_modules'] = isset($request->allowed_modules) ? implode(",",$request->allowed_modules) : [];
         $request['allowed_pages'] = isset($request->allowed_pages) ? implode(",",$request->allowed_pages) : [];
        User::create($request->all());
        return redirect()->back()
        ->with('success', 'User was created.');
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
    public function edit(User $user)
    {
        if (Auth::check()) {
            $allowed_pages = explode(",",Auth::user()->allowed_pages);
            if (!in_array($this->page, $allowed_pages)) {
                return redirect('/not-auth');
            }
        }
        $courier = Courier::where('status', 1)->get();
        return view('admin.user.edit', compact('user', 'courier'));
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
        if (Auth::check()) {
            $allowed_pages = explode(",",Auth::user()->allowed_pages);
            if (!in_array($this->page, $allowed_pages)) {
                return redirect('/not-auth');
            }
        }
        $request['allowed_modules'] = isset($request->allowed_modules) ? implode(",",$request->allowed_modules) : [];
        $request['allowed_pages'] = isset($request->allowed_pages) ? implode(",",$request->allowed_pages) : [];
        if ($request->input('password')) {
            User::where('id', $id)
            ->update([
                'password' => \Hash::make($request->input('password'))
            ]);
        }

        User::where('id', $id)->update($request->except('password','_token','_method'));
        return redirect()->back()
        ->with('success', 'User was updated.');
}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function archive($id)
    {
        if (Auth::check()) {
            $allowed_pages = explode(",",Auth::user()->allowed_pages);
            if (!in_array($this->page, $allowed_pages)) {
                return redirect('/not-auth');
            }
        }
        User::where('id',$id)->update(['status' => 0]);
        return response()->json([
            'status' => 'success',
            'req_params' => $id
        ]);
    }
}
