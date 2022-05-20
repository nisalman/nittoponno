<?php

namespace App\Http\Controllers;

use App\LoginHistory;
use App\OrderData;
use App\Shop;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{


    public function adminHome()
    {


        if (Auth::user()->user_type == getAdminId()) {
            $login_histories = LoginHistory::
            join('users', 'users.id', '=', 'login_histories.user_id')
                ->orderBy('login_histories.updated_at', 'DESC')
                ->select(
                    'login_histories.ip_address',
                    'login_histories.updated_at',
                    'users.name',
                    'users.profile_pic'
                )->simplePaginate(5);

        } else {
            $login_histories = LoginHistory::
            join('users', 'users.id', '=', 'login_histories.user_id')
                ->where('login_histories.user_id', Auth::user()->id)
                ->orderBy('login_histories.updated_at', 'DESC')
                ->select(
                    'login_histories.ip_address',
                    'login_histories.updated_at',
                    'users.name',
                    'users.profile_pic'
                )->simplePaginate(5);

        }


        $total_shop = Shop::count();
        $total_order = OrderData::count();
        $total_supplier = User::where('user_type', 3)->count();

        $total_union_coverage = Shop::distinct('union_id')->whereNotNull('union_id')->count();


        $total_supplier_nid = User::where('user_type', 3)->whereNotNull('nid')->count();
        $total_login = LoginHistory::selectRaw('date(created_at) date, count(*) count')
            ->groupBy('date')
            ->limit(15)
            ->orderByDesc('date')
            ->get();
           

        // return $total_login;

        $total_unique_login = LoginHistory::selectRaw('date(created_at) date, count(distinct(user_id)) count')
            ->groupBy('date')
            ->limit(15)
            ->orderByDesc('date')
            ->get();


        return view('pages.home.index')
            ->with('histories', $login_histories)
            ->with('total_shop', $total_shop)
            ->with('total_supplier', $total_supplier)
            ->with('total_order', $total_order)
            ->with('total_login', $total_login)
            ->with('total_unique_login', $total_unique_login)
            ->with('total_supplier_nid', $total_supplier_nid)
            ->with('total_union_coverage', $total_union_coverage);

    }


}
