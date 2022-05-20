<?php

namespace App\Http\Controllers;

use App\Exports\OrdersExport;
use App\OrderData;
use App\OrderDataStatus;
use App\Shop;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{

    public function agentWiseReport()
    {


        return "jj";
    }

    public function statusWiseReport()
    {


        return "jj";
    }

    public function tranReport(Request $request)
    {

        $paginate = true;
        if ($request->method() == "GET") {
            $data = OrderData::where('status', 14)->paginate(25);
            $total = OrderData::where('status', 14)->count();
        } else {
            $from = $request['from'];
            $data = OrderData::where('status', 14)->whereDate('created_at', $from)->orderBy('created_at', 'DESC')
                ->get();
            $paginate = false;
            $total = count($data);
            //$data = OrderData::where('service_type', 6)->whereBetween('reservation_from', [$from, $to])->paginate(10);
        }


        return view('pages.report.tran')
            ->with('results', $data)
            ->with('total', $total)
            ->with('is_paginate', $paginate);


    }

    public function onlineUser(Request $request)
    {

        $total_online_user = User::where('updated_at', '>=', Carbon::now()->subMinutes(5)->toDateTimeString())->get();

        // $total_online_user = User::whereDate('updated_at', Carbon::today())->get();


        $is_paginate = true;
        return view('pages.report.online_user')
            ->with('is_paginate', $is_paginate)
            ->with('results', $total_online_user);


    }

    public function orderReport(Request $request)
    {
        if ($request->isMethod('post')) {
            //$results = OrderData::where('status', $request['status'])->get();

            $data = OrderData::leftJoin('divisions', 'divisions.division_id', '=', 'order_datas.division_id')
                ->leftJoin('districts', 'districts.district_id', '=', 'order_datas.district_id')
                ->leftJoin('upazilas', 'upazilas.upazila_id', '=', 'order_datas.upazila_id')
                ->leftJoin('unions', 'unions.id', '=', 'order_datas.union_id')
                ->select('order_datas.*',
                    'divisions.en_name as division_id',
                    'districts.en_name as district_id',
                    'upazilas.en_name as upazila_id',
                    'unions.en_name as union_id'
                )
                ->where('status', $request['status'])
                ->get();

            foreach ($data as $d) {
                $d->updated_by = getSupplierNameFromId($d->updated_by);
                $d->status = getStatusName($d->status);
                $d->service_type = getServiceFromId($d->service_type);
            }

            $data = $data->toArray();;


            $export = new OrdersExport($data);

            return Excel::download($export, 'report' . date('d_m_y') . '.xlsx');


        } else {
            return view('pages.report.order_report')->with('results', []);
        }

        return view('pages.report.order_report')->with('results', $results);
    }


    public function shopReport(Request $request)
    {
        if ($request->isMethod('post')) {
            //$results = OrderData::where('status', $request['status'])->get();

            $query = Shop::join('users', 'users.id', 'shops.user_id')
                ->orderBy('shops.updated_at', 'desc')
                ->select('shops.*', 'users.name', 'users.phone');

            if ($request['division'] != null) {
                $query->where('shops.division_id', $request['division']);
            }
            if ($request['district'] != null) {
                $query->where('shops.district_id', $request['district']);
            }
            if ($request['upazila'] != null) {
                $query->where('shops.upazila_id', $request['upazila']);
            }
            if ($request['union'] != null) {
                $query->where('shops.union_id', $request['union']);
            }

            $result = $query->
            leftJoin('divisions', 'divisions.division_id', '=', 'shops.division_id')
                ->leftJoin('districts', 'districts.district_id', '=', 'shops.district_id')
                ->leftJoin('upazilas', 'upazilas.upazila_id', '=', 'shops.upazila_id')
                ->leftJoin('unions', 'unions.id', '=', 'shops.union_id')
                ->select('shops.*',
                    'divisions.en_name as division_id',
                    'districts.en_name as district_id',
                    'upazilas.en_name as upazila_id',
                    'unions.en_name as union_id'
                )
                ->get();

            foreach ($result as $d) {

                $d->service_type = getServiceFromId($d->service_type);
                $d->user_id = gettingUsernameFromId($d->user_id);
            }

            $data = $result->toArray();;


            $export = new OrdersExport($data);

            return Excel::download($export, 'report' . date('d_m_y') . '.xlsx');


        } else {
            return view('pages.report.shop_report')->with('results', []);
        }

        return view('pages.report.shop_report')->with('results', $results);
    }

    public function agentReport($id, Request $request)
    {

        if ($request->method() == "GET") {
            $data = OrderDataStatus::selectRaw('date(created_at) date, count(distinct(order_id)) count')
                ->groupBy('date')
                ->where('user_id', $id)
                ->whereMonth('created_at', date('m'))
                ->get();

            $month = date('m');
        } else {
            $data = OrderDataStatus::selectRaw('date(created_at) date, count(distinct(order_id)) count')
                ->groupBy('date')
                ->where('user_id', $id)
                ->whereMonth('created_at', date($request['month']))
                ->get();
            $month = date($request['month']);

        }

        return view('pages.report.agent_report')
            ->with('results', $data)
            ->with('id', $id)
            ->with('month', $month)
            ->with('is_paginate', true);


    }

    public function allAgentReport(Request $request)
    {

        /*   $datas = OrderDataStatus::select('user_id')->groupBy('user_id')->get();
                   foreach ($datas as $data){
                       $data['count']=OrderDataStatus::where('user_id', $data->user_id)->count();
                   }*/


        if ($request->method() == "GET") {
            $data = OrderDataStatus::selectRaw('user_id, count(distinct(order_id)) count')->whereNotIn('status_id', [2])->groupBy('user_id')->orderBy('count', 'DESC')->get();
            $status = "All";
        } else {


            $query = OrderDataStatus::selectRaw('user_id, count(distinct(order_id)) count')->groupBy('user_id')->orderBy('count', 'DESC');
            /*  if ($request['status_id'] != null) {
                  $query->where('status_id', $request['status_id']);
              }*/
            if ($request['from'] == $request['to']) {
                $query->whereDate('created_at', $request['from']);
            } else {
                $query->whereBetween('created_at', [$request['from'], $request['to']]);
            }

            $data = $query->whereNotIn('status_id', [2])->get();

            $status = getStatusName($request['status_id']);
        }
        return view('pages.report.all_agent_report')
            ->with('results', $data)
            ->with('status', $status)
            ->with('is_paginate', true);


    }
}
