<?php

namespace App\Http\Controllers;

use App\DeliveryMan;
use App\LoginHistory;
use App\OrderData;
use App\Shop;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class SupplierController extends Controller
{


    public function store(Request $request)
    {


        $result = Shop::where('shop_id', $request['shop_id'])->first();
        if (!is_null($result)) {
            $my_array = [
                'name' => $request['name'],
                'phone' => $request['phone'],
                'division_id' => $result->division_id,
                'district_id' => $result->district_id,
                'upazila_id' => $result->upazila_id,
                'union_id' => $result->union_id,
                'address' => $result->address,
            ];
            try {

                DeliveryMan::create($my_array);
                return back()->with('success', "Successfully Saved ");
            } catch (\Exception $exception) {
                return back()->with('failed', $exception->getMessage());
            }

        }


    }


    public function dashboard()
    {

        $is_incomplete = Shop::where('user_id', Auth::user()->id)->whereNull('address')->count();
        $is_nid_incomplete = User::where('id', Auth::user()->id)->whereNull('nid')->count();

        $shop_count = Shop::where('user_id', Auth::user()->id)->count();
        $shops = Shop::where('user_id', Auth::user()->id)->get();
        $shop_list = [];
        foreach ($shops as $shop) {
            $shop_list[] = $shop->shop_id;
        }

        $total_order = OrderData::whereIn('shop_id', $shop_list)
            ->count();
        $pending_order = OrderData::whereIn('shop_id', $shop_list)
            ->where('status', "Pending")
            ->count();


        return view('supplier.home.index')
            ->with('is_complete', $is_incomplete)
            ->with('is_nid_incomplete', $is_nid_incomplete)
            ->with('shop_count', $shop_count)
            ->with('total_order', $total_order)
            ->with('pending_order', $pending_order)
            ->with('histories', $login_histories = LoginHistory::
            join('users', 'users.id', '=', 'login_histories.user_id')
                ->where('login_histories.user_id', Auth::user()->id)
                ->orderBy('login_histories.created_at', 'DESC')
                ->select(
                    'login_histories.ip_address',
                    'login_histories.created_at',
                    'users.name',
                    'users.profile_pic'
                )->simplePaginate(5));
    }


    public function orders()
    {
        $shops = Shop::where('user_id', Auth::user()->id)->get();
        if (count($shops) > 0) {

            return Redirect::to('/supplier/shop/' . $shops[0]->shop_id);

        } else {

            return back()->with('failed', "You do not have Any shop");
        }

    }

    public function orderByStatus($status)
    {
        $shops = [];
        $delivermans = [];

        if (Auth::user()->user_type == getModeratorId()) {

            $results = OrderData::where('district_id', Auth::user()->district_id)->
            orderBy('updated_at', 'DESC')->where('status', getStatusIdFromName($status))->paginate(15);
            return view('supplier.orders.index')
                ->with('shops', $shops)
                ->with('delivermans', $delivermans)
                ->with('result', $results);

        }
    }

    public function filteredOrder($shop_id)
    {

        $shops = [];
        $delivermans = [];

        if (Auth::user()->user_type == getModeratorId()) {

            $results = OrderData::where('district_id', Auth::user()->district_id)
                ->orderBy('updated_at', 'DESC')
                ->whereIn('status', [4, 5, 6, 7, 8])
                ->paginate(15);

            return view('supplier.orders.index')
                ->with('shops', $shops)
                ->with('delivermans', $delivermans)
                ->with('result', $results);

        }

        $shops = Shop::where('user_id', Auth::user()->id)->get();
        $delivermans = DeliveryMan::get();

        $shop_list = [];
        foreach ($shops as $shop) {
            $shop_list[] = $shop->shop_id;
        }
        if ($shop_id != "All") {
            $is_athenticate = Shop::where('user_id', Auth::user()->id)
                ->where('shop_id', $shop_id)
                ->first();
            if (is_null($is_athenticate)) {
                return Redirect::to('/supplier/shop/All')->with('failed', "You are not authenticated");
            }
        }


        //Todo::auth check
        if ($shop_id == "All") {
            $results = OrderData::whereIn('shop_id', $shop_list)->paginate(15);


        } else {
            $results = OrderData::where('shop_id', $shop_id)->paginate(15);

        }


        return view('supplier.orders.index')
            ->with('shops', $shops)
            ->with('delivermans', $delivermans)
            ->with('result', $results);


    }

    public function orderSearch(Request $request)
    {

        $shops = [];
        $delivermans = [];
        if (Auth::user()->user_type == getModeratorId()) {

            $results = OrderData::where('district_id', Auth::user()->district_id)
                ->where('phone', 'LIKE', '%' . $request['phone'] . '%')
                ->orderBy('updated_at', 'DESC')
                ->paginate(15);
            return view('supplier.orders.index')
                ->with('shops', $shops)
                ->with('delivermans', $delivermans)
                ->with('result', $results);
        }

        $shops = Shop::where('user_id', Auth::user()->id)->get();
        $delivermans = DeliveryMan::get();

        $shop_list = [];
        foreach ($shops as $shop) {
            $shop_list[] = $shop->shop_id;
        }
        //Todo::auth check

        $results = OrderData::whereIn('shop_id', $shop_list)
            ->where('phone', 'LIKE', '%' . $request['phone'] . '%')
            ->paginate(15);

        return view('supplier.orders.index')
            ->with('shops', $shops)
            ->with('delivermans', $delivermans)
            ->with('result', $results);


    }


    public function show($status)
    {
        if ($status == "All") {
            $result = OrderData::orderBy('created_at', 'DESC')->get();
        } else {
            $result = OrderData::where('status', getStatusIdFromName($status))->get();
        }

        return view('supplier.orders.index')
            ->with('result', $result);

    }


    public function orderUpdate(Request $request)
    {

        //return $request['order_id'];
        $order_id = $request['order_id'];
        unset($request['_token']);
        unset($request['order_id']);

        //return $request->all();

        try {
            OrderData::where('order_id', $order_id)->update($request->all());

            return back()->with('success', "Successfully Product Updated");
        } catch (\Exception $exception) {
            return back()->with('failed', $exception->getMessage());
        }
    }


    public function updateOrderStatus($order_id, $status)
    {

        try {
            OrderData::where('order_id', $order_id)->update([
                "status" => $status
            ]);

            return back()->with('success', "Successfully Product Updated");
        } catch (\Exception $exception) {
            return back()->with('failed', $exception->getMessage());
        }
    }

    public function assignDeliveryMan(Request $request)
    {
        try {
            OrderData::where('order_id', $request['order_id'])->update([
                "delivery_man_id" => $request['delivery_man_id'],
                "status" => getStatusIdFromName("Accept"),
            ]);

            return back()->with('success', "Successfully Product Updated");
        } catch (\Exception $exception) {
            return back()->with('failed', $exception->getMessage());
        }
    }

    public function shopSearch(Request $request)
    {


        return Redirect::to('/supplier/shop/' . $request['shop_id']);
    }
}