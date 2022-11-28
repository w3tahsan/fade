@extends('layouts.dashboard')

@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)">Add Product</a></li>
    </ol>
</div>
@can('add_product')
<div class="row">
    <div class="col-lg-10 m-auto">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="text-white">Add Product</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('product.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <select name="category_id" id="category_id" class="form-control">
                                    <option value="">-- select category --</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <select name="subcategory_id" id="subcategory_id" class="form-control">
                                    <option value="">-- select sub category --</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <input type="text" name="product_name" class="form-control" placeholder="Product Name">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <input type="number" name="product_price" class="form-control" placeholder="Product Price">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <input type="number" name="discount" class="form-control" placeholder="Product Discount">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <input type="text" name="brand" class="form-control" placeholder="Product Brand">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <input type="text" name="short_desp" class="form-control" placeholder="Short Description">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3">
                                <textarea name="long_desp" id="summernote" class="form-control" placeholder="Long Description"></textarea>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="" class="form-label">Preview</label>
                               <input type="file" name="preview" class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="mb-3">
                                <label for="" class="form-label">Thumbnails</label>
                               <input type="file" name="thumbnails[]" multiple class="form-control">
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <div class="mb-3 mt-2 text-center">
                               <button type="submit" class="btn btn-primary">Add Product</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@else
    <div class="alert alert-warning"><b>You don't have authentication for feature</b></div>
@endcan
@endsection

@section('footer_script')
<script>
    $(document).ready(function() {
        $('#summernote').summernote();
    });
</script>
<script>
    $('#category_id').change(function(){
        var category_id = $(this).val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            type:'POST',
            url:'/getSubcategory',
            data:{'category_id':category_id},
            success:function(data){
                $('#subcategory_id').html(data);
            }
        });

    })
</script>
@if (session('success'))
    <script>
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: '{{ session('success') }}',
            showConfirmButton: false,
            timer: 1500
            })
    </script>
@endif
@endsection
