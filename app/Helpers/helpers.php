<?php


use App\User;

use Carbon\Carbon;


function getStatusList()

{

    return $status_array = array(

        '1' => 'Pending',

        '2' => 'Hold',

        '3' => 'Retry',

        '4' => 'Supplier Assigned',//done

        '5' => 'Accept',//Accepted

        '6' => 'Cancel',//Cancelled Ignore

        '7' => 'Delivered',

        '8' => "Can't Deliver",

        '9' => "Cancel Order",// Admin

        '10' => "Supplier Not Found",// Admin

        '11' => "Complain",// Admin

        '12' => "Dispute",// upadte by Admin when resolve an cmplain


        '13' => "Checked",// For Complain

        '14' => "Tran",// For Complain


    );

}


function getFormattedDate($date)

{

    $createdAt = Carbon::parse($date);

    return $createdAt->format('M d, y g:i A');

}


function getCantDeliverStatusId($type)

{

    if ($type == "name") {

        return "Can't Deliver";

    }


    return 8;

}


function getPendingStatusID()

{

    return 1;

}

function getHoldStatusID()

{

    return 2;

}

function getAcceptedStatusID()

{

    return 5;

}


function getcancelledStatusId()

{

    return 6;

}


function getSupplierAssignedId($type)

{

    if ($type == "name") {

        return "Supplier Assign";

    }

    return 4;

}


function getStatusName($id)

{


    foreach (getStatusList() as $key => $value) {

        if ($id == $key) {

            return $value;

        }

    }

}


function getStatusIdFromName($name)

{


    foreach (getStatusList() as $key => $value) {

        if ($name == $value) {

            return $key;

        }

    }

}


function getServiceType()

{

    return $array = array(

        '1' => 'Grocery',
        '2' => 'Medicine',
        '3' => 'PPE',
        '4' => 'Other',
        '5' => 'Complain',
        '6' => 'Tran',

    );

}


function getServiceFromId($id)

{

    foreach (getServiceType() as $key => $value) {

        if ($id == $key) {

            return $value;

        }

    }

}


function getServiceFromName($string)

{

    foreach (getServiceType() as $key => $value) {

        if (strtolower($string) == strtolower($value)) {


            return $key;

        }

    }


    return 4;

}


function getCoverageDepth()

{

    return $array = array(

        'Division' => 'Division',

        'District' => 'District',

        'Upazila' => 'Upazila',

        'Union' => 'Union',

    );

}


function getServiceTypeId($service_name)

{


    return $service_name;


    return $array = array(

        'Division' => 'Division',

        'District' => 'District',

        'Upazila' => 'Upazila',

        'Union' => 'Union',

    );

}


function commaSeperate()

{

    return $array = array(

        'Division' => 'Division',

        'District' => 'District',

        'Upazila' => 'Upazila',

        'Union' => 'Union',

    );

}


function getAssignedMessage($invoice_number, $customer_name, $customer_phone, $name, $supplier_phone)

{


    return "Volunteer number: " . $supplier_phone . " apnar kora order delivery er jonne nijukto hoyece. Order ID: " . $invoice_number . ". ekShop, a2i";

}


function getSupplierAssignedMessage($name, $phone)

{

    return "Notun ekti order er jonne apnake mononito kora hoyeche. customer er sathe kotha bolte call korun: " . $phone . " ekShop, a2i";


}


function getRetryMessage($invoice_number)

{


    return "Order ID: " . $invoice_number . " ti Cancel kora hoyece. Proyojone jogajog korun 01306326052. ekShop, a2i";


}


function getSuppliernameFromOrderId($order_id)

{

    $data = \App\OrderData::

    leftJoin('shops', 'shops.shop_id', '=', 'order_datas.shop_id')
        ->leftJoin('users', 'users.id', '=', 'shops.user_id')
        ->where('order_datas.order_id', $order_id)
        ->first();

    if (!is_null($data)) {

        return $data;

    }

    return null;


}


