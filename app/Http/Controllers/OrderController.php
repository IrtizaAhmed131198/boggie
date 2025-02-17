<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Hash;
use View;
use Stripe;
use Session;
use App\Banner;
use App\orders;
use App\inquiry;
use App\Product;
use App\Program;
use Stripe\Charge;
use App\imagetable;
use App\newsletter;
use Stripe\Customer;
use App\orders_products;
use Illuminate\Http\Request;
use App\Http\Traits\HelperTrait;
use App\Http\Requests\OrderRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class OrderController extends Controller
{

    use HelperTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // use Helper;

    public function __construct()
    {
        // $this->middleware('guest');
        $logo = imagetable::select('img_path')
            ->where('table_name', '=', 'logo')
            ->first();

        $favicon = imagetable::select('img_path')
            ->where('table_name', '=', 'favicon')
            ->first();

        View()->share('logo', $logo);
        View()->share('favicon', $favicon);
        //View()->share('config',$config);
    }

    public function getStates(Request $request)
    {

        $states = DB::table('states')->where('country_id', $request->country_id)->get();
        echo json_encode(array("states" => $states));
    }

    public function getCities(Request $request)
    {

        $cities = DB::table('cities')->where('state_id', $request->state_id)->get();
        echo json_encode(array("cities" => $cities));
    }


}

