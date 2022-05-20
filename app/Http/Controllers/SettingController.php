<?php

namespace App\Http\Controllers;

use App\LoginHistory;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!Auth::check()) {
                return Redirect::to('/login');
            }
            return $next($request);
        });
    }



    public function adminHome()
    {
        $login_histories = LoginHistory::
        join('users', 'users.id', '=', 'login_histories.user_id')
            ->orderBy('login_histories.created_at', 'DESC')
            ->limit(10)
            ->get([
                'login_histories.ip_address',
                'login_histories.created_at',
                'users.name',
                'users.profile_pic',
            ]);
        return view('pages.home.index')
            ->with('histories', $login_histories)
            ->with('unseen_notifications', null);

    }

    public function profile()
    {

        return view('pages.profile.index')->with('result', User::where('id', Auth::id())->first());


    }

    public function editProfile()
    {

        return view('pages.profile.edit')->with('result', User::where('id', Auth::id())->first());

    }

    public function updateProfile(Request $request)
    {

        unset($request['_token']); //Remove Token
        unset($request['id']); //Remove id

        if ($request->hasFile('image')) {
            $this->validate($request, [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:3048',
            ]);
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/user');
            $image->move($destinationPath, $image_name);
            $request->request->add(['profile_pic' => $image_name]);
            $data = $request->except('image');
            Session::put('profile_pic', $image_name);
        } else {
            $data = $request->all();
        }

        if ($request['password'] != null) {
            $data['password'] = Hash::make($request['password']);
        }else{

            unset($data['password']);
        }

        try {
            User::where('id', Auth::id())->update($data);
            return back()->with('success', "Profile Updated");
        } catch (\Exception $exception) {
            return back()->with('failed', $exception->getMessage());
        }

    }
}
