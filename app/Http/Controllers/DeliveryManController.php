<?php

namespace App\Http\Controllers;

use App\DeliveryMan;
use App\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use SimpleXLSX;

class DeliveryManController extends Controller
{
    public function createDeliveryMana()
    {

        $shop = null;
        if (Auth::user()->user_type == getSupplierId()) {
            $shop = Shop::where('user_id', Auth::user()->id)->get();
        }
        if (Auth::user()->user_type == getModeratorId()) {

            $shop = Shop::where('shops.district_id', Auth::user()->district_id)->get();
        }


        return view('supplier.deliveryman.create')->with('shops', $shop);
    }

    public function showDelivery()
    {

        $query = $result = DeliveryMan::
        leftJoin('districts', 'districts.district_id', '=', 'delivery_men.district_id')
            ->leftJoin('divisions', 'divisions.division_id', '=', 'delivery_men.division_id')
            ->leftJoin('upazilas', 'upazilas.upazila_id', '=', 'delivery_men.upazila_id')
            ->leftJoin('unions', 'unions.id', '=', 'delivery_men.union_id');
        if (Auth::user()->user_type == getModeratorId()) {

            $query->where('delivery_men.district_id', Auth::user()->district_id);

        }


        $result = $query->get([
            'delivery_men.delivery_man_id as delivery_man_id',
            'delivery_men.name as delivery_man_name',
            'delivery_men.phone as deliveryMan_phone',

            'divisions.en_name as division_name',
            'districts.en_name as district_name',
            'upazilas.en_name as upazila_name',
            'unions.en_name as union_name',
        ]);

        return view('supplier.deliveryman.show')->with('results', $result);
    }

    public function csvStore(Request $request)
    {

        if ($request->hasFile('csvfile')) {
            $xl_file = $request->file('csvfile');
            $file_name = "file" . time() . '.' . $xl_file->getClientOriginalExtension();
            $destinationPath = public_path('/file');
            $xl_file->move($destinationPath, $file_name);
        } else {
            $file_name = null;
        }

        $file = public_path('/file/' . $file_name);

        $division_id = $request['division'];
        $district_id = $request['district'];
        $upazila_id = $request['upazila'];
        $union_id = $request['union'];


        $errors = 0;
        $data = array();
        $success = 0;
        if ($xlsx = SimpleXLSX::parse($file)) {

            $i = 0;
            $message = 0;
            foreach ($xlsx->rows() as $row) {

                echo $row[0];


                if ($i > 0) {
                    $emp_array = [
                        'name' => $row[0],
                        'phone' => formatMydata($row[1]),
                        'division_id' => $division_id,
                        'district_id' => $district_id,
                        'upazila_id' => $upazila_id,
                        'union_id' => $union_id,
                        'supplier_id' => Auth::user()->id,
                        "created_at" => \Carbon\Carbon::now(), # new \Datetime()
                        "updated_at" => \Carbon\Carbon::now(),  # new \Datetime()

                    ];

                    $data[] = $emp_array;
                    $success++;
                }

                $i++;
            }
        }

        try {
            DeliveryMan::insert($data);

            return back()->with('success', "Successfully " . $success . " Entry Imported");
        } catch (\Exception $exception) {
            return back()->with('failed', $exception->getMessage());
        }


    }

    public function deliveryManaDelete($id)
    {

        try {
            DeliveryMan::where('delivery_man_id', $id)->delete();

            return back()->with('success', "Successfully Deleted");
        } catch (\Exception $exception) {
            return back()->with('failed', $exception->getMessage());
        }
    }

    public function edit($id)
    {
        return view('supplier.deliveryman.edit')
            ->with('result', DeliveryMan::where('delivery_man_id', $id)
                ->first());


    }

    public function store(Request $request)
    {
        return $request->all();

    }

    public function update(Request $request)
    {
        unset($request['_token']); //Remove Token
        $id = $request['id'];
        unset($request['id']); //Remove Token


        $emp_array = [
            'name' => $request['name'],
            'phone' => $request['phone'],
            'division_id' => $request['division'],
            'district_id' => $request['district'],
            'upazila_id' => $request['upazila'],
            'union_id' => $request['union'],
            'supplier_id' => Auth::user()->id,

        ];


        try {
            DeliveryMan::where('delivery_man_id', $id)->update($emp_array);
            return back()->with('success', "Profile Updated");
        } catch (\Exception $exception) {
            return back()->with('failed', $exception->getMessage());
        }
    }
}
