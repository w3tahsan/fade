@extends('frontend.master')


@section('content')
<!-- breadcrumb_section - start
================================================== -->
<div class="breadcrumb_section">
    <div class="container">
        <ul class="breadcrumb_nav ul_li">
            <li><a href="index.html">Home</a></li>
            <li>Password Reset Request Form</li>
        </ul>
    </div>
</div>
<!-- breadcrumb_section - end
================================================== -->

<div class="container">
    <div class="row">
        <div class="col-lg-6 m-auto my-5">
            <div class="card">
                <div class="card-header bg-primary">
                    <h3 class="text-white">Password Reset Request</h3>
                </div>
                @if (session('reset'))
                    <div class="alert alert-success">{{session('reset')}}</div>
                @endif
                <div class="card-body">
                    <form action="{{route('pass.reset.req.send')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="form-label">Email Address</label>
                            <input type="email" class="form-control" name="email">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