function gettingMultipleshops($values)

{

    return explode(',', $values);


}


function getDivisionIdFromName($name)

{

    $data = \App\Division::where('en_name', $name)->first();

    if (!is_null($data)) {

        return $data->division_id;

    }

    return null;


}


function getDistrictIdFromName($name)

{

    $data = \App\District::where('en_name', $name)->first();

    if (!is_null($data)) {

        return $data->district_id;

    }

    return null;


}


function getUpazilaIdFromName($name)

{

    $data = \App\Upazila::where('en_name', $name)->first();

    if (!is_null($data)) {

        return $data->upazila_id;

    }

    return null;


}


function getDivisionFromId($id)

{

    $data = \App\Division::where('division_id', $id)->first();

    if (!is_null($data)) {

        return $data->en_name;

    }

    return null;


}


function getDistrictFromId($id)

{

    $data = \App\District::where('district_id', $id)->first();

    if (!is_null($data)) {

        return $data->en_name;

    }

    return null;


}


function getUpazilaFromId($id)

{

    $data = \App\Upazila::where('upazila_id', $id)->first();

    if (!is_null($data)) {

        return $data->en_name;

    }

    return null;


}


function getunionFromId($id)

{

    $data = \App\Union::where('id', $id)->first();

    if (!is_null($data)) {

        return $data->en_name;

    }

    return null;


}


function getSupplierNameFromId($id)

{

    $data = \App\User::where('id', $id)->first();

    if (!is_null($data)) {

        return $data->name;

    }

    return null;


}


function getSupplierPhoneFromId($id)

{

    $data = \App\User::where('id', $id)->first();

    if (!is_null($data)) {

        return $data->phone;

    }

    return null;


}


function getSupplierIdFromOrderId($order_id)

{

    $data = \App\OrderData::

    leftJoin('shops', 'shops.shop_id', '=', 'order_datas.shop_id')
        ->leftJoin('users', 'users.id', '=', 'shops.user_id')
        ->where('order_datas.order_id', $order_id)
        ->first();

    if (!is_null($data)) {

        return $data->id;

    }

    return null;


}


function gettingShopPhone($order_id, $supplier_phone)

{

    $shop_data = \App\OrderData::join('shops', 'shops.shop_id', '=', 'order_datas.shop_id')
        ->where('order_id', $order_id)
        ->first();

    if ($shop_data->shop_phone != null) {

        return $shop_data->shop_phone;

    } else {

        return $supplier_phone;

    }

}


function getShopNameFromId($shop_id)

{

    return \App\Shop::where('shop_id', $shop_id)->first();
}


function gettingUsernameFromId($user_id)

{
    $data = \App\User::where('id', $user_id)->first();


    if ($data->name != null) {

        return $data->name;

    } else {

        return null;

    }

}


function gettingDeliveryManFromId($user_id)

{

    $data = \App\DeliveryMan::where('delivery_man_id', $user_id)->first();

    if(!is_null($data)){
        return $data->name;
    }else{
        return null;
    }

    /*if ($data->name != null) {



    } else {

        return null;

    }*/

}


function getAdminId()

{

    return 1;

}


function getAgentId()

{

    return 2;

}


function getSupplierId()

{

    return 3;

}


function getSupplierOperatorId()

{

    return 4;

}


function getModeratorId()

{

    return 5;

}


function getAdminNameFromId($id)

{


    $array = array(

        '1' => 'Admin',

        '2' => 'Agent',

        '3' => 'Supplier',

        '4' => 'Supplier Operator',//done

        '5' => 'Moderator',//Accepted

    );

    foreach ($array as $key => $value) {

        if ($id == $key) {

            return $value;

        }

    }


}


function getGroceryId()

{

    return 1;

}


function getMedicineId()

{

    return 2;

}


function getPpeId()

{

    return 3;

}


function getOtherProductId()

