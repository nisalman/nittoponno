<?php

namespace App\Http\Controllers;


use App\LoginHistory;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class LoginController2 extends Controller
{

    public function login()
    {
        //Session::remove("LAST_ACTIVE_TIME");
        if (Auth::check()) {

            if (Auth::user()->user_type == getAdminId() || Auth::user()->user_type == getAgentId()) {
                return Redirect::to('/admin/dashboard');
            } elseif (Auth::user()->user_type == getSupplierId()) {
                return Redirect::to('/supplier/dashboard');
            }
        } else {
            return view('login');
        }

    }

    public function index()
    {

        return view('pages.home.index');
    }

    public function doLogin(Request $request)
    {

        $user_name = $request['user_name'];
        $password = $request['password'];
        $remember = true;

        // attempt to do the login
        if (Auth::attempt(['user_name' => $user_name, 'password' => $password], $remember)) {

            if (!Auth::user()->is_active) {
                Auth::logout();
                return back()->with('failed', "User Deactivated");
            }
            try {
                LoginHistory::create([
                    'ip_address' => request()->ip(),
                    'user_id' => Auth::id()
                ]);
            } catch (\Exception $exception) {
                return $exception->getMessage();
            }

            if (Auth::user()->user_type == 3 || Auth::user()->user_type == 4) {
                return Redirect::to('/supplier/dashboard');
            }
            return Redirect::to('/admin/dashboard');
        } else {
            return back()->with('failed', "Username or password does not match");

        }
    }

    public function doLogout()
    {
        Auth::logout(); // log the user out of our application
        return Redirect::to('/');
    }

    public function registration()
    {
        return view('register')->with('users', User::where('designation', 'DC/AC')->get());
    }

    public function confirmMail($id)
    {
        $id = $this->decrypt($id);
        try {
            User::where('id', $id)->update(['active_status' => 0]);
            return Redirect::to('/login')->with('success', "Email Confirmed");
        } catch (\Exception $exception) {
            return Redirect::to('/login')->with('failed', $exception->getMessage());
        }
    }


    public function mailConfirm($email, $id)
    {
        $id = $this->encrypt($id);
        $url = "benapole.pixonlab.com/user/confirm/" . $id;
        $msg = "Please click on given Link:  \n " . $url;

        //echo $this->decrypt($id);
        mail($email, "Mail From Leave APP ", $msg);

    }

    function encrypt($input)
    {
        return strtr(base64_encode($input), '+/=', '._-');
    }

    function decrypt($input)
    {
        return base64_decode(strtr($input, '._-', '+/='));
    }

    public function forgetPass()
    {

    }
}
