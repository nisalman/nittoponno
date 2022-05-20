<?php

namespace App\Http\Controllers;

use App\District;
use App\Shop;
use App\Union;
use App\Upazila;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class ShopController extends Controller
{

    public function index()
    {
        //
    }


    public function create($user_id)
    {


        return view('pages.shop.create')
            ->with('user_id', $user_id)
            ->with('user', User::where('id', $user_id)->first());
    }


    public function store(Request $request)
    {

        $user_id = $request['user_id'];
        if ($request['division'] == null) {
            return back()->with('failed', "Divison can not be null");
        }


        if ($request['coverage_depth'] == "Division") {

            $shop_array = [
                'service_type' => $request['service_type'],
                'shop_name' => $request['shop_name'],
                'per_day_capacity' => $request['per_day_capacity'],
                'coverage_depth' => $request['coverage_depth'],
                'division_id' => $request['division'],

                'address' => $request['address'],
                'user_id' => $user_id
            ];
        } else if ($request['coverage_depth'] == "District") {

            $district_list = null;
            if ($request['district_list'] != null) {
                foreach ($request['district_list'] as $district) {

                    $district_list = $district_list . "," . $district;
                }
            } else {
                $results = District::where('division_id', $request['division'])->get(['district_id']);
                foreach ($results as $district) {

                    $district_list = $district_list . "," . $district->district_id;
                }

            }

            if (strlen($district_list) > 0) {
                $district_list = substr($district_list, 1);
            }

            $shop_array = [
                'service_type' => $request['service_type'],
                'shop_name' => $request['shop_name'],
                'per_day_capacity' => $request['per_day_capacity'],
                'coverage_depth' => $request['coverage_depth'],
                'division_id' => $request['division'],
                'district_id' => $district_list,

                'address' => $request['address'],
                'user_id' => $user_id
            ];
        } else if ($request['coverage_depth'] == "Upazila") {

            $upazila_list = null;
            if ($request['upazila_list'] != null) {
                foreach ($request['upazila_list'] as $upazila) {

                    $upazila_list = $upazila_list . "," . $upazila;
                }
            } else {
                $results = Upazila::where('district_id', $request['district'])->get(['upazila_id']);
                foreach ($results as $upazila) {
                    $upazila_list = $upazila_list . "," . $upazila->upazila_id;
                }

            }

            if (strlen($upazila_list) > 0) {
                $upazila_list = substr($upazila_list, 1);
            }

            $shop_array = [
                'service_type' => $request['service_type'],
                'shop_name' => $request['shop_name'],
                'per_day_capacity' => $request['per_day_capacity'],
                'shop_phone' => $request['shop_phone'],
                'coverage_depth' => $request['coverage_depth'],
                'division_id' => $request['division'],
                'district_id' => $request['district'],
                'upazila_id' => $upazila_list,
                'address' => $request['address'],
                'user_id' => $user_id
            ];
        } else if ($request['coverage_depth'] == "Union") {

            $union_list = null;
            if ($request['union_list'] != null) {
                foreach ($request['union_list'] as $union) {

                    $union_list = $union_list . "," . $union;
                }
            } else {
                $results = Union::where('upazila_id', $request['upazila'])->get(['id']);
                foreach ($results as $union) {
                    $union_list = $union_list . "," . $union->id;
                }

            }
            if (strlen($union_list) > 0) {
                $union_list = substr($union_list, 1);
            }


            $shop_array = [
                'service_type' => $request['service_type'],
                'shop_name' => $request['shop_name'],
                'per_day_capacity' => $request['per_day_capacity'],
                'coverage_depth' => $request['coverage_depth'],
                'division_id' => $request['division'],
                'district_id' => $request['district'],
                'upazila_id' => $request['upazila'],
                'union_id' => $union_list,
                'address' => $request['address'],
                'user_id' => $user_id
            ];
        }

        if ($request['is_serve_in_depth'] == 1) {
            $shop_array['is_serve_in_depth'] = $request['is_serve_in_depth'];
        }

        if ($request['is_serve_in_depth'] == null) {
            $shop_array['is_serve_in_depth'] = false;
        }


        try {

            Shop::create($shop_array);
        } catch (\Exception $exception) {

            return back()->with('failed', $exception->getMessage());
        }

        return Redirect::to('/admin/shops/' . $request['user_id'])->with('success', "Successfully saved");

    }


    public function show($user_id)
    {
        $result = null;
        if ($user_id != null) {
            $result = Shop::join('users', 'users.id', 'shops.user_id')
                ->orderBy('shops.updated_at', 'desc')
                ->where('shops.user_id', $user_id)
                ->select('shops.*', 'users.name', 'users.nid', 'users.id', 'users.phone')
                ->orderBy('created_at', 'DESC')
                ->paginate(15);// Supplier=4
        }


        return view('pages.shop.show')
            ->with('user_id', $user_id)
            ->with('results', $result);
    }

    public function allShop(Request $request)
    {

        if ( $request->isMethod('post')) {

            $query = Shop::join('users', 'users.id', 'shops.user_id')
                ->orderBy('shops.updated_at', 'desc')
                ->select('shops.*', 'users.name', 'users.nid', 'users.id', 'users.phone');

            if($request['division']!=null){
                $query->where('shops.division_id', $request['division']);
            }
            if($request['district']!=null){
                $query->where('shops.district_id', $request['district']);
            }
            if($request['upazila']!=null){
                $query->where('shops.upazila_id', $request['upazila']);
            }
            if($request['union']!=null){
                $query->where('shops.union_id', $request['union']);
            }

            $result = $query->paginate(15);
            return view('pages.shop.show')
                ->with('results', $result);
        }
        $query = Shop::join('users', 'users.id', 'shops.user_id')
            ->orderBy('shops.updated_at', 'desc')
            ->select('shops.*', 'users.name', 'users.nid', 'users.id', 'users.phone');

        if (Auth::user()->user_type == getSupplierId()) {

            $query->where('user_id', Auth::user()->id);
        } elseif (Auth::user()->user_type == getModeratorId()) {
            $query->where('shops.district_id', Auth::user()->district_id);
        }
        $result = $query->paginate(15);

        return view('pages.shop.show')
            ->with('results', $result);


        /*        $result = Shop::chunk(500, function ($results) {
                    // your logic
                    return $results;
                });*/
    }


    public function shopSearch(Request $request)
    {

        $query = Shop::join('users', 'users.id', 'shops.user_id')
            ->orderBy('shops.updated_at', 'desc')
            ->select('shops.*', 'users.name', 'users.nid', 'users.id', 'users.phone');

        if (Auth::user()->user_type == getSupplierId()) {

            $query->where('user_id', Auth::user()->id);
        } elseif (Auth::user()->user_type == getModeratorId()) {
            $query->where('shops.district_id', Auth::user()->district_id);
        }
        $result = $query->where('users.phone', 'LIKE', '%' . $request['phone'] . '%')
            ->paginate(15);

        return view('pages.shop.show')
            ->with('results', $result);

    }


    public function edit($id)
    {
        $query = Shop::join('users', 'users.id', 'shops.user_id')
            ->orderBy('shops.updated_at', 'desc')
            ->select('shops.*', 'users.name', 'users.nid', 'users.id', 'users.phone');

        if (Auth::user()->user_type == getSupplierId()) {

            $query->where('user_id', Auth::user()->id);
        } elseif (Auth::user()->user_type == getModeratorId()) {
            $query->where('shops.district_id', Auth::user()->district_id);
        }



        $data = $query->where('shop_id', $id)->first();
        if(is_null($data)){
            return Redirect::to('/admin/shops')->with('failed', "You do not have permission to edit this shop");
        }
        return view('pages.shop.edit')->with('shop', $data);
    }


    public function update(Request $request)
    {

        if ($request['division'] == null) {
            return back()->with('failed', "Divison can not be null");
        }


        if ($request['coverage_depth'] == "Division") {

            $shop_array = [
                'service_type' => $request['service_type'],
                'shop_name' => $request['shop_name'],
                'shop_phone' => $request['shop_phone'],
                'per_day_capacity' => $request['per_day_capacity'],
                'coverage_depth' => $request['coverage_depth'],
                'division_id' => $request['division'],

                'district_id' => null,
                'upazila_id' => null,
                'union_id' => null,
                'address' => $request['address'],

            ];
        } else if ($request['coverage_depth'] == "District") {

            $district_list = null;
            if ($request['district_list'] != null) {
                foreach ($request['district_list'] as $district) {

                    $district_list = $district_list . "," . $district;
                }
            } else {
                $results = District::where('division_id', $request['division'])->get(['district_id']);
                foreach ($results as $district) {

                    $district_list = $district_list . "," . $district->district_id;
                }

            }

            if (strlen($district_list) > 0) {
                $district_list = substr($district_list, 1);
            }

            $shop_array = [
                'service_type' => $request['service_type'],
                'shop_name' => $request['shop_name'],
                'shop_phone' => $request['shop_phone'],
                'per_day_capacity' => $request['per_day_capacity'],
                'coverage_depth' => $request['coverage_depth'],
                'division_id' => $request['division'],
                'district_id' => $district_list,
                'upazila_id' => null,
                'union_id' => null,
                'address' => $request['address'],
            ];
        } else if ($request['coverage_depth'] == "Upazila") {

            $upazila_list = null;
            if ($request['upazila_list'] != null) {
                foreach ($request['upazila_list'] as $upazila) {

                    $upazila_list = $upazila_list . "," . $upazila;
                }
            } else {
                $results = Upazila::where('district_id', $request['district'])->get(['upazila_id']);
                foreach ($results as $upazila) {
                    $upazila_list = $upazila_list . "," . $upazila->upazila_id;
                }

            }

            if (strlen($upazila_list) > 0) {
                $upazila_list = substr($upazila_list, 1);
            }

            $shop_array = [
                'service_type' => $request['service_type'],
                'shop_name' => $request['shop_name'],
                'shop_phone' => $request['shop_phone'],
                'per_day_capacity' => $request['per_day_capacity'],
                'coverage_depth' => $request['coverage_depth'],
                'division_id' => $request['division'],
                'district_id' => $request['district'],
                'upazila_id' => $upazila_list,
                'union_id' => null,
                'address' => $request['address'],
            ];
        } else if ($request['coverage_depth'] == "Union") {

            $union_list = null;
            if ($request['union_list'] != null) {
                foreach ($request['union_list'] as $union) {

                    $union_list = $union_list . "," . $union;
                }
            } else {
                $results = Union::where('upazila_id', $request['upazila'])->get(['id']);
                foreach ($results as $union) {
                    $union_list = $union_list . "," . $union->id;
                }

            }
            if (strlen($union_list) > 0) {
                $union_list = substr($union_list, 1);
            }


            $shop_array = [
                'service_type' => $request['service_type'],
                'shop_name' => $request['shop_name'],
                'shop_phone' => $request['shop_phone'],
                'per_day_capacity' => $request['per_day_capacity'],
                'coverage_depth' => $request['coverage_depth'],
                'division_id' => $request['division'],
                'district_id' => $request['district'],
                'upazila_id' => $request['upazila'],
                'union_id' => $union_list,
                'address' => $request['address'],
            ];
        }

        if ($request['is_serve_in_depth'] == 1) {
            $shop_array['is_serve_in_depth'] = $request['is_serve_in_depth'];
        }

        if ($request['is_serve_in_depth'] == null) {
            $shop_array['is_serve_in_depth'] = false;
        }


        try {

            Shop::where('shop_id', $request['shop_id'])->update($shop_array);
        } catch (\Exception $exception) {

            return back()->with('failed', $exception->getMessage());
        }

        return back()->with('success', "Successfully Updated");
    }


    public function shopStatusUpdate($shop_id, $status)
    {

        try {

            Shop::where('shop_id', $shop_id)->update([
                'is_active' => $status
            ]);

            return back()->with('success', "Shop Updated");
        } catch (\Exception $exception) {

            return back()->with('failed', $exception->getMessage());
        }
    }
}
