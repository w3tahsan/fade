@extends('layouts.dashboard')
@section('content')
<div class="page-titles">
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0)">Coupon</a></li>
    </ol>
</div>
@can('add_coupon')
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-primary">
                <h3 class="text-white">Coupon List</h3>
            </div>
            @if (session('delete'))
                <div class="alert alert-success">{{ session('delete') }}</div>
            @endif
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th>SL</th>
                        <th>Coupon Name</th>
                        <th>Coupon Type</th>
                        <th>Amount</th>
                        <th>Validity</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($coupons as $key=>$coupon)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $coupon->coupon_name }}</td>
                            <td>{{ ($coupon->type == 1?'Fixed Amount':'Percentage') }}</td>
                            <td>{{ $coupon->amount }}</td>
                            <td>{{ $coupon->validity }}</td>
                            <td>
                                <a href="}" class="btn btn-danger btn-xs sharp"><i class="fa fa-trash"></i></a>
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
                <h3 class="text-white">Add Coupon</h3>
            </div>
            <div class="card-body">
                <form action="{{route('coupon.store')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="" class="form-label">Coupon Name</label>
                        <input type="text" class="form-control" name="coupon_name">
                        @error('coupon_name')
                            <strong class="text-danger">{{$message }}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <select name="type" class="form-control">
                            <option value="">Select Type</option>
                            <option value="1">Solid Amount</option>
                            <option value="2">Percentage</option>
                        </select>
                        @error('coupon_type')
                            <strong class="text-danger">{{$message }}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Amounte</label>
                        <input type="number" class="form-control" name="amount">
                        @error('amount')
                            <strong class="text-danger">{{$message }}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="" class="form-label">Validity</label>
                        <input type="date" class="form-control" name="validity">
                        @error('validity')
                            <strong class="text-danger">{{$message }}</strong>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <button type="submit" class="btn btn-primary">Add Coupon</button>
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