{

    return 4;

}


function getComplainId()

{

    return 5;

}


function sendSms($mobile, $sms)

{

    $mobile = formatMydata($mobile);


    $url = "http://bulksms.teletalk.com.bd/link_sms_send.php?op=SMS&user=ekShop-external&pass=1234560000&mobile=" . $mobile . "&charset=UTF-8&sms=" . urlencode($sms);

    $ch = curl_init($url);

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    curl_setopt($ch, CURLOPT_HEADER, 0);

    $data = curl_exec($ch);

    curl_close($ch);

}


function formatMydata($number)

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


function supplierAccountCreationMessage($user_id, $password)

{


    return "Phone-e nittoponno app e login korun https://nittoponno.ekshop.world, username: " . $user_id . ", Pass: " . $password . ". Login kore password ebong profile update kore nin. ekShop, a2i";


    /*    return 'ফোনে নিত্যপণ্য সেবায় আপনার অ্যাকাউন্ট তৈরি হয়েছে। লগইন করুন ' . url('') . ' User: ' . $user_id . ' Pass: '

            . $password . ' একশপ, এটুআই';*/

}


function gettingInvoiceNumber()

{

    return "PN" . mt_rand(100000, 999999);

}


function generateUsername($phone)

{


    return $phone . rand(0, 9);

}


function sendSms2($mobile, $sms)

{

    $mobile = formatMydata($mobile);

    $mobile = "88" . $mobile;

    //$url = "https://www.myvaluefirst.com/smpp/sendsms?username=demohtp261&password=demohtp2&to=" . $mobile . "&from=8804445600777&text=" . $sms;
    $url = "https://bdhttp.myvfirst.com/smpp/sendsms?username=acessinfohtpint&password=acess@12&to=" . $mobile . "&from=8804445600777&text=" . $sms;

    $client = new \GuzzleHttp\Client();

    $res = $client->get($url);


}


function sendSms3($mobile, $sms)

{

    $soapClient = new SoapClient("https://api2.onnorokomSMS.com/sendSMS.asmx?wsdl");

    $paramArray = array(

        'userName' => "01612363773",

        'userPassword' => "asd12300",

        'mobileNumber' => $mobile,

        'smsText' => $sms,

        'type' => "TEXT",

        'maskName' => '',

        'campaignName' => '',

    );


    $value = $soapClient->__call("OneToOne", array($paramArray));


    return 1;

}


function getTotalOnline()

{

    return $total_online_user = User::where('updated_at', '>=', Carbon::now()->subMinutes(5)->toDateTimeString())->count();

}


function todaysOnlineUsers()

{

    return $total_online_user = User::whereDate('updated_at', Carbon::today())->count();

}


function gettingOnlineIntervalTime()

{

    return 5;

}


function gettingOrderCountByStatus($status)

{

    if ($status == "Total") {

        return $count = \App\OrderData::whereNotIn('service_type', [5])->count();


    }

    if ($status == "Cancel Order") {
        return $count = \App\OrderData::whereIn('status', [9])->count();
    }


    if ($status == "Complain") {
        return $count = \App\OrderData::whereIn('service_type', [5])->count();
    }

    return $count = \App\OrderData::where('status', getStatusIdFromName($status))->count();


}


function processedOrders($date)

{

    return $count = \App\OrderData::whereNotIn('status', [1, 11])->count();


}


function getStatusListForAgent()

{

    return $status_array = array(

        '2' => 'Hold',

        '3' => 'Retry',

        '4' => 'Supplier Assigned',//done

        '9' => "Cancel Order",// Admin

        '10' => "Supplier Not Found",// Admin

        '11' => "Complain",// Admin

        '12' => "Dispute",// upadte by Admin when resolve an cmplain

        '13' => "Checked",// For Complain

        '14' => "Tran",// For Complain


    );

}


/*SMS Uses

1. UserController

2. OrderController



*/


?>