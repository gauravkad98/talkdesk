<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // return view('paginate');
        //$users = DB::table('carrier_new')->simplePaginate(10);
        $data = DB::select("select status from tbl_status");
        return view('home')->with('posts', $data);
    }
}
