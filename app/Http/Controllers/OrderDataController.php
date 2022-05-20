<?php

namespace App\Http\Controllers;

use App\OrderData;
use App\OrderDataStatus;
use App\Shop;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use SimpleXLSX;
use DB;
class OrderDataController extends Controller
{

    public function edit($order_id)
    {
        $result = OrderData::where('order_id', $order_id)->first();

        $area_type = "";
        $area_id = "";
        if ($result->union_id !== null) {
            $area_type = "union";
            $area_id = $result->union_id;
        }
        if ($result->upazila_id !== null) {
            $area_type = "upazila";
            $area_id = $result->upazila_id;
        }
        if ($result->district_id !== null) {
            $area_type = "district";
            $area_id = $result->district_id;
        }
        if ($result->division !== null) {
            $area_type = "division";
            $area_id = $result->division_id;
        }

        return view('pages.order.edit')
            ->with('order_id', $order_id)
            ->with('area_type', $area_type)
            ->with('area_id', $area_id)
            ->with('result', $result);


        return view('pages.order.edit')->with('res', $result);
    }

       public function test()
    {
       return $user = DB::table('order_datas')
            ->whereBetween('created_at', ['2021-04-04', '2021-05-07'])
            ->where('status', '!=', '1')
            ->count();
    }

    public function update(Request $request)
    {

        //Update as Tran
        if ($request['is_tran']) {
            $data = [
                'status' => 14,  //Status as Tran
                'shop_id' => null,
                'product_list' => $request['product_list'],
                'name' => $request['name'],
                'phone' => $request['phone'],
                'service_type' => 6,//Tran

                'division_id' => $request['division'],
                'district_id' => $request['district'],
                'upazila_id' => $request['upazila'],
                'union_id' => $request['union'],
                'delivery_address' => $request['address'],
                'admin_remarks' => $request['admin_remarks'],
                'delivery_man_id' => null,
                'updated_by' => Auth::id()
            ];


            try {
                OrderData::where('order_id', $request['order_id'])->update($data);
                $this->trackRecord($request['order_id'], 14);
                return Redirect::to('/admin/order-request-view')->with('success', "Updated as Relief");

            } catch (\Exception $exception) {

                return back()->with('success', $exception->getMessage());
                return Redirect::to('/admin/orders/Pending')->with('failed', $exception->getMessage());
            }
        }


        $sms_sent_status = true;
        $return_message = "Successfully Assigned";
        $status = getStatusIdFromName("Supplier Assigned");
        if ($request['is_supplier_available'] == false) {
            $status = getStatusIdFromName("Supplier Not Found");
            $return_message = "Without Supplier Updated";
            $request['supplier_id'] = null;
            $sms_sent_status = false;
        }


        $customer = OrderData::where('order_id', $request['order_id'])->first();

        $supplier_name = null;
        $supplier_phone = null;
        if ($request['supplier_id'] == null) {
            $status = getStatusIdFromName("Supplier Not Found");
            $return_message = "Without Supplier Updated";
        } else {
            //getting supplier Name
            $supplier = Shop::
            leftJoin('users', 'users.id', '=', 'shops.user_id')
                ->where('shop_id', $request['supplier_id'])
                ->first();


            if ($supplier->shop_phone != null) {
                $supplier_phone = $supplier->shop_phone;
            } else {
                $supplier_phone = $supplier->phone;
            }
            $supplier_name = $supplier->name;
        }

        if ($request['is_cancelled'] == true) {
            $status = getStatusIdFromName("Cancel Order");
            $return_message = "Order Cancelled";
            $sms_sent_status = false;
            //$data = OrderData::where('order_id', $request['order_id'])->first();
            //sendSms2($request['phone'], getRetryMessage($data->invoice_number));
            //sendSms2($supplier_phone, getRetryMessage($data->invoice_number));
        }


        $data = [

            'status' => $status,  //Supplier Assigned
            'shop_id' => $request['supplier_id'],
            'product_list' => $request['product_list'],
            'name' => $request['name'],
            'phone' => $request['phone'],
            'service_type' => $request['service_type'],

            'division_id' => $request['division'],
            'district_id' => $request['district'],
            'upazila_id' => $request['upazila'],
            'union_id' => $request['union'],
            'delivery_address' => $request['address'],
            'admin_remarks' => $request['admin_remarks'],
            'delivery_man_id' => $request['delivery_man_id'],
            'updated_by' => Auth::id()
        ];
        try {
            OrderData::where('order_id', $request['order_id'])->update($data);


            if ($sms_sent_status) {
                //Send SMS to customer
                sendSms2($request['phone'], getAssignedMessage($customer->invoice_number, $request['name'], $request['phone'], $supplier_name, $supplier_phone));
                //TODO::Send SMS To Supplier
                sendSms2($supplier_phone, getSupplierAssignedMessage($supplier_name, $request['phone']));
            }
            $this->trackRecord($request['order_id'], $status);
            return Redirect::to('/admin/order-request-view')->with('success', $return_message);

        } catch (\Exception $exception) {

            return back()->with('success', $exception->getMessage());
            return Redirect::to('/admin/orders/Pending')->with('failed', $exception->getMessage());
        }


        /* unset($request['_token']);
         $order_id = $request['order_id'];
         unset($request['order_id']);

         try {
             OrderData::where('order_id', $order_id)->update($request->all());

             return back()->with('success', "Successfully Updated");
         } catch (\Exception $exception) {
             return back()->with('failed', $exception->getMessage());
         }*/
    }


