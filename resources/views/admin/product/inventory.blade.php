@extends('layouts.dashboard')
@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)">Inventory</a></li>
    </ol>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3>Inventory List</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th>Sl</th>
                        <th>Color</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($inventories as $key=>$inventory)
                    <tr>
                        <td>{{ $key+1 }}</td>
                        <td>{{ $inventory->rel_to_color->color_name}}</td>
                        <td>{{ $inventory->rel_to_size->size_name}}</td>
                        <td>{{ $inventory->quantity }}</td>
                        <td>
                            <a href="" class="btn btn-danger btn-xs sharp"><i class="fa fa-trash"></i></a>
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h3>Add Inventory</h3>
            </div>
            <div class="card-body">
                <form action="{{ route('add.inventory') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <input type="hidden" class="form-control" name="product_id" value="{{ $product_info->id }}">
                        <input type="text" readonly class="form-control" value="{{ $product_info->product_name }}">
                    </div>
                    <div class="mb-3">
                        <select name="color_id" class="form-control">
                            <option value="">-- Select Color --</option>
                            @foreach ($colors as $color)
                                <option value="{{ $color->id }}">{{ $color->color_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <select name="size_id" class="form-control">
                            <option value="">-- Select size --</option>
                            @foreach ($sizes as $size)
                                <option value="{{ $size->id }}">{{ $size->size_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <input type="text" class="form-control" name="quantity" placeholder="Quantity">
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Inventory</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
