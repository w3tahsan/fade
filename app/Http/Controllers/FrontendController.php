<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Inventory;
use App\Models\Product;
use App\Models\Thumbnail;
use App\Models\Cart;
use App\Models\Color;
use App\Models\Order;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\OrderProduct;
use App\Models\Size;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cookie;
use Arr;

class FrontendController extends Controller
{
    function welcome(){

        $all_products = Product::orderBy('created_at', 'DESC')->get();
        $categories = Category::all();
        $new_arrivals = Product::latest()->take(4)->get();
        $best_selling = OrderProduct::groupBy('product_id')
        ->selectRaw('sum(quantity) as sum, product_id')
        ->orderBy('quantity','DESC')
        ->havingRaw('sum >= 3')
        ->get();

        $get_recent = json_decode(Cookie::get('recent_view'), true);
        if($get_recent == null){
            $get_recent = [];
            $after_unique = array_unique($get_recent);
        }
        else{
            $after_unique = array_unique($get_recent);
        }
        $all_recent_product = Product::find($after_unique);

        return view('frontend.index', [
            'all_products'=>$all_products,
            'categories'=>$categories,
            'new_arrivals'=>$new_arrivals,
            'best_selling'=>$best_selling,
            'all_recent_product'=>$all_recent_product,
        ]);
    }

    function product_details($product_slug){
        $product_info = Product::where('slug', $product_slug)->get();
        $thumnails = Thumbnail::where('product_id', $product_info->first()->id)->get();
        $related_products = Product::where('category_id', $product_info->first()->category_id)->where('id', '!=', $product_info->first()->id)->get();
        $available_colors = Inventory::where('product_id', $product_info->first()->id)->groupBy('color_id')->selectRaw('sum(color_id) as sum,color_id')->get();

        $reviews = OrderProduct::where('product_id', $product_info->first()->id)->whereNotNull('review')->get();
        $total_review = OrderProduct::where('product_id', $product_info->first()->id)->whereNotNull('review')->count();
        $total_star = OrderProduct::where('product_id', $product_info->first()->id)->whereNotNull('review')->sum('star');
        $product_id = $product_info->first()->id;

        $al = Cookie::get('recent_view');
        if(!$al){
            $al = "[]";
        }

        $all_info = json_decode($al, true);
        $all_info = Arr::prepend($all_info, $product_id);
        $recent_product_id = json_encode($all_info);

        Cookie::queue('recent_view', $recent_product_id, 1000);

        return view('frontend.product_details', [
            'product_info'=>$product_info,
            'thumnails'=>$thumnails,
            'related_products'=>$related_products,
            'available_colors'=>$available_colors,
            'reviews'=>$reviews,
            'total_review'=>$total_review,
            'total_star'=>$total_star,
        ]);
    }

    function getSize(Request $request){
        $str = '<option value="" class="colr_id" data-col="'.$request->color_id.'">Choose A Option</option>';
        $sizes = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->get();
        foreach($sizes as $size){
            $str .= '<option value="'.$size->size_id.'">'.$size->rel_to_size->size_name.'</option>';
        }
        echo $str;
    }
    function cart(Request $request){
        $coupon = $request->coupon;
        $message = null;
        $type = null;

        if($coupon == ''){
            $discount = 0;
        }
        else{
            if(Coupon::where('coupon_name', $coupon)->exists()){
                if(Carbon::now()->format('Y-m-d') > Coupon::where('coupon_name', $coupon)->first()->validity){
                    $message = 'Coupon Code Expired';
                    $discount = 0;
                }
                else{
                    $discount = Coupon::where('coupon_name', $coupon)->first()->amount;
                    $type = Coupon::where('coupon_name', $coupon)->first()->type;
                }
            }
            else{
                $message = 'Invalid Coupon Code';
                $discount = 0;
            }
        }

        $carts = Cart::where('customer_id', Auth::guard('customerlogin')->id())->get();
        return view('frontend.cart', [
            'carts'=>$carts,
            'discount'=>$discount,
            'message'=>$message,
            'type'=>$type,
        ]);
    }

    function checkout(){
        $countries = Country::all();
        return view('frontend.checkout', [
            'countries'=>$countries,
        ]);
    }

  function account(){
    $orders = Order::where('customer_id', Auth::guard('customerlogin')->id())->get();
    return view('frontend.account', [
        'orders'=>$orders,
    ]);
  }

  function shop(Request $request){
    $data = $request->all();

    $term = 'created_at';
    $order= 'DESC';

    if(!empty($data['sort']) && $data['sort'] != '' && $data['sort'] != 'undefined'){
        if($data['sort'] == 1){
            $term = 'product_name';
            $order = 'ASC';
        }
        else if($data['sort'] == 2){
            $term = 'product_name';
            $order = 'DESC';
        }
        else if($data['sort'] == 3){
            $term = 'after_discount';
            $order = 'ASC';
        }
        else if($data['sort'] == 4){
            $term = 'after_discount';
            $order = 'DESC';
        }
        else{
            $term = 'created_at';
            $order= 'DESC';
        }

    }


    $all_products = Product::where(function($q) use ($data){
        if(!empty($data['q']) && $data['q'] != '' && $data['q'] != 'undefined'){
            $q->where(function ($q) use ($data){
                $q->where('product_name', 'like', '%'.$data['q'].'%');
                $q->orWhere('long_desp', 'like', '%'.$data['q'].'%');
            });
        }
        if(!empty($data['category']) && $data['category'] != '' && $data['category'] != 'undefined'){
            $q->where('category_id', $data['category']);
        }
        if(!empty($data['min']) && $data['min'] != '' && $data['min'] != 'undefined' || !empty($data['max']) && $data['max'] != '' && $data['max'] != 'undefined'){
            $q->whereBetween('after_discount', [$data['min'], $data['max']]);
        }
        if(!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id'] != 'undefined' || !empty($data['size_id']) && $data['size_id'] != '' && $data['size_id'] != 'undefined'){
            $q->whereHas('rel_to_inventories', function ($q) use ($data){
                if(!empty($data['color_id']) && $data['color_id'] != '' && $data['color_id'] != 'undefined'){
                    $q->whereHas('rel_to_color', function ($q) use ($data){
                        $q->where('colors.id', $data['color_id']);
                    });
                }
                if(!empty($data['size_id']) && $data['size_id'] != '' && $data['size_id'] != 'undefined'){
                    $q->whereHas('rel_to_size', function ($q) use ($data){
                        $q->where('sizes.id', $data['size_id']);
                    });
                }
            });
        }
    })->orderBy($term, $order)->get();

    $categories = Category::all();
    $colors = Color::all();
    $sizes = Size::all();
    return view('frontend.shop', [
        'all_products'=>$all_products,
        'categories'=>$categories,
        'colors'=>$colors,
        'sizes'=>$sizes,
    ]);
  }


  function getStock(Request $request){
    $quantity = Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->first()->quantity;
    if($quantity == 0){
        echo '<button class="btn bg-warning">Out of Stock</button>';
    }
    else{
        echo '<h3 class="text-danger">Stock:'.$quantity.' </h3><button class="btn btn_primary addtocart_btn" type="submit">Add To Cart</button>';
    }
  }


}
