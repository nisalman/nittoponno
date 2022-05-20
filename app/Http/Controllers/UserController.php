<?php

namespace App\Http\Controllers;

use App\OrderData;
use App\Shop;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use SimpleXLSX;

class UserController extends Controller
{


    public function create()
    {
        return view('pages.user.create');
    }


    public function store(Request $request)
    {

        unset($request['_token']); //Remove Token
        $my_password = $request['password'];

        /*if ($request->hasFile('image')) {
            $this->validate($request, [
                'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:3048',
            ]);
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/user');
            $image->move($destinationPath, $image_name);
        } else {
            $image_name = $request['image'];
        }*/

        $request['password'] = Hash::make($request['password']);


        try {
            User::create($request->except('image'));
            sendSms2($request['phone'], supplierAccountCreationMessage($request['user_name'], $my_password));

            return back()->with('success', "User created");
        } catch (\Exception $exception) {
            return back()->with('failed', $exception->getMessage());
        }
    }

    public function csvStore(Request $request)
    {

        $password = Hash::make("123456");

        if ($request->hasFile('csvfile')) {
            $xl_file = $request->file('csvfile');
            $file_name = "file" . time() . '.' . $xl_file->getClientOriginalExtension();
            $destinationPath = public_path('/file');
            $xl_file->move($destinationPath, $file_name);
        } else {
            $file_name = null;
        }

        $file = public_path('/file/' . $file_name);


        $errors = 0;
        $data = array();
        $success = 0;

        if ($xlsx = SimpleXLSX::parse($file)) {

            $i = 0;
            $message = 0;
            foreach ($xlsx->rows() as $row) {


                if ($i > 0) {
                    $emp_array = [
                        'name' => $row[1],
                        'phone' => formatMydata($row[2]),
                        'user_name' => generateUsername(formatMydata($row[2])),
                        'user_type' => getSupplierId(),
                        'password' => $password,
                        "created_at" => \Carbon\Carbon::now(), # new \Datetime()
                        "updated_at" => \Carbon\Carbon::now(),  # new \Datetime()
                        "is_active" => true
                    ];

                    //TODO::Insert INTO User table (Supplier)
                    try {
                        $id = User::insertGetId($emp_array);

                    } catch (\Exception $exception) {
                        $message = $exception->getMessage();
                    }

                    //TODO::Insert INTO Shop table (Supplier SHOP)
                    try {

                        $success++;
                        $shops[] = array();
                        $values = $row[3];
                        if (strpos($values, ',') !== false) {
                            $mark = explode(',', $values);//what will do here
                            foreach ($mark as $out) {

                                $shop_data = [
                                    'user_id' => $id,
                                    'service_type' => getServiceFromName(trim($out)),
                                    'per_day_capacity' => $row[4],
                                    'shop_phone' => formatMydata($row[5]),
                                    'coverage_depth' => $row[6],
                                    'division_id' => getDivisionIdFromName($row[7]),
                                    'district_id' => getDistrictIdFromName($row[8]),
                                    'upazila_id' => getUpazilaIdFromName($row[9]),
                                ];
                                Shop::insert($shop_data);

                            }
                        } else {

                            $shop_data = [
                                'user_id' => $id,
                                'service_type' => getServiceFromName(trim($values)),
                                'per_day_capacity' => $row[4],
                                'shop_phone' => formatMydata($row[5]),
                                'coverage_depth' => $row[6],
                                'division_id' => getDivisionIdFromName($row[7]),
                                'district_id' => getDistrictIdFromName($row[8]),
                                'upazila_id' => getUpazilaIdFromName($row[9]),
                            ];

                            Shop::insert($shop_data);
                        }


                    } catch (\Exception $exception) {
                        return $message = $exception->getMessage();
                    }
                }
                $i++;
            }
        }
        return back()->with('success', "Successfully " . $success . " Shop Imported. ");

    }

    public function show()
    {

        $user_list = [];
        $shops = Shop::where('district_id', Auth::user()->district_id)->get();
        foreach ($shops as $shop) {
            $user_list[] = $shop->user_id;
        }

        $query = User::where('user_type', getSupplierId());
        if (Auth::user()->user_type == getModeratorId()) {
            $query->whereIn('id', $user_list);
        }

        $result = $query->orderBy('created_at', 'DESC')->paginate(10);


        return view('pages.user.show')->with('results', $result);
    }

