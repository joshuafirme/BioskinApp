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
        $users = User::paginate(10);
        return view('admin.user.index',compact('users'));
    }

    public function readUsers() {
        if (Auth::check()) {
            $allowed_pages = explode(",",Auth::user()->allowed_pages);
            if (!in_array($this->page, $allowed_pages)) {
                return redirect('/not-auth');
            }
        }
        $user = User::get();
        
        if(request()->ajax())
        { 
            return datatables()->of($user)
                ->addColumn('action', function($user)
                {
                    $button = '<a class="btn btn-sm" data-id="'. $user->id .'" href="'. route('users.edit',$user->id) .'"><i class="fa fa-edit"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    return $button;
                })
                ->addColumn('created_at', function($user)
                {
                    return date('F d, Y h:i A', strtotime($user->created_at));
                })
                ->addColumn('status', function($user)
                {
                    if ( $user->status == 1 ) {
                        return '<span class="badge badge-success">Active</span>';
                    }
                    else if ( $user->status == 0 ) {
                        return '<span class="badge badge-danger">Blocked</span>';
                    }
                })
                ->addColumn('customer', function($user)
                {
                    $customer_name = $user->firstname . " " . $user->middlename   . " " . $user->lastname;
                    $html =  "<b>" . $customer_name . "</b><br>";
                    $html .= '<a href="mailto: '. $user->email .'" target="_blank"><span>'. $user->email .'</span></a>';
                    return $html;
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
                ->rawColumns(['action','access_rights', 'created_at', 'customer','status'])
                ->make(true);
        }
    }

    public function doLogin(Request $data) {
        if (Auth::attempt(['email' => $data['email'], 'password' => $data['password']])) 
        {
            if (Auth::user()->status == 1) {
                return redirect()->intended('/shop');  
            }
            return redirect()->back()->with('danger', 'Your account is blocked.');  
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

            $to_email = request()->email;
            $first_name = request()->firstname;
            $subject = "Welcome to Bioskin Philippines!";
            $html_body = Utils::welcomeMailTemplate($first_name);
            $text_body = Utils::welcomeMailTemplateText($first_name);
            Utils::postMarkMail($to_email, $subject, $html_body, $text_body);
        }

        return redirect()->back()
            ->with($alert, $message);
    
    }

    public function forgotPasswordView()
    {
        return view('forgot-password');
    }

    public function resetPasswordView()
    {
        $_token = isset(request()->token) ? request()->token : "";

        $result = User::where('reset_key', $_token)->value('id');
        $is_token_valid = false;
        if (isset($result) && strlen($result) > 0) {
            $is_token_valid = true;
        }
        
        return view('reset-password', compact('is_token_valid'));
    }

    public function sendResetPasswordLink()
    {
        $to_email = request()->email;
        $_token = request()->_token;

        if (Utils::isEmailExists($to_email)) {
            $reset_link = url('/reset-password?token='.$_token);
            $subject = "Reset Password";
            $name = $this->readNameByEmail($to_email);
    
            $this->updateResetKey($to_email, $_token);
    
            $html_body = Utils::resetPasswordMailTemplate($name, $reset_link);
    
            $text_body = Utils::resetPasswordMailTemplateText($name, $reset_link);
            
            Utils::postMarkMail($to_email, $subject, $html_body, $text_body);
    
            return redirect()->back()->with('success', 'Please check your email, we have sent a link to reset your password.');
        }

        return redirect()->back()->with('danger', $to_email.' is not exists in our system.');
    }

    public function updateResetKey($email, $_token)
    {
       User::where('email', $email)->update(['reset_key' => $_token]);
    }

    public function resetPassword()
    {
        $_token = request()->_token;
        $email = User::where('reset_key', $_token)->value('email');
        $password = request()->password;

        if (isset($email) && strlen($email) > 0 && $password) {
            User::where('email', $email)
            ->update([
                'password' => Hash::make($password),
                'reset_key' => ""
            ]);

            return redirect('/login')->with('success', "You have successfully reset your password.");
        }

        return redirect()->back()->with('success', "Unable to reset your password.");
    }

    public function readNameByEmail($email)
    {
       return User::where('email', $email)->value('firstname');
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
