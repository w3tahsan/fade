@extends('layouts.dashboard')
@section('content')
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h3>Order List</h3>
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <tr>
                        <th>SL</th>
                        <th>Order ID</th>
                        <th>Sub Total</th>
                        <th>Discount</th>
                        <th>Charge</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                    @foreach ($orders as $key=>$order)
                    <tr>
                        <td>{{$key+1}}</td>
                        <td>{{$order->id}}</td>
                        <td>TK {{$order->sub_total}}</td>
                        <td>TK {{$order->discount}}</td>
                        <td>TK {{$order->delivery}}</td>
                        <td>TK {{$order->total}}</td>
                        <td>
                            @php
                                if($order->status == 1){
                                    echo '<span class="badge badge-info">Placed</span>';
                                }
                                else if($order->status == 2){
                                    echo '<span class="badge badge-secondary">Processing</span>';
                                }
                                else if($order->status == 3){
                                    echo '<span class="badge badge-warning">Ready to Deliver</span>';
                                }
                                else if($order->status == 4){
                                    echo '<span class="badge badge-success">Delivered</span>';
                                }
                                else if($order->status == 5){
                                    echo '<span class="badge badge-danger">Cancel</span>';
                                }
                                else{
                                    echo 'Unknown';
                                }
                            @endphp
                        </td>
                        <td>
                            <div class="dropdown">
                            <form action="{{route('order.status')}}" method="POST">
                                @csrf
                                <button type="button" class="btn btn-success light sharp" data-toggle="dropdown">
                                    <svg width="20px" height="20px" viewBox="0 0 24 24" version="1.1"><g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"><rect x="0" y="0" width="24" height="24"/><circle fill="#000000" cx="5" cy="12" r="2"/><circle fill="#000000" cx="12" cy="12" r="2"/><circle fill="#000000" cx="19" cy="12" r="2"/></g></svg>
                                </button>
                                <div class="dropdown-menu">
                                    <button value="{{$order->id.','.'1'}}" name="status" class="dropdown-item status">Placed</button>
                                    <button value="{{$order->id.','.'2'}}" name="status" class="dropdown-item status">Processing</button>
                                    <button value="{{$order->id.','.'3'}}" name="status" class="dropdown-item status">Ready to Deliver</button>
                                    <button value="{{$order->id.','.'4'}}" name="status" class="dropdown-item status">Delivered</button>
                                    <button value="{{$order->id.','.'5'}}" name="status" class="dropdown-item status">Cancel</button>
                                </div>

                            </div>
                        </td>
                    </tr>
                    @endforeach
                </form>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