    public function supplierSearch(Request $request)
    {

        $user_list = [];
        $shops = Shop::where('district_id', Auth::user()->district_id)->get();
        foreach ($shops as $shop) {
            $user_list[] = $shop->user_id;
        }

        $query = User::where('user_type', getSupplierId());
        if (Auth::user()->user_type == getModeratorId()) {
            $query->whereIn('id', $user_list);
        }

        $result = $query->where('phone', 'LIKE', '%' . $request['phone'] . '%')->paginate(15);
        // dd($result);
        return view('pages.user.show')->with('results', $result);
    }


    public function supplierAllOrder($user_id)
    {
        $shop_array = [];
        $shops = Shop::where('user_id', $user_id)->get();
        foreach ($shops as $shop) {
            $shop_array[] = $shop->shop_id;
        }
        $result = OrderData::whereIn('shop_id', $shop_array)->get();

        return view('pages.user.all_order')
            ->with('user_id', $user_id)
            ->with('results', $result);
    }


    public function accountActivate()
    {
        $result = User:: where('users.authority_id', Session::get('id'))->get();

        if (Session::get('designation') == "DC/AC") {
            $unseen_notifications = \App\Leave::join('users', 'users.id', '=', 'leaves.user_id')
                ->where('users.authority_id', Session::get('id'))
                ->where('leaves.grant_officers_decision', 0)
                ->get();

        } elseif (Session::get('designation') == "Commissioner"
            OR Session::get('designation') == "ADC/JC") {
            $unseen_notifications = \App\Leave::join('users', 'users.id', '=', 'leaves.user_id')
                ->where('leaves.grant_officers_decision', 0)
                ->get();
        } else {
            $unseen_notifications = null;
        }
        $unseen_replacement_notifications = \App\Leave::join('users', 'users.id', '=', 'leaves.replacement_person_id')->where('leaves.replacement_person_id', Session::get('id'))->where('replacement_person_agreement', 0)->get();

        return view('pages.user.show')->with('result', $result)
            ->with('unseen_notifications', $unseen_notifications)
            ->with('unseen_replacement_notifications', $unseen_replacement_notifications);
    }

    public function edit($id)
    {
        //Check Moderator Have edit Access
        $user_list = [];
        $shops = Shop::where('district_id', Auth::user()->district_id)->get();
        foreach ($shops as $shop) {
            $user_list[] = $shop->user_id;
        }

        $query = User::where('user_type', getSupplierId());
        if (Auth::user()->user_type == getModeratorId()) {
            $query->whereIn('id', $user_list);
        }

        $result = $query->where('id', $id)
            ->first();
        if (is_null($result)) {

            return Redirect::to('/admin/suppliers')->with('failed', 'You don not have permission to edit this user');

        }


        return view('pages.user.edit')
            ->with('result', $result);


    }

    public function update(Request $request)
    {
        unset($request['_token']); //Remove Token
        $id = $request['id'];
        unset($request['id']); //Remove id

        if ($request['password'] != null) {
            $request['password'] = Hash::make($request['password']);
        } else {

            unset($request['password']);
        }


        /*  $is_exist=User::where('id',$id)->where('user_name',$request['user_name'])->first();
          if(!is_null($is_exist)){
              return back()->with('failed', "Username Not Available");
          }*/
        try {
            User::where('id', $id)->update($request->all());
            return back()->with('success', "Profile Updated");
        } catch (\Exception $exception) {
            return back()->with('failed', $exception->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            User::where('id', $id)->delete();
            return back()->with('success', "User Deleted");
        } catch (\Exception $exception) {
            return back()->with('failed', $exception->getMessage());
        }
    }

    public function deactivate($id)
    {
        try {
            User::where('id', $id)->update(['active_status' => 2]);
            return back()->with('success', "User Deactivated");
        } catch (\Exception $exception) {
            return back()->with('failed', $exception->getMessage());
        }
    }

    public function activate($id)
    {
        try {
            User::where('id', $id)->update(['active_status' => 1]);
            return back()->with('success', "User Activated");
        } catch (\Exception $exception) {
            return back()->with('failed', $exception->getMessage());
        }
    }

    public function statusUpdate($user_id, $status)
    {

        try {
            Shop::where('user_id', $user_id)->update([
                'is_active' => $status
            ]);

            User::where('id', $user_id)
                ->where('user_type', getSupplierId())
                ->update([
                    'is_active' => $status
                ]);


            return back()->with('success', "Changed");
        } catch (\Exception $exception) {
            return back()->with('failed', $exception->getMessage());
        }
    }
}
