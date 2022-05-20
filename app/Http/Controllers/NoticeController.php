<?php

namespace App\Http\Controllers;

use App\Notice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NoticeController extends Controller
{
    public function create()
    {
        return view('pages.notice.create');
    }


    public function store(Request $request)
    {
        unset($request['_token']); //Remove Token

        if ($request->hasFile('notice_image')) {

            $image = $request->file('notice_image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/notice');
            $image->move($destinationPath, $image_name);
        } else {
            $image_name = null;
        }

        $request['image'] = $image_name;
        $request['created_by'] = Auth::user()->id;


        try {
            Notice::create($request->except('notice_image'));
            return back()->with('success', "Notice created");
        } catch (\Exception $exception) {
            return back()->with('failed', $exception->getMessage());
        }
    }


    public function show()
    {
        $result = Notice::orderBy('created_at', 'DESC')->limit(25)->get();

        return view('pages.notice.show')->with('results', $result);
    }

    public function edit($id)
    {
        $result = Notice::where('notice_id', $id)->first();//(Admin=1/Operator=2/Supplier=3/SupplierOperator=4)

        return view('pages.notice.edit')->with('result', $result);
    }

    public function update(Request $request)
    {
        unset($request['_token']); //Remove Token
        $id = $request['id'];
        unset($request['id']); //Remove id

        if ($request->hasFile('notice_image')) {

            $image = $request->file('notice_image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/images/notice');
            $image->move($destinationPath, $image_name);
        } else {
            $image_name = $request['image'];
        }

        $request['image'] = $image_name;

        try {
            Notice::where('notice_id', $id)->update($request->except('notice_image'));
            return back()->with('success', "Agent Updated");
        } catch (\Exception $exception) {
            return back()->with('failed', $exception->getMessage());
        }
    }


    public function destroy($id)
    {

        try {
            Notice::where('notice_id', $id)->delete();
            return back()->with('success', "Notice Deleted");
        } catch (\Exception $exception) {
            return back()->with('failed', $exception->getMessage());
        }
    }

}
