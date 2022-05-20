<?php

namespace App\Http\Controllers;

use App\District;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ModeratorController extends Controller
{

    public function create()
    {
        $districts = District::get();
        return view('pages.moderator.create')->with('districts', $districts);
    }


    public function store(Request $request)
    {
        unset($request['_token']); //Remove Token

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
        $request['user_type'] = 5;

        $is_exist = User::where('user_name', $request['user_name'])->first();
        if (!is_null($is_exist)) {
            return back()->with('failed', "Moderator name taken");
        }

        try {
            User::create($request->except('image'));
            return back()->with('success', "Moderator created");
        } catch (\Exception $exception) {
            return back()->with('failed', $exception->getMessage());
        }
    }


    public function show()
    {
        $result = User::where('user_type', 5)->get();//(Admin=1/Operator=2/Supplier=3/SupplierOperator=4, Moderator=5)

        return view('pages.moderator.show')->with('results', $result);
    }

    public function edit($id)
    {
        $result = User::where('id', $id)->first();//(Admin=1/Operator=2/Supplier=3/SupplierOperator=4)
        $districts = District::get();
        return view('pages.moderator.edit')->with('districts', $districts)->with('result', $result);

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


        try {
            User::where('id', $id)->update($request->all());
            return back()->with('success', "Agent Updated");
        } catch (\Exception $exception) {
            return back()->with('failed', $exception->getMessage());
        }
    }

    public function statusUpdate($user_id, $status)
    {

        try {
            User::where('id', $user_id)
                ->where('user_type', getModeratorId())
                ->update([
                    'is_active' => $status
                ]);
            return back()->with('success', "Agent Updated");
        } catch (\Exception $exception) {
            return back()->with('failed', $exception->getMessage());
        }
    }
}
