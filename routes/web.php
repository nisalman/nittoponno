<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


use App\OrderData;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;



Route::get('/user/registration', 'LoginController2@registration');
Route::post('/user/registration/save', 'LoginController2@registrationSave');
Route::get('/user/confirm/{id}', 'LoginController2@confirmMail');

Route::get('/user/forget-pass', 'LoginController2@forgetPass');


Route::get('/', 'LoginController2@login');
Route::get('/registration', 'Controller@newRegistration');
Route::post('/registration/store', 'Controller@storeUser');
Route::post('/order/store', 'Controller@orderStore');


Route::get('/home', 'LoginController2@index');
Route::get('/login', 'LoginController2@login');
Route::post('/login-check', 'LoginController2@doLogin');
Route::get('/logout', 'LoginController2@doLogout');

//Profile


Route::get('/admin/profile', 'SettingController@profile');
Route::get('/admin/profile/edit', 'SettingController@editProfile');
Route::post('/admin/profile/update', 'SettingController@updateProfile');


Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function () {

    Route::get('/dashboard', 'HomeController@adminHome');
    //Supplier Add
    Route::get('/supplier/create', 'UserController@create');
    Route::post('/supplier/store', 'UserController@store');
    Route::post('/supplier/csv-store', 'UserController@csvStore');
    Route::get('/supplier/edit/{id}', 'UserController@edit');
    Route::post('/supplier/update', 'UserController@update');
    Route::get('/suppliers', 'UserController@show');
    Route::post('/supplier-search', 'UserController@supplierSearch');
    Route::get('/supplier/status-update/{user_id}/{status}', 'UserController@statusUpdate');

    //Orders
    Route::get('/supplier-orders/{user_id}', 'UserController@supplierAllOrder');

    //Supplier Add
    Route::get('/order/create', 'OrderDataController@create');
    Route::post('/order/csv-store', 'OrderDataController@csvStore');
    Route::post('/order/store', 'OrderDataController@store');
    Route::get('/order/edit/{id}', 'OrderDataController@edit');
    Route::get('/order/delete/{id}', 'OrderDataController@destroy');


    Route::post('/order/update', 'OrderDataController@update');
    Route::get('/orders/{status}', 'OrderDataController@show');
    Route::post('/order-search', 'OrderDataController@orderSearch');


    Route::get('/order-request-view', 'OrderDataController@orderRequestView');
    Route::get('/order-request', 'OrderDataController@orderRequest');
    
     /*lastest and orlder order request add by salman starts*/
    Route::get('/latest-order-request', 'OrderDataController@latestOrderRequest');
    Route::get('/older-order-request', 'OrderDataController@olderOrderRequest');
    /*lastest and orlder order request add by salman end*/

    Route::get('/order/{order_id}', 'OrderDataController@singleOrder');
    Route::get('/order/release-order/{order_id}', 'OrderDataController@releaseOrder');

    Route::post('/order/send-sms', 'OrderDataController@sendSmsToCustomer');


    //Assign Supplier
    Route::post('/order/assign-supplier', 'OrderDataController@assignSupplier');
    Route::post('/order/status-change', 'OrderDataController@updateStatus');

    //Complain Order Supplier
    Route::get('/complain-orders', 'OrderDataController@complainedOrder');
    Route::get('/complain-order/dispute/{id}', 'OrderDataController@complainedOrderDispute');
    Route::post('/order/dispute', 'OrderDataController@orderDispute');

    Route::post('/order-top-search', 'OrderDataController@orderTopSearch');


    //DeliveryMan Manage

    //Manage Operator
    Route::get('/agent/create', 'AgentController@create');
    Route::post('/agent/store', 'AgentController@store');
    Route::get('/agents', 'AgentController@show');
    Route::get('/agent/edit/{id}', 'AgentController@edit');
    Route::post('/agent/update/', 'AgentController@update');
    Route::get('/agent/status-update/{user_id}/{status}', 'AgentController@statusUpdate');

    //Manage Moderator
    Route::get('/moderator/create', 'ModeratorController@create');
    Route::post('/moderator/store', 'ModeratorController@store');
    Route::get('/moderators', 'ModeratorController@show');
    Route::get('/moderator/edit/{id}', 'ModeratorController@edit');
    Route::post('/moderator/update/', 'ModeratorController@update');
    Route::get('/moderator/status-update/{user_id}/{status}', 'ModeratorController@statusUpdate');

    //Manage Notice
    Route::get('/notice/create', 'NoticeController@create');
    Route::post('/notice/store', 'NoticeController@store');
    Route::get('/notice/edit/{id}', 'NoticeController@edit');
    Route::post('/notice/update', 'NoticeController@update');
    Route::get('/notice/destroy/{id}', 'NoticeController@destroy');

    //Manage Upazila
    Route::get('/upazilas', 'UpazilaController@getUpazila');
    Route::get('/upazila/create', 'UpazilaController@createUpazila');
    Route::post('/upazila/store', 'UpazilaController@storeUpazila');
    Route::get('/upazila/delete/{id}', 'UpazilaController@deleteUpazila');

    Route::get('/upazila/edit/{id}', 'UpazilaController@editUpazila');
    Route::post('/upazila/update', 'UpazilaController@updateUpazila');

    Route::get('/unions', 'UpazilaController@getUnion');
    Route::get('/union/create', 'UpazilaController@createUnion');
    Route::post('/union/store', 'UpazilaController@storeUnion');
    Route::get('/union/delete/{id}', 'UpazilaController@deleteUnion');

    Route::get('/union/edit/{id}', 'UpazilaController@editUnion');
    Route::post('/union/update', 'UpazilaController@updateUnion');
    
        Route::get('/checksql', 'OrderDataController@test');


    //Order Release
    /*    Route::get('/hm"', 'OrderDataController@orderRelease');*/
    Route::get('/order-release', 'OrderDataController@orderRelease');

    //Report

    Route::get('/agent-wise-report', 'ReportController@agentWiseReport');
    Route::get('/status-wise-report', 'ReportController@statusWiseReport');
    Route::any('/tran-report', 'ReportController@tranReport');
    Route::any('/agent-report', 'ReportController@allAgentReport');

    Route::any('/online-user', 'ReportController@onlineUser');


    Route::any('/order-report', 'ReportController@orderReport');
    Route::any('/shop-report', 'ReportController@shopReport');


});

