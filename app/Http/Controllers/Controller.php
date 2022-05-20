<?php



namespace App\Http\Controllers;



use App\OrderData;

use App\User;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Illuminate\Foundation\Bus\DispatchesJobs;

use Illuminate\Foundation\Validation\ValidatesRequests;

use Illuminate\Http\Request;

use Illuminate\Routing\Controller as BaseController;

use SoapClient;



class Controller extends BaseController

{

    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;



    public function newOrder()

    {





        return view('common.order');

    }





    public function newRegistration()

    {

        return view('common.registration');

    }



    public function storeUser(Request $request)

    {



        unset($request['_token']);

        $request['user_type'] = 3;

        $request['is_active'] = false;

        try {

            User::create($request->all());



            return back()->with('success', "Request submitted, You will contacted soon.");

        } catch (\Exception $exception) {

            return back()->with('failed', $exception->getMessage());

        }



    }



    public function orderStore(Request $request)

    {



        unset($request['_token']);

        if ($request->hasFile('product_image')) {

            $this->validate($request, [

                'product_image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:3048',

            ]);

            $image = $request->file('product_image');

            $image_name = time() . '.' . $image->getClientOriginalExtension();

            $destinationPath = public_path('/images/order');

            $image->move($destinationPath, $image_name);

        } else {

            $image_name = $request['product_image'];

        }



        $request['image'] = $image_name;





        try {

            OrderData::create($request->except('product_image'));

            return back()->with('success', "Order submitted successfully");

        } catch (\Exception $exception) {

            return back()->with('failed', $exception->getMessage());

        }



    }





    public function sendSmsToVolunteer()

    {





        try {



            foreach (User::where('is_sms_send', false)

                         ->where('user_type', getSupplierId())

                         ->limit(10)->orderBy('created_at', 'DESC')->get() as $res) {



               // $this->sendNow($res->name, $res->phone, $res->user_name);



                sendSms2($res->phone, supplierAccountCreationMessage($res->user_name, "123456"));

                

                



                User::where('id', $res->id)->update([

                    'is_sms_send' => true

                ]);

            }





        } catch (\Exception $exception) {



            return $exception->getMessage();

        }



        return view("sms")->with('success', "10 Message sent, Remaining " . User::where('is_sms_send', false)->where('user_type', getSupplierId())->count());





    }





}

