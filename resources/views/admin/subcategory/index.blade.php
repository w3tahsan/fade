@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)">Category</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)">Edit category</a></li>
    </ol>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="text-white">Subcategory list</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th>Sl</th>
                        <th>category_name</th>
                        <th>subcategory_name</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($subcategory as $key=>$subcategory)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $subcategory->rel_to_category->category_name }}</td>
                        <td>{{ $subcategory->subcategory_name }}</td>
                        <td>
                            <a href="{{ route('subcategory.edit', $subcategory->id) }}" class="btn btn-success btn-xs sharp"><i class="fa fa-pencil"></i></a>
                            <a href="{{ route('subcategory.delete', $subcategory->id) }}" class="btn btn-danger btn-xs sharp"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="text-white">Add Sub Category</h3>
            </div>

            <div class="card-body">
                <form action="{{ route('subcategory.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <select name="category_id" class="form-control">
                            <option value="">-- Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Subcategory Name</label>
                        <input type="text" name="subcategory_name" class="form-control">
                        @error('subcategory_name')
                            <strong class="text-danger">{{ $message }}</strong>
                        @enderror
                        @if (session('exist'))
                            <div class="alert alert-danger">{{ session('exist') }}</div>
                        @endif
                    </div>
                    <div class="mb-3">
                        <button class="btn btn-primary">Add Subcategory</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
