@extends('frontend.master')


@section('content')
<!-- breadcrumb_section - start
================================================== -->
<div class="breadcrumb_section">
    <div class="container">
        <ul class="breadcrumb_nav ul_li">
            <li><a href="index.html">Home</a></li>
            <li>Password Reset Form</li>
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
                    <h3 class="text-white">Password Reset Form</h3>
                </div>
                <div class="card-body">
                    <form action="{{route('pass.reset.update')}}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="" class="form-label">New Password</label>
                            <input type="hidden" class="form-control" name="reset_token" value="{{$data}}">
                            <input type="password" class="form-control" name="password">
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
