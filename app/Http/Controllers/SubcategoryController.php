<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    function subcategory(){
        $categories = Category::all();
        $subcategory = Subcategory::all();
        return view('admin.subcategory.index', [
            'categories'=>$categories,
            'subcategory'=>$subcategory,
        ]);
    }

    function subcategory_store(Request $request){

        $request->validate([
            'category_id'=>'required',
            'subcategory_name'=>'required',
        ]);

        if(Subcategory::where('category_id', $request->category_id)->where('subcategory_name', $request->subcategory_name)->exists()){
            return back()->with('exist', 'Subcategory name already exist in this catergory');
        }
        else{
            Subcategory::insert([
                'category_id'=>$request->category_id,
                'subcategory_name'=>$request->subcategory_name,
                'created_at'=>Carbon::now(),
            ]);
            return back()->with('success', 'subcategory added!');
        }
    }

    function subcategory_edit($subcategory_id){
        $categories = Category::all();
        $subcategory_info = Subcategory::find($subcategory_id);
        return view('admin.subcategory.edit', [
            'categories'=>$categories,
            'subcategory_info'=>$subcategory_info,
        ]);
    }

    function subcategory_update(Request $request){
        if(Subcategory::where('category_id', $request->category_id)->where('subcategory_name', $request->subcategory_name)->exists()){
            return back()->with('exist', 'Subcategory name already exist in this catergory');
        }
        else{
           Subcategory::where('id', $request->subcategory_id)->update([
            'category_id'=>$request->category_id,
            'subcategory_name'=>$request->subcategory_name,
           ]);
           return redirect()->route('subcategory');
        }
    }

    function subcategory_delete($subcategory_id){
        Subcategory::find($subcategory_id)->delete();
        return back();
    }

}