    public function releaseOrder($order_id)
    {

        try {
            OrderData::where('order_id', $order_id)->update([
                'status' => getStatusIdFromName("Pending")
            ]);

            return back()->with('success', "Successfully Updated");
        } catch (\Exception $exception) {
            return back()->with('failed', $exception->getMessage());
        }
    }

    public function destroy($id)
    {

        try {
            OrderData::where('order_id', $id)->delete();


            return back()->with('success', "Successfully Deleted");
        } catch (\Exception $exception) {
            return back()->with('failed', $exception->getMessage());
        }
    }


    public function create()
    {

        return view('pages.order.create');
    }


    public function store(Request $request)
    {


        if ($request['service_type'] == getComplainId()) {
            $request['status'] = 11;
        }
        $request['invoice_number'] = gettingInvoiceNumber();
        $request['time'] = "";


        unset($request['_token']);
        try {

            if (Auth::user()->user_type == getAdminId() || Auth::user()->user_type == getModeratorId()) {
                OrderData::create($request->all());
                return back()->with('success', "Successfully Saved");
            } else if (Auth::user()->user_type == getAgentId()) {

                $request['created_at'] = \Carbon\Carbon::now();
                $request['updated_at'] = \Carbon\Carbon::now();

                $id = OrderData::insertGetId($request->all());
                return Redirect::to('admin/order/' . $id)->with('success', "Successfully Order Created");

            } else {
                return back()->with('failed', "You are not authenticated");
            }


        } catch (\Exception $exception) {
            return back()->with('failed', $exception->getMessage());
        }


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

        $errors = 0;
        $data = array();
        $success = 0;
        if ($xlsx = SimpleXLSX::parse($file)) {

            $i = 0;
            $message = 0;
            foreach ($xlsx->rows() as $row) {
                if ($i > 0) {
                    $emp_array = [
                        'phone' => $this->formatMydata($row[1]),
                        'service_type' => getServiceFromName($row[2]),
                        'time' => $row[0],
                        "created_at" => \Carbon\Carbon::now(), # new \Datetime()
                        "updated_at" => \Carbon\Carbon::now(),  # new \Datetime()
                        "invoice_number" => gettingInvoiceNumber(),
                        "is_duplicate" => false
                    ];


                    OrderData::create($emp_array);
                    $success++;


                    /*$is_exist = OrderData::where('phone', $this->formatMydata($row[1]))
                        ->whereDate('created_at', Carbon::today())
                        ->where('service_type', getServiceFromName($row[2]))
                        ->first();
                    if (is_null($is_exist)) {
                        $data[] = $emp_array;
                        $is_exist = OrderData::where('phone', $this->formatMydata($row[1]))
                            ->where('status', getPendingStatusID())
                            ->where('service_type', getServiceFromName($row[2]))
                            ->first();
                        if (is_null($is_exist)) {
                            OrderData::create($emp_array);
                            $success++;
                        } else {
                            $errors++;
                        }
                        // echo "Null";
                    } else {


                        //echo "Exist";
                    }*/
                }
                $i++;
            }
        }


        //return count($data);
        try {
            /* OrderData::insert($data);*/

            return back()->with('success', "Successfully " . $success . " Entry Imported. " . $errors . " Duplicate found");
        } catch (\Exception $exception) {
            return back()->with('failed', $exception->getMessage());
        }


    }

