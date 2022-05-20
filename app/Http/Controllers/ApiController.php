<?php

namespace App\Http\Controllers;

use App\District;
use App\Division;
use App\OrderData;
use App\Shop;
use App\Union;
use App\Upazila;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    //

    public function getDivision()
    {
        $results = Division::get();
        return [
            'status_code' => 200,
            'message' => "Successfully Retrived",
            'results' => $results
        ];

    }

    public function getDistrict($division_id)
    {
        $results = District::where('division_id', $division_id)->get();
        return [
            'status_code' => 200,
            'message' => "Successfully Retrived",
            'results' => $results
        ];

    }

    public function getUpazila($district_id)
    {
        $results = Upazila::where('district_id', $district_id)->get();
        return [
            'status_code' => 200,
            'message' => "Successfully Retrived",
            'results' => $results
        ];
    }

    public function getUnion($id)
    {
        $results = Union::where('upazila_id', $id)->get();
        return [
            'status_code' => 200,
            'message' => "Successfully Retrived",
            'results' => $results
        ];
    }

    public function getSuppliers($area_type, $area_id, $service_type)
    {


        if ($area_type == "division") {

            $results = Shop::join('users', 'users.id', '=', 'shops.user_id')
                ->whereRaw("find_in_set($area_id,shops.division_id)")
                ->where('service_type', $service_type)
                ->where('shops.is_active', true)
                ->get();

            $i = 0;
            foreach ($results as $res) {

                if ($res->is_serve_in_depth == true) {

                    if ($res->coverage_depth != ucfirst($area_type)) {

                        unset($results[$i]);
                    }
                }

                $i++;
            }


        } else if ($area_type == "district") {
            $results = Shop:: join('users', 'users.id', '=', 'shops.user_id')
                ->whereRaw("find_in_set($area_id,shops.district_id)")
                ->where('service_type', $service_type)
                ->get();

            $i = 0;
            foreach ($results as $res) {

                if ($res->is_serve_in_depth == true) {

                    if ($res->coverage_depth != ucfirst($area_type)) {

                        unset($results[$i]);
                    }
                }

                $i++;
            }


        } else if ($area_type == "upazila") {


            $results = DB::table('shops')->join('users', 'users.id', '=', 'shops.user_id')
                ->whereRaw("find_in_set($area_id,shops.upazila_id)")
                ->where('service_type', $service_type)
                ->get();

            $i = 0;
            foreach ($results as $res) {

                if ($res->is_serve_in_depth == true) {

                    if ($res->coverage_depth != ucfirst($area_type)) {

                        //echo $res->coverage_depth . "--" . ucfirst($area_type);
                        unset($results[$i]);
                    }

                    //echo $res->coverage_depth . "--" . ucfirst($area_type) . "<br>";
                }

                $i++;
            }

        } else if ($area_type == "union") {

            $results = Shop:: join('users', 'users.id', '=', 'shops.user_id')
                ->whereRaw("find_in_set($area_id,shops.union_id)")
                ->where('service_type', $service_type)
                ->get();

            $i = 0;
            foreach ($results as $res) {

                if ($res->is_serve_in_depth == true) {

                    if ($res->coverage_depth != ucfirst($area_type)) {
                        //echo $res->coverage_depth . "<br>";
                        echo $area_type;

                        //unset( $results[$i]);
                    }
                }

                $i++;
            }


        } else {
            $results = Shop:: join('users', 'users.id', '=', 'shops.user_id')
                ->whereRaw("find_in_set($area_id,shops.district_id)")
                ->where('service_type', $service_type)
                ->get();

            $i = 0;
            foreach ($results as $res) {

                if ($res->is_serve_in_depth == true) {

                    if ($res->coverage_depth != ucfirst($area_type)) {

                        unset($results[$i]);
                    }
                }

                $i++;
            }
        }

        foreach ($results as $result) {

            $result->today_assigned = OrderData::where('shop_id', $result->shop_id)->where('status', getSupplierAssignedId("id"))/*->whereDate('created_at', Carbon::today())*/->count();
            $result->today_delivered = OrderData::where('shop_id', $result->shop_id)->where('status', 7)/*->whereDate('created_at', Carbon::today())*/->count();
            $result->today_cant_deliver = OrderData::where('shop_id', $result->shop_id)->where('status', 8)/*->whereDate('created_at', Carbon::today())*/->count();
            $result->today_cancelled = OrderData::where('shop_id', $result->shop_id)->where('status', 6)/*->whereDate('created_at', Carbon::today())*/->count();
        }


        return [
            'status_code' => 200,
            'message' => "Successfully Retrived",
            'results' => $results
        ];
    }

    public function checkShopCapacity($shop_id)
    {

        $is_available = true;

        $my_shop = Shop::where('shop_id', $shop_id)->first();
        $today_order = OrderData::where('shop_id', $shop_id)
            ->whereDate('created_at', Carbon::today())
            ->count();

        if ($my_shop->per_day_capacity < $today_order) {
            $is_available = false;
        }


        return [
            'status_code' => 200,
            'message' => "Successfully Retrived",
            'is_available' => $is_available
        ];


    }

    public function getStatuses($date)
    {


        if ($date == 420) {
            $total_order = \App\OrderData::count();
            $processed_order = \App\OrderData::whereNotIn('status', [1, 11])->count();
            $pending_order = \App\OrderData::where('status', 1)->count();
            $delivered_order = \App\OrderData::where('status', 7)->count();
            $tran = \App\OrderData::where('status', 14)->count();
            $volunteer_assigned = \App\OrderData::where('status', 4)->count();
            $cancelled_order = \App\OrderData::where('status', 9)->count();

        } else {
            $date = date('Y-m-d', strtotime(substr($date, 0, 10)));
            $date = date('Y-m-d', strtotime($date));
            $total_order = \App\OrderData::whereDate('created_at', $date)->count();

            $processed_order = \App\OrderData::whereDate('updated_at', $date)->whereNotIn('status', [1, 11])->count();
            $pending_order = \App\OrderData::whereDate('updated_at', $date)->where('status', 1)->count();
            $delivered_order = \App\OrderData::whereDate('updated_at', $date)->where('status', 7)->count();
            $tran = \App\OrderData::whereDate('updated_at', $date)->where('status', 14)->count();
            $volunteer_assigned = \App\OrderData::whereDate('updated_at', $date)->where('status', 4)->count();
            $cancelled_order = \App\OrderData::whereDate('updated_at', $date)->where('status', 9)->count();

        }

        return [
            'status_code' => 200,
            'message' => "Successfully Retrived",
            'total_order' => $total_order,
            'processed_order' => $processed_order,
            'pending_order' => $pending_order,
            'delivered_order' => $delivered_order,
            'tran' => $tran,
            'volunteer_assigned' => $volunteer_assigned,
            'cancelled_order' => $cancelled_order,
        ];


    }
}
