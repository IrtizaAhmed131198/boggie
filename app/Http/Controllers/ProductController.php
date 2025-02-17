<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\inquiry;

use App\newsletter;
use App\Program;
use App\imagetable;
use SoapClient;
use App\Product;
use App\Category;
use App\Banner;
use App\ProductAttribute;
use App\Models\Audio_gallery;
use DB;
use View;
use Session;
use App\Http\Traits\HelperTrait;
use App\orders;
use App\orders_products;
use Illuminate\Contracts\Session\Session as SessionSession;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
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
        //$this->middleware('auth');
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

    public function index()
    {
        $products = new Product;
        if (isset($_GET['q']) && $_GET['q'] != '') {

            $keyword = $_GET['q'];

            $products = $products->where(function ($query) use ($keyword) {
                $query->where('product_title', 'like', $keyword);
            });
        }
        $products = $products->orderBy('id', 'asc')->get();
        return view('products', ['products' => $products]);
    }

    public function productDetail($id)
    {

        $product = new Product;
        $product_detail = $product->where('id', $id)->first();
        $products = DB::table('products')->get()->take(10);
        return view('product_detail', ['product_detail' => $product_detail, 'products' => $products]);
    }


    public function cart(Request $request)
    {
        $shipping = HelperTrait::returnFlag(123);
        // Retrieve the cart from the session
        $cart = Session::get('cart', []);

        // Initialize flags to track what the cart contains
        $containsProduct = false;
        $containsCourse = false;

        // Check each item in the cart and set the flags
        if (count($cart) > 0) {
            foreach ($cart as $cartItem) {
                $itemType = Product::where('id', $cartItem['id'])->value('type');

                // Check if the item is a product or a course
                if ($itemType === 'product') {
                    $containsProduct = true;
                } elseif ($itemType === 'course') {
                    $containsCourse = true;
                }

                // If both a product and a course are found, no need to check further
                if ($containsProduct && $containsCourse) {
                    break;
                }
            }
        }

        // Pass the flags and cart to the view
        return view('shop.cart', [
            'cart' => $cart,
            'containsProduct' => $containsProduct,
            'containsCourse' => $containsCourse,
            'shipping' => $shipping,
        ]);
    }


    // public function cart()
    // {
    //     $cart = Session::get('cart');
    //     $shipping = HelperTrait::returnFlag(123);
    //     return view('shop.cart', [
    //         'cart' => $cart,
    //         'shipping' => $shipping,
    //     ]);
    // }



    public function invoice($id)
    {

        $order_id = $id;
        $order = orders::where('id', $order_id)->first();
        $order_products = orders_products::where('orders_id', $order_id)->get();

        return view('account.invoice')->with('title', 'Invoice #' . $order_id)->with(compact('order', 'order_products'))->with('order_id', $order_id);
        ;
    }


}