    public function orderRequestView()
    {
        return view('pages.order.order_request');
    }

    public function orderRequest()
    {

        $result = OrderData::where('status', getStatusIdFromName("Pending"))->first();

        if (is_null($result)) {
            return back()->with('failed', "No Order Available");
        }
        $order_id = $result->order_id;

        return Redirect::to('/admin/order/' . $order_id);
    }
    
     /*lastest and orlder order request add by salman starts*/

    public function latestOrderRequest()
    {

        $result = OrderData::where('status', getStatusIdFromName("Pending"))->orderBy('created_at', 'DESC')->first();

        if (is_null($result)) {
            return back()->with('failed', "No Order Available");
        }
        $order_id = $result->order_id;

        return Redirect::to('/admin/order/' . $order_id);
    }

    public function OlderOrderRequest()
    {

        $result = OrderData::where('status', getStatusIdFromName("Pending"))->orderBy('created_at', 'ASC')->first();

        if (is_null($result)) {
            return back()->with('failed', "No Order Available");
        }
        $order_id = $result->order_id;

        return Redirect::to('/admin/order/' . $order_id);
    }

    /*lastest and orlder order request add by salman end*/

    public function orderDispute(Request $request)
    {


        try {
            OrderData::where('order_id', $request['order_id'])->update([
                'admin_remarks' => $request['admin_remarks']
            ]);

            return back()->with('success', "Successfully Updated");
        } catch (\Exception $exception) {
            return back()->with('failed', $exception->getMessage());
        }
    }


    public function show($status)
    {


        if ($status == "All") {

            //todo::Complain Except
            if (Auth::user()->user_type == 1) {
                $result = OrderData::orderBy('updated_at', 'DESC')
                    ->whereNotIn('status', [11, 13, 14])
                    ->whereNotIn('service_type',[5,6])
                    ->paginate(15);

            } else {


                $result = OrderData::orderBy('updated_at', 'DESC')
                    ->where('updated_by', Auth::user()->id)
                    ->whereNotIn('status', [11, 13, 14])
                    ->whereNotIn('service_type',[5,6])
                    ->paginate(15);

            }


        } elseif ($status == "Complain") {


            if (Auth::user()->user_type == 1) {
                $result = OrderData::where('status', getStatusIdFromName($status))
                    ->orderBy('updated_at', 'DESC')
                    ->paginate(15);
            } else {


                $result = OrderData::where('status', getStatusIdFromName($status))
                    ->where('updated_by', Auth::user()->id)
                    ->orderBy('updated_at', 'DESC')
                    ->paginate(15);
            }

        } else {

            if (Auth::user()->user_type == getAdminId()) {
                $result = OrderData::where('status', getStatusIdFromName($status))
                    ->orderBy('updated_at', 'DESC')
                    ->paginate(15);
            } else {

                $result = OrderData::where('status', getStatusIdFromName($status))
                    ->where('updated_by', Auth::user()->id)
                    ->orderBy('updated_at', 'DESC')
                    ->paginate(15);
            }
        }


        return view('pages.order.show')
            ->with('status', $status)
            ->with('result', $result);
    }

    public function orderSearch(Request $request)
    {


        if (Auth::user()->user_type == getAdminId()) {
            $result = OrderData::where('phone', "LIKE", '%' . $request['phone'] . '%')
                ->orWhere('invoice_number', "LIKE", '%' . $request['phone'] . '%')
                /*            ->whereNotIn('status', [11, 13])*/
                ->orderBy('updated_at', 'DESC')
                ->paginate(15);

        } else {


            $result = OrderData::orderBy('updated_at', 'DESC')
                ->where('updated_by', Auth::user()->id)
                /*   ->whereNotIn('status', [11, 13])*/
                ->Where('phone', "LIKE", '%' . $request['phone'] . '%')
                ->orWhere('invoice_number', "LIKE", '%' . $request['phone'] . '%')
                ->paginate(15);

        }


        return view('pages.order.show')
            ->with('result', $result);
    }