Route::group(['middleware' => 'supplier'], function () {


    Route::get('/admin/deliveryman/create', 'DeliveryManController@createDeliveryMana');
    Route::post('/admin/deliveryman/store', 'DeliveryManController@storeDeliveryMana');
    Route::post('/supplier/deliveryman/csv-store', 'DeliveryManController@csvStore');

    Route::get('/admin/deliverymans', 'DeliveryManController@showDelivery');
    Route::get('/admin/deliveryman/edit/{id}', 'DeliveryManController@edit');
    Route::post('/admin/deliveryman/update', 'DeliveryManController@update');

    Route::get('/admin/deliveryman/delete/{id}', 'DeliveryManController@deliveryManaDelete');
    //Shops

    Route::get('/admin/shop/create/{user_id}', 'ShopController@create');
    Route::post('/admin/shop/store', 'ShopController@store');

    Route::get('/admin/shop/edit/{id}', 'ShopController@edit');
    Route::post('/admin/shop/update', 'ShopController@update');

    Route::get('/admin/shop-status/{shop_id}/{status}', 'ShopController@shopStatusUpdate');


    Route::any('/admin/shops', 'ShopController@allShop');
    Route::get('/admin/shops/{user_id}', 'ShopController@show');
    Route::post('/admin/shop-search', 'ShopController@shopSearch');


    Route::get('/admin/get-statuses/{date}', 'ApiController@getStatuses');
    Route::any('/supplier/report/{id}', 'ReportController@agentReport');


});


