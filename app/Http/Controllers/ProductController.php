<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use App\Models\Thumbnail;
use App\Models\Color;
use App\Models\Inventory;
use App\Models\Size;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Str;
use Image;

class ProductController extends Controller
{
    function add_product(){
        $categories = Category::all();
        $subcategories = Subcategory::all();
        return view('admin.product.index', [
            'categories'=>$categories,
            'subcategories'=>$subcategories,
        ]);
    }

    function getSubcategory(Request $request){
        $subcategories = Subcategory::where('category_id', $request->category_id)->get();
        $str='<option value="">-- select subcategory --</option>';
        foreach ($subcategories as $subcategory){
            $str .= "<option value='$subcategory->id'>$subcategory->subcategory_name</option>";
        }
        echo $str;
    }

    function product_store(Request $request){

        $name =  str_replace(' ', '-', $request->product_name);
        $slug = Str::lower($name).'-'.random_int(10000,90000);
        $product_id = Product::insertGetId([
            'category_id'=>$request->category_id,
            'subcategory_id'=>$request->subcategory_id,
            'product_name'=>$request->product_name,
            'slug'=>$slug,
            'product_price'=>$request->product_price,
            'discount'=>$request->discount,
            'after_discount'=>$request->product_price - ($request->product_price*$request->discount/100),
            'brand'=>$request->brand,
            'short_desp'=>$request->short_desp,
            'long_desp'=>$request->long_desp,
            'created_at'=>Carbon::now(),
        ]);

        $preview = $request->preview;
        $extension = $preview->getClientOriginalextension();

        $file_name = Str::lower($name).'-'.random_int(100,999).'.'.$extension;

        Image::make($preview)->resize(680,680)->save(public_path('/uploads/product/preview/'.$file_name));

        Product::find($product_id)->update([
            'preview'=>$file_name,
        ]);

        $thumbnails = $request->thumbnails;
        foreach ($thumbnails as $thumbnail){
            $thumbnail_extension = $thumbnail->getClientOriginalextension();
            $thumb_file_name = Str::lower($name).'-'.random_int(100,999).'.'.$thumbnail_extension;
            Image::make($thumbnail)->resize(680,680)->save(public_path('/uploads/product/thumbnail/'.$thumb_file_name));

            Thumbnail::insert([
                'product_id'=>$product_id,
                'thumbnail'=>$thumb_file_name,
                'created_at'=>Carbon::now(),
            ]);
        }

        return back()->with('success', 'Product Added!');
    }

    function product_list(){
        $all_products = Product::all();
        return view('admin.product.product_list', [
            'all_products'=>$all_products,
        ]);
    }

    function color_size(){
        $colors = Color::all();
        $sizes = Size::all();
        return view('admin.product.color_size', [
            'colors'=>$colors,
            'sizes'=>$sizes,
        ]);
    }
    function add_color(Request $request){
        Color::insert([
            'color_name'=>$request->color_name,
            'color_code'=>$request->color_code,
            'created_at'=>Carbon::now(),
        ]);
        return back();
    }
    function add_size(Request $request){
        Size::insert([
            'size_name'=>$request->size_name,
            'created_at'=>Carbon::now(),
        ]);
        return back();
    }

    function inventory($product_id){
        $product_info = Product::find($product_id);
        $colors = Color::all();
        $sizes = Size::all();
        $inventories = Inventory::where('product_id', $product_id)->get();
        return view('admin.product.inventory', [
            'product_info'=>$product_info,
            'colors'=>$colors,
            'sizes'=>$sizes,
            'inventories'=>$inventories,
        ]);
    }

    function add_inventory(Request $request){
        if(Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->exists()){
            Inventory::where('product_id', $request->product_id)->where('color_id', $request->color_id)->where('size_id', $request->size_id)->increment('quantity', $request->quantity);
            return back();
        }
        else{
            Inventory::insert([
                'product_id'=>$request->product_id,
                'color_id'=>$request->color_id,
                'size_id'=>$request->size_id,
                'quantity'=>$request->quantity,
                'created_at'=>Carbon::now(),
            ]);
            return back();
        }
    }

}