    public function orderTopSearch(Request $request)
    {

        $from = $request['from'];
        $to = $request['to'];

        $query = OrderData::orderBy('updated_at', 'DESC')
            ->whereNotIn('status', [11, 13, 14]);
            if($from==$to){
                $query->whereDate('created_at', $from);
            }else{
                $query->whereBetween('created_at', [date($from), date($to)]);
            }

        if ($request['status']) {
            $query->where('status', $request['status']);
            //return "yes";
        }
        if ($request['division']) {
            $query->where('division_id', $request['division']);
        }

        if ($request['district']) {
            $query->where('district_id', $request['district']);
        }

        if ($request['upazila']) {
            $query->where('upazila_id', $request['upazila']);
        }

        if ($request['union']) {
            $query->where('union_id', $request['union']);
        }

        $result = $query->paginate(15);

        return view('pages.order.show')
            ->with('result', $result);
    }


    public function complainedOrder()
    {

        $result = OrderData::whereIn('service_type',[5])
            ->orderBy('updated_at', 'DESC')
            ->get();


        return view('pages.order.complained_orders')
            ->with('result', $result);
    }

    public function complainedOrderDispute($order_id)
    {

        try {
            OrderData::where('order_id', $order_id)->update([
                'status' => 13
            ]);

            return back()->with('success', "Successfully Updated");
        } catch (\Exception $exception) {
            return back()->with('failed', $exception->getMessage());
        }
    }


    public function singleOrder($order_id)
    {


        $check_is_hold = OrderData::where('order_id', $order_id)->where('status', getStatusIdFromName("Hold"))->first();

        /* if (!is_null($check_is_hold)) {

             return Redirect::to('admin/orders/Hold')->with('failed', "Another operator working on this Order");
         }*/

        try {
            OrderData::where('order_id', $order_id)->update([
                'status' => 2,  //Hold
                'updated_by' => Auth::id()   //Hold
            ]);

            $this->trackRecord($order_id, getHoldStatusID());

        } catch (\Exception $exception) {

        }
        $result = OrderData::where('order_id', $order_id)->first();
        
        /*Calling time added by salman starts*/
            $result->callingTime= Carbon::parse($result->time)->format('d-M-Y h:m A');
        /*Calling time added by salman end*/

        if (is_null($result)) {
            return back()->with('failed', "No Order Available");
        }

        return view('pages.order.single_order')
            ->with('order_id', $order_id)
            ->with('result', $result);
    }

    public function assignSupplier(Request $request)
    {


        if ($request['is_tran']) {
            $data = [
                'status' => 14,  //Status as Tran
                'shop_id' => null,
                'product_list' => $request['product_list'],
                'name' => $request['name'],
                'phone' => $request['phone'],
                'service_type' => 6,//Tran

                'division_id' => $request['division'],
                'district_id' => $request['district'],
                'upazila_id' => $request['upazila'],
                'union_id' => $request['union'],
                'delivery_address' => $request['address'],
                'admin_remarks' => $request['admin_remarks'],
                'delivery_man_id' => null,
                'updated_by' => Auth::id()
            ];

            try {


                OrderData::where('order_id', $request['order_id'])->update($data);
                $this->trackRecord($request['order_id'], 14);
                return Redirect::to('/admin/order-request-view')->with('success', "Updated as Relief");

            } catch (\Exception $exception) {

                return back()->with('success', $exception->getMessage());
                return Redirect::to('/admin/orders/Pending')->with('failed', $exception->getMessage());
            }
        }


        $sms_sent_status = true;
        $return_message = "Successfully Assigned";
        $status = getStatusIdFromName("Supplier Assigned");
        if ($request['supplier_id'] == null) {
            $status = getStatusIdFromName("Supplier Not Found");
            $return_message = "Without Supplier Updated";
            $sms_sent_status = false;
        } else {
            //getting supplier Name
            $supplier = Shop::
            leftJoin('users', 'users.id', '=', 'shops.user_id')
                ->where('shop_id', $request['supplier_id'])
                ->first();


            if ($supplier->shop_phone != null) {
                $supplier_phone = $supplier->shop_phone;
            } else {
                $supplier_phone = $supplier->phone;
            }
            $supplier_name = $supplier->name;
        }

        if ($request['is_cancelled'] == true) {
            $status = getStatusIdFromName("Cancel Order");
            $return_message = "Order Cancelled";
            $data = OrderData::where('order_id', $request['order_id'])->first();

            //sendSms2($data->phone, getRetryMessage($data->invoice_number));
            $sms_sent_status = false;

        }


        $result = OrderData::where('order_id', $request['order_id'])
            ->whereNotNull('shop_id')
            ->first();

        $customer = OrderData::where('order_id', $request['order_id'])->first();

        if (is_null($result)) {


            $data = [
                'status' => $status,  //Supplier Assigned
                'shop_id' => $request['supplier_id'],
                'product_list' => $request['product_list'],
                'name' => $request['name'],
                'phone' => $request['phone'],
                'service_type' => $request['service_type'],

                'division_id' => $request['division'],
                'district_id' => $request['district'],
                'upazila_id' => $request['upazila'],
                'union_id' => $request['union'],
                'delivery_address' => $request['address'],
                'admin_remarks' => $request['admin_remarks'],
                'updated_by' => Auth::id()
            ];

            try {

                OrderData::where('order_id', $request['order_id'])->update($data);

                //return $supplier_phone;
                //return $supplier_phone = gettingShopPhone($request['order_id'], $supplier->phone);

                //TODO::sent SMS
                if ($sms_sent_status) {
                    //Send SMS to customer
                    sendSms2($request['phone'], getAssignedMessage($customer->invoice_number, $request['name'], $request['phone'], $supplier_name, $supplier_phone));
                    //TODO::Send SMS To Supplier
                    sendSms2($supplier_phone, getSupplierAssignedMessage($supplier_name, $request['phone']));
                }

                $this->trackRecord($request['order_id'], $status);
                return Redirect::to('/admin/order-request-view')->with('success', $return_message);

            } catch (\Exception $exception) {
                return Redirect::to('/admin/orders/Pending')->with('failed', $exception->getMessage());
            }

        } else {

            return Redirect::to('/admin/orders/Pending')->with('failed', "Already Assigned");
        }


    }


