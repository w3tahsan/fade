<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Image;

class CategoryController extends Controller
{
    function category(){
        $all_categories = Category::all();
        $trashed_catgories = Category::onlyTrashed()->get();
        return view('admin.category.index', [
            'all_categories'=>$all_categories,
            'trashed_catgories'=>$trashed_catgories,
        ]);
    }

    function store(CategoryRequest $request){

        $category_id = Category::insertGetId([
            'category_name'=>$request->category_name,
            'added_by'=>Auth::id(),
            'created_at'=>Carbon::now(),
        ]);

        $category_image = $request->category_image;
        $extension = $category_image->getClientOriginalExtension();
        $file_name = $category_id.'.'.$extension;

        Image::make($category_image)->save(public_path('uploads/category/'.$file_name));

        Category::where('id', $category_id)->update([
            'category_image'=>$file_name,
        ]);

        return back()->with('success', 'Category Added!');
    }

    function delete($category_id){
        Category::find($category_id)->delete();
        return back()->with('delete', 'Category Deleted Successfully');
    }
    function hard_delete($category_id){
        $image = Category::onlyTrashed()->find($category_id);
        $delete_from = public_path('/uploads/category/'.$image->category_image);
        unlink($delete_from);
        Category::onlyTrashed()->find($category_id)->forceDelete();
        return back()->with('hard_delete', 'Category Deleted Successfully');
    }

    function category_restore($category_id){
        Category::onlyTrashed()->find($category_id)->restore();
        return back()->with('restore', 'Category restored Successfully');
    }

    function category_edit($category_id){
        $category_info = Category::find($category_id);
        return view('admin.category.edit', [
            'category_info'=>$category_info,
        ]);
    }

    function category_update(Request $request){
        if($request->category_image == ''){
            Category::find($request->category_id)->update([
                'category_name'=>$request->category_name,
            ]);
            return back()->with('updated', 'Category Updated Successfully');
        }
        else{
            $image = Category::find($request->category_id);
            $delete_from = public_path('/uploads/category/'.$image->category_image);
            unlink($delete_from);

            $category_image = $request->category_image;
            $extension = $category_image->getClientOriginalExtension();
            $file_name = $request->category_id.'.'.$extension;
            Image::make($category_image)->save(public_path('uploads/category/'.$file_name));
            Category::find($request->category_id)->update([
                'category_name'=>$request->category_name,
                'category_image'=>$file_name,
            ]);

            return back()->with('updated', 'Category Updated Successfully');

        }
    }

}
