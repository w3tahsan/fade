@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)">category</a></li>
    </ol>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="text-white">Category List</h3>
            </div>
            @if (session('delete'))
                <div class="alert alert-success">{{ session('delete') }}</div>
            @endif
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th>SL</th>
                        <th>Category Name</th>
                        <th>Sub Category</th>
                        <th>Category Image</th>
                        <th>Added By</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($all_categories as $key=>$category)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$category->category_name}}</td>
                        <td>
                           @foreach (App\Models\Subcategory::where('category_id', $category->id)->get() as $sub)
                            {{$sub->subcategory_name}},
                           @endforeach
                        </td>
                        <td><img width="50" src="{{asset('uploads/category')}}/{{$category->category_image}}" alt=""></td>
                        <td>{{$category->rel_to_user->email}}</td>
                        <td>
                            <a href="{{ route('category.edit', $category->id) }}" class="btn btn-success btn-xs sharp"><i class="fa fa-pencil"></i></a>
                            <a href="{{ route('category.delete', $category->id) }}" class="btn btn-danger btn-xs sharp"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>

        <div class="card">
            @if (session('hard_delete'))
                <div class="alert alert-success">{{ session('hard_delete') }}</div>
            @endif
            @if (session('restore'))
                <div class="alert alert-success">{{ session('restore') }}</div>
            @endif
            <div class="card-header bg-primary">
                <h3 class="text-white">Trashed Category List</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th>SL</th>
                        <th>Category Name</th>
                        <th>Category Image</th>
                        <th>Added By</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($trashed_catgories as $key=>$category)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$category->category_name}}</td>
                        <td><img width="50" src="{{asset('uploads/category')}}/{{$category->category_image}}" alt=""></td>
                        <td>{{$category->rel_to_user->email}}</td>
                        <td>
                            <a href="{{ route('category.restore', $category->id) }}" class="btn btn-info btn-xs sharp"><i class="fa fa-undo"></i></a>
                            <a href="{{ route('category.hard.delete', $category->id) }}" class="btn btn-danger btn-xs sharp"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>

    </div>
    <div class="col-lg-4">
        <div class="card">
            @if (session('success'))
                <div class="alert alert-success">{{session('success')}}</div>
            @endif
            <div class="card-header bg-primary">
                <h3 class="text-white">Add Category</h3>
            </div>
            <div class="card-body">
                <form action="{{route('category.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Category Name</label>
                        <input type="text" class="form-control" name="category_name">
                        @error('category_name')
                            <strong class="text-danger">{{$message }}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Category Image</label>
                        <input type="file" class="form-control" name="category_image">
                        @error('category_image')
                            <strong class="text-danger">{{$message }}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
