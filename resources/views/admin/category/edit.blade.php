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
    <div class="col-lg-6 m-auto">
        <div class="card">
            @if (session('updated'))
                <div class="alert alert-success">{{session('updated')}}</div>
            @endif
            <div class="card-header bg-primary">
                <h3 class="text-white">Edit Category</h3>
            </div>
            <div class="card-body">
                <form action="{{route('category.update')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Category Name</label>
                        <input type="hidden" value="{{ $category_info->id }}" name="category_id">
                        <input type="text" class="form-control" value="{{ $category_info->category_name }}" name="category_name">
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Category Image</label>
                        <input type="file" class="form-control" name="category_image" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                        <img src="{{ asset('uploads/category') }}/{{ $category_info->category_image }}" id="blah" alt="" width="200">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Update Category</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
