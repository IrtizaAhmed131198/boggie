<?php
namespace App\Http\Controllers;
use Helper;
use View;
use Illuminate\Http\Request;
use Cache;
use Session;
use App\products;
use App\wishlists;
use App\imagetable;
use App\Http\Controllers\Controller;
use Auth;
use DB;
class WishlistController extends Controller
{
	 public function __construct()
    {
        //$this->middleware('auth');

        $logo = imagetable::
                     select('img_path')
                     ->where('table_name','=','logo')
                     ->first();
             
		$favicon = imagetable::
                     select('img_path')
                     ->where('table_name','=','favicon')
                     ->first();	

        //$profile = Profile::where('user_id', Auth::user()->id)->first();

		View()->share('logo',$logo);
		View()->share('favicon',$favicon);

    }
	public function add()
    {
		if(Auth::check()){
			//$data = array();
			if($_POST['status'] == 'checked' ){
				$wishlistRemove=$this->remove($_POST['productId']);
				$wish = json_decode($wishlistRemove);
				if($wish->status == 1)
					$data=['message'=>'product remove from wishlist','status'=>'unchecked'];
				/*else
					$data=['message'=>'Login Before removing to wishlist','status'=>'error'];*/
			}
			else{
				$wishlist =	new wishlists;
				$wishlist->product_id = $_POST['productId'];
				$wishlist->user_id = Auth::user()->id;
				$wishlist->save();
				$data=['message'=>'Product Added to wishlist','status'=>'checked'];	
			}
		}
		else
			$data=['message'=>'Login Before adding/removing to wishlist','status'=>'error'];	
		
		return json_encode($data);		
	}
	
	public function remove($product_id=''){
		if(Auth::check())
		{
			if(isset($_POST['product_id']) and !empty($_POST['product_id']))
				$product_id = $_POST['product_id'];
			if($product_id != "")
			{
				wishlists::where(['product_id'=>$product_id,'user_id'=>Auth::user()->id])->delete();
				return json_encode(array("status"=>1,"data"=>'success'));
			}
		}
		else
			return;
	}

    public function index2(){
		
        $wishlist=wishlist::where('user_id',Auth::user()->id)->orderBy('id','desc')->paginate(12);
		return view('customer.wishlist')->with('title','Wishlist')->with('wishlistActive',true)->with(compact('wishlist'));
    }
}