Route::group(['prefix' => 'supplier', 'middleware' => 'supplier'], function () {

    Route::get('/dashboard', 'SupplierController@dashboard');
    Route::get('/orders', 'SupplierController@orders');
    Route::get('/profile', 'SupplierController@dashboard');


    Route::get('/deliveryman/create', 'SupplierController@createDeliveryMana');
    Route::post('/deliveryman/store', 'SupplierController@store');
    Route::get('/deliverymans', 'SupplierController@showDelivery');
    Route::get('/deliveryman/delete/{id}', 'SupplierController@deliveryManaDelete');


    Route::post('/order/order-update', 'SupplierController@orderUpdate');

    Route::post('/order/assign-deliveryman', 'SupplierController@assignDeliveryMan');
    Route::get('/update-order-status/{id}/{status}', 'SupplierController@updateOrderStatus');

    Route::get('/shop/{shop_id}', 'SupplierController@filteredOrder');
    Route::post('/order-search', 'SupplierController@orderSearch');
    Route::post('/shop-search', 'SupplierController@shopSearch');
    Route::get('/orders/{status}', 'SupplierController@orderByStatus');

    Route::get('/notices', 'NoticeController@show');

});


// API Data

Route::get('/division', 'ApiController@getDivision');
Route::get('/district/{division_id}', 'ApiController@getDistrict');
Route::get('/upazila/{district_id}', 'ApiController@getUpazila');
Route::get('/union/{upazila_id}', 'ApiController@getUnion');
Route::get('/get-suppliers/{area_type}/{area_id}/{service_type}', 'ApiController@getSuppliers');


Route::get('/check-shop-capacity/{shop_id}', 'ApiController@checkShopCapacity');


Route::get('/send-sms', 'Controller@sendSmsToVolunteer');


Route::get('/test', function () {

    $result = OrderData::orderBy('updated_at', 'DESC')
        ->paginate(5);


    return view('test')
        ->with('result', $result);

    /*
        $message = $name . ", Test Phone-e nittoponno app e login korun username: " . $user_name . " Pass: 123456 URL:  ekShop, a2i";
        $url = "https://api2.onnorokomsms.com/HttpSendSms.ashx?op=OneToOne&type=TEXT&mobile=" . $mobile . "&smsText=" . $message . "&username=01612363773&password=asd12300";



        $client = new \GuzzleHttp\Client();
        $res = $client->get($url);*/


    return Auth::user();
    return view('text');

    $supplier_phone = "01717849968";


    $order_id = 5;
    $shop_data = \App\OrderData::join('shops', 'shops.shop_id', '=', 'order_datas.shop_id')
        ->where('order_id', $order_id)
        ->first();

    if ($shop_data->shop_phone != null) {
        return $shop_data->shop_phone;
    } else {
        return $supplier_phone;
    }


});


Route::get('/message', function () {
    //return sendSms2("01303106024", "Test Message");
    
    $mobile="8801612363773";
    $sms="Message";
   try{
        
    $url = "https://bdhttp.myvfirst.com/smpp/sendsms?username=acessinfohtpint&password=acess@12&to=" . $mobile . "&from=8804445600777&text=" . $sms;

    $client = new \GuzzleHttp\Client();

    $res = $client->get($url);
   }catch(\Exception $e){
       
       return $e->getMessage();
       
   }

});

 //Remove duplicates
 
 Route::get('/rdo', function(){
   
   //Get duplicate records phone number 
   $duplicates = DB::table('order_datas')
    ->select('phone')
    ->groupBy('phone')
    ->havingRaw('COUNT(*) > 1')
    ->whereNotNull('phone')
    ->where('phone', '!=',"")
    ->limit(500)
    ->get();
    
    $count = 0;
    
    foreach($duplicates as $duplicate){

    //Get one order id of duplicate phone nunbers
      $duplicatee =  DB::table('order_datas')
        ->where('phone',$duplicate->phone)
        ->first();
        
    //Delete all duplicate records except one
       DB::table('order_datas')
       ->where('order_datas.order_id','!=', $duplicatee->order_id )
       ->where('order_datas.phone',$duplicate->phone)
       ->delete();
       
    //   Duplicate counter
        $count++;
    }
    
    //Delete all records without phone number
    $null =  DB::table('order_datas')
        ->where('phone', '=', NULL)
        ->orWhere('phone',"")
        ->delete();
    
    
    if( $count == 0 && $null == 0){
        return "No duplicates";
    }
    return "Total duplicate number: " . $count . ' || No phone number:' . $null;
     
 });

 
Route::get('/down', function () {
    $exitCode = Artisan::call('down');
});

Route::get('/up', function () {
    $exitCode = Artisan::call('up');
});