    public function updateStatus(Request $request)
    {

        $result = OrderData::where('order_id', $request['order_id'])->first();

        try {
            OrderData::where('order_id', $request['order_id'])->update([
                'status' => $request['status'],  //Supplier Assigned
                'admin_remarks' => $request['admin_remarks'],
                'updated_by' => Auth::id()
            ]);

            //TODO::sent SMS
            if (!is_null($result)) {
                //sendSms2($result->phone, getRetryMessage($result->invoice_number));
            }
            $this->trackRecord($request['order_id'], 3);
            return Redirect::to('/admin/orders/Retry')->with('success', "Unable to assign Supplier");

        } catch (\Exception $exception) {
            return Redirect::to('/admin/orders/Pending')->with('failed', $exception->getMessage());
        }
    }


    private function isProcessing($order_id, $user_id)
    {

        $is_exist = OrderDataStatus::where('order_id', $order_id)->first();
        if (is_null($is_exist)) {
            return "Waiting for process";
        } else {

            if ($is_exist->user_id == $user_id) {
                return "Process Initiated By You";
            }
        }
        return "Processing";
    }


    public function sendSmsToCustomer(Request $request)
    {


        try {
            OrderData::where('order_id', $request['order_id'])->update([
                'status' => getStatusIdFromName("Retry")
            ]);
            sendSms2($request->phone, $request->sms);

            return Redirect::to('/admin/orders/Retry')->with('success', "Successfully SMS Send");

        } catch (\Exception $exception) {

            return back()->with('failed', $exception->getMessage());
        }


    }


    public function formatMydata($number)
    {
        if (substr($number, 0, 2) == "88") {
            $number = substr($number, 2);
        }
        if (substr($number, 0, 1) != "0") {
            $number = "0" . $number;
        }
        if (substr($number, 0, 2) == "00") {
            $number = substr($number, 1);
        }

        return $number;
    }

    public function orderRelease()
    {

        try {
            OrderData::where('status', getHoldStatusID())->update([
                'status' => getPendingStatusID(),
                'updated_by' => Auth::user()->id,
            ]);

            return Redirect::to('/admin/orders/All')->with('success', "Released all from Hold status");

        } catch (\Exception $exception) {
            return Redirect::to('/admin/orders/All')->with('failed', $exception->getMessage());
        }
    }

    private function trackRecord($order_id, $status)
    {

        $is_exist = OrderDataStatus::where('order_id', $order_id)
            ->where('user_id', Auth::user()->id)
            ->first();

        if (is_null($is_exist)) {
            try {
                OrderDataStatus::create([
                    'order_id' => $order_id,
                    'status_id' => $status,
                    'user_id' => Auth::user()->id,
                ]);

                return true;
            } catch (\Exception $exception) {
                return false;
            }
        } else {
            try {
                OrderDataStatus::where('order_id', $order_id)
                    ->update([
                        'status_id' => $status
                    ]);

                return true;
            } catch (\Exception $exception) {
                return false;
            }
        }


    }

}
