@extends('frontend.master')
@section('content')
<!-- breadcrumb_section - start
================================================== -->
<div class="breadcrumb_section">
    <div class="container">
        <ul class="breadcrumb_nav ul_li">
            <li><a href="index.html">Home</a></li>
            <li>404 Error</li>
        </ul>
    </div>
</div>
<!-- breadcrumb_section - end
================================================== -->

<!-- start error-404-section -->
<section class="error-404-section section_space">
    <div class="container">
        <div class="error-404-area">
            <h2>404</h2>
            <div class="error-message">
                <h3>Oops! Page Not Found!</h3>
                <p>We’re sorry but we can’t seem to find the page you requested. This might be because you have
                typed the web address incorrectly.</p>
                <a href="index.html" class="btn btn_primary">Back to home</a>
            </div>
        </div>
    </div>
</section>
<!-- end error-404-section -->
@endsection