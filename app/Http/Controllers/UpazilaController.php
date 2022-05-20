<?php

namespace App\Http\Controllers;

use App\District;
use App\Union;
use App\Upazila;
use Illuminate\Http\Request;

class UpazilaController extends Controller
{

    public function getUpazila()
    {
        $data = Upazila::join('districts', 'districts.district_id', '=', 'upazilas.district_id')->get([
            'upazilas.en_name',
            'upazilas.bn_name',
            'upazilas.upazila_id',

            'districts.en_name as district_name',
        ]);
        return view('pages.upazila.show')->with('results', $data);

    }

    public function createUpazila()
    {

        return view('pages.upazila.create')->with('results', District::get());

    }

    public function editUpazila($id)
    {

        return view('pages.upazila.edit')
            ->with('result', Upazila::where('upazila_id', $id)->first())
            ->with('results', District::get());

    }

    public function updateUpazila(Request $request)
    {
        unset($request['_token']);
        $id = $request['upazila_id'];
        unset($request['upazila_id']);

        try {

            Upazila::where('upazila_id', $id)->update($request->all());

            return back()->with('success', "Successfully Updated");

        } catch (\Exception $exception) {

            return back()->with('failed', $exception->getMessage());
        }
    }

    public function storeUpazila(Request $request)
    {
        unset($request['_token']);

        try {

            Upazila::create($request->all());

            return back()->with('success', "Successfully Saved");

        } catch (\Exception $exception) {

            return back()->with('failed', $exception->getMessage());
        }


    }

    public function deleteUpazila($id)
    {
        try {

            Upazila::where('upazila_id', $id)->delete();

            return back()->with('success', "Successfully Deleted");

        } catch (\Exception $exception) {

            return back()->with('failed', $exception->getMessage());
        }
    }

    public function getUnion()
    {

        $data = Union::join('upazilas', 'upazilas.upazila_id', '=', 'unions.upazila_id')->get([
            'unions.en_name',
            'unions.bn_name',
            'unions.id',

            'upazilas.en_name as upazila_name',
        ]);
        return view('pages.union.show')->with('results', $data);

    }

    public function createUnion()
    {

        return view('pages.union.create')->with('results', Upazila::get());

    }

    public function storeUnion(Request $request)
    {
        unset($request['_token']);

        $request['url'] = "-";

        try {

            Union::create($request->all());

            return back()->with('success', "Successfully Saved");

        } catch (\Exception $exception) {

            return back()->with('failed', $exception->getMessage());
        }


    }

    public function deleteUnion($id)
    {

        try {

            Union::where('id', $id)->delete();

            return back()->with('success', "Successfully Deleted");

        } catch (\Exception $exception) {

            return back()->with('failed', $exception->getMessage());
        }
    }

    public function editUnion($id)
    {

        return view('pages.union.edit')
            ->with('result', Union::where('id', $id)->first())
            ->with('results', Upazila::get());

    }

    public function updateUnion(Request $request)
    {
        unset($request['_token']);
        $id = $request['union_id'];
        unset($request['union_id']);

        try {

            Union::where('id', $id)->update($request->all());

            return back()->with('success', "Successfully Updated");

        } catch (\Exception $exception) {

            return back()->with('failed', $exception->getMessage());
        }


    }
}
