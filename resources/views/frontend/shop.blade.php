@extends('frontend.master')

@section('content')
 <!-- breadcrumb_section - start
================================================== -->
<div class="breadcrumb_section">
    <div class="container">
        <ul class="breadcrumb_nav ul_li">
            <li><a href="index.html">Home</a></li>
            <li>Product Grid</li>
        </ul>
    </div>
</div>
<!-- breadcrumb_section - end
================================================== -->

<!-- product_section - start
================================================== -->
<section class="product_section section_space">
    <h2 class="hidden">Product sidebar</h2>
    <div class="container">
        <div class="row">
            <div class="col-lg-3">
                <aside class="sidebar_section p-0 mt-0">

                    <div class="sb_widget">
                        <h3 class="sb_widget_title">Your Filter</h3>
                        <div class="filter_sidebar">

                            <div class="fs_widget">
                                <h4>Filter By Price</h4>

                                    <div class="row">
                                        <div class="col-lg-6">
                                            <input type="text" id="min" placeholder="Min" name="min" class="form-control" value="{{@$_GET['min']}}">
                                        </div>
                                        <div class="col-lg-6">
                                            <input type="text" id="max" placeholder="Max" name="max" class="form-control"  value="{{@$_GET['max']}}">
                                        </div>
                                        <div class="col-lg-12 text-center mt-3">
                                            <button id="range" class="btn btn-secondary rounded-0 form-control" type="submit">Submit</button>
                                        </div>

                                    </div>

                            </div>
                            <div class="fs_widget">
                                <h4>Filter By Category</h4>
                                    <ul class="fs_brand_list ul_li_block">
                                        @foreach ($categories as $category)
                                        <li>
                                            <div class="checkbox_item">
                                                <input id="category{{$category->id}}" class="category_id" value="{{$category->id}}" type="radio" name="category"
                                                    @if (isset($_GET['category']))
                                                        @if ($_GET['category'] == $category->id)
                                                            checked
                                                        @endif
                                                    @endif
                                                >
                                                <label for="category{{$category->id}}">{{$category->category_name}}</span></label>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                            </div>
                            <div class="fs_widget">
                                <h3 class="fs_widget_title">Color</h3>
                                    <ul class="fs_brand_list ul_li_block">
                                        @foreach ($colors as $color)
                                        <li>
                                            <div class="checkbox_item">
                                                <input name="color" class="color_id" id="color{{$color->id}}" value="{{$color->id}}" type="radio"
                                                @if (isset($_GET['color_id']))
                                                    @if ($_GET['color_id'] == $color->id)
                                                        checked
                                                    @endif
                                                @endif
                                                >
                                                <label for="color{{$color->id}}">{{$color->color_name}}</span></label>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                            <div class="fs_widget">
                                <h3 class="fs_widget_title">Size</h3>
                                    <ul class="fs_brand_list ul_li_block">
                                        @foreach ($sizes as $size)
                                        <li>
                                            <div class="checkbox_item">
                                                <input name="size" class="size_id" id="size{{$size->id}}" value="{{$size->id}}" type="radio"
                                                @if (isset($_GET['size_id']))
                                                        @if ($_GET['size_id'] == $size->id)
                                                            checked
                                                        @endif
                                                    @endif
                                                >
                                                <label for="size{{$size->id}}">{{$size->size_name}}</span></label>
                                            </div>
                                        </li>
                                        @endforeach
                                    </ul>
                                </div>
                        </div>
                </aside>
            </div>

            <div class="col-lg-9">
                <div class="filter_topbar">
                    <div class="row align-items-center">
                        <div class="col col-md-4">
                            <ul class="layout_btns nav" role="tablist">
                                <li>
                                    <button class="active" data-bs-toggle="tab" data-bs-target="#home" type="button" role="tab" aria-controls="home" aria-selected="true"><i class="fal fa-bars"></i></button>
                                </li>
                                <li>
                                    <button data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">
                                        <i class="fal fa-th-large"></i>
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <div class="col col-md-4">
                            <form action="#">
                                <div class="select_option clearfix">
                                    <select class="sort">
                                        <option value="">Select Your Option</option>
                                        <option value="1">Sorting By (A-Z)</option>
                                        <option value="2">Sorting By (Z-A)</option>
                                        <option value="3">Sorting By Price (Low - Hight)</option>
                                        <option value="4">Sorting By Price (Hight - Low)</option>
                                    </select>
                                </div>
                            </form>
                        </div>

                        <div class="col col-md-4">
                            <div class="result_text">Showing 1-12 of 30 relults</div>
                        </div>
                    </div>
                </div>

                <hr />

                <div class="tab-content">
                    <div class="tab-pane fade show active" id="home" role="tabpanel">
                        <div class="shop-product-area shop-product-area-col">
                            <div class="product-area shop-grid-product-area clearfix row">

                                @foreach ($all_products as $product)
                                <div class="grid col-lg-4">
                                    <div class="product-pic">
                                        <img src="{{asset('uploads/product/preview')}}/{{$product->preview}}" alt />
                                    </div>
                                    <div class="details">
                                        <h4><a href="#">{{$product->product_name}}</a></h4>
                                        <p><a href="#">{{$product->short_desp}}</a></p>
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                        </div>
                                        <span class="price">
                                            <ins>
                                                <span class="woocommerce-Price-amount amount">
                                                    <bdi> <span class="woocommerce-Price-currencySymbol">{{$product->after_discount}}</bdi>
                                                </span>
                                            </ins>
                                        </span>
                                        <div class="add-cart-area">
                                            <button class="add-to-cart">Add to cart</button>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="pagination_wrap">
                            <ul class="pagination_nav">
                                <li class="active"><a href="#!">01</a></li>
                                <li><a href="#!">02</a></li>
                                <li><a href="#!">03</a></li>
                                <li class="prev_btn">
                                    <a href="#!"><i class="fal fa-angle-left"></i></a>
                                </li>
                                <li class="next_btn">
                                    <a href="#!"><i class="fal fa-angle-right"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="profile" role="tabpanel">
                        <div class="product_layout2_wrap">
                            <div class="product-area-row">
                                <div class="grid clearfix">
                                    <div class="product-pic">
                                        <img src="assets/images/shop/product_img_12.png" alt />
                                    </div>
                                    <div class="details">
                                        <h4><a href="#">Macbook Pro</a></h4>
                                        <p><a href="#">Apple MacBook Pro13.3″ Laptop with Touch ID </a></p>
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                        </div>
                                        <span class="price">
                                            <ins>
                                                <span class="woocommerce-Price-amount amount">
                                                    <bdi> <span class="woocommerce-Price-currencySymbol">$</span>471.48 </bdi>
                                                </span>
                                            </ins>
                                        </span>
                                        <div class="add-cart-area">
                                            <button class="add-to-cart">Add to cart</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid clearfix">
                                    <div class="product-pic">
                                        <img src="assets/images/shop/product-img-21.png" alt />
                                        <span class="theme-badge">Sale</span>
                                    </div>
                                    <div class="details">
                                        <h4><a href="#">Apple Watch</a></h4>
                                        <p><a href="#">Apple Watch Series 7 case Pair any band </a></p>
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                        </div>
                                        <span class="price">
                                            <ins>
                                                <span class="woocommerce-Price-amount amount">
                                                    <bdi> <span class="woocommerce-Price-currencySymbol">$</span>471.48 </bdi>
                                                </span>
                                            </ins>
                                        </span>
                                        <div class="add-cart-area">
                                            <button class="add-to-cart">Add to cart</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid clearfix">
                                    <div class="product-pic">
                                        <img src="assets/images/shop/product-img-22.png" alt />
                                        <span class="theme-badge-2">12% off</span>
                                    </div>
                                    <div class="details">
                                        <h4><a href="#">Mac Mini</a></h4>
                                        <p><a href="#">Apple MacBook Pro13.3″ Laptop with Touch ID </a></p>
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                        </div>
                                        <span class="price">
                                            <ins>
                                                <span class="woocommerce-Price-amount amount">
                                                    <bdi> <span class="woocommerce-Price-currencySymbol">$</span>471.48 </bdi>
                                                </span>
                                            </ins>
                                            <del aria-hidden="true">
                                                <span class="woocommerce-Price-amount amount">
                                                    <bdi> <span class="woocommerce-Price-currencySymbol">$</span>904.21 </bdi>
                                                </span>
                                            </del>
                                        </span>
                                        <div class="add-cart-area">
                                            <button class="add-to-cart">Add to cart</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid clearfix">
                                    <div class="product-pic">
                                        <img src="assets/images/shop/product-img-23.png" alt />
                                        <span class="theme-badge">Sale</span>
                                    </div>
                                    <div class="details">
                                        <h4><a href="#">iPad mini</a></h4>
                                        <p><a href="#">The ultimate iPad experience all over the world </a></p>
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                        </div>
                                        <span class="price">
                                            <ins>
                                                <span class="woocommerce-Price-amount amount">
                                                    <bdi> <span class="woocommerce-Price-currencySymbol">$</span>471.48 </bdi>
                                                </span>
                                            </ins>
                                        </span>
                                        <div class="add-cart-area">
                                            <button class="add-to-cart">Add to cart</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="grid clearfix">
                                    <div class="product-pic">
                                        <img src="assets/images/shop/product-img-24.png" alt />
                                        <span class="theme-badge-2">25% off</span>
                                    </div>
                                    <div class="details">
                                        <h4><a href="#">Imac 29"</a></h4>
                                        <p><a href="#">Apple iMac 29″ Laptop with Touch ID for you </a></p>
                                        <div class="rating">
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star"></i>
                                            <i class="fas fa-star-half-alt"></i>
                                        </div>
                                        <span class="price">
                                            <ins>
                                                <span class="woocommerce-Price-amount amount">
                                                    <bdi> <span class="woocommerce-Price-currencySymbol">$</span>471.48 </bdi>
                                                </span>
                                            </ins>
                                            <del aria-hidden="true">
                                                <span class="woocommerce-Price-amount amount">
                                                    <bdi> <span class="woocommerce-Price-currencySymbol">$</span>904.21 </bdi>
                                                </span>
                                            </del>
                                        </span>
                                        <div class="add-cart-area">
                                            <button class="add-to-cart">Add to cart</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="pagination_wrap">
                            <ul class="pagination_nav">
                                <li class="active"><a href="#!">01</a></li>
                                <li><a href="#!">02</a></li>
                                <li><a href="#!">03</a></li>
                                <li class="prev_btn">
                                    <a href="#!"><i class="fal fa-angle-left"></i></a>
                                </li>
                                <li class="next_btn">
                                    <a href="#!"><i class="fal fa-angle-right"></i></a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- product_section - end
================================================== -->
@endsection

@section('footer_script')
<script>
    $('.search_btn').click(function(){
        var search_input = $('#search_input').val();
        var category_id = $('input[class="category_id"]:checked').val();
        var color_id = $('input[class="color_id"]:checked').val();
        var size_id = $('input[class="size_id"]:checked').val();
        var min = $('#min').val();
        var max = $('#max').val();
        var sort = $('.sort :selected').val();
        var link = "{{route('shop')}}"+"?q="+search_input+"&category="+category_id+"&color_id="+color_id+"&size_id="+size_id+"&min="+min+"&max="+max+"&sort="+sort;
        window.location.href = link;
    })
    $('#range').click(function(){
        var search_input = $('#search_input').val();
        var category_id = $('input[class="category_id"]:checked').val();
        var color_id = $('input[class="color_id"]:checked').val();
        var size_id = $('input[class="size_id"]:checked').val();
        var min = $('#min').val();
        var max = $('#max').val();
        var sort = $('.sort :selected').val();
        var link = "{{route('shop')}}"+"?q="+search_input+"&category="+category_id+"&color_id="+color_id+"&size_id="+size_id+"&min="+min+"&max="+max+"&sort="+sort;
        window.location.href = link;
    })
    $('.category_id').click(function(){
        var search_input = $('#search_input').val();
        var category_id = $('input[class="category_id"]:checked').val();
        var color_id = $('input[class="color_id"]:checked').val();
        var size_id = $('input[class="size_id"]:checked').val();
        var min = $('#min').val();
        var max = $('#max').val();
        var sort = $('.sort :selected').val();
        var link = "{{route('shop')}}"+"?q="+search_input+"&category="+category_id+"&color_id="+color_id+"&size_id="+size_id+"&min="+min+"&max="+max+"&sort="+sort;
        window.location.href = link;
    })
    $('.color_id').click(function(){
        var search_input = $('#search_input').val();
        var category_id = $('input[class="category_id"]:checked').val();
        var color_id = $('input[class="color_id"]:checked').val();
        var size_id = $('input[class="size_id"]:checked').val();
        var min = $('#min').val();
        var max = $('#max').val();
        var sort = $('.sort :selected').val();
        var link = "{{route('shop')}}"+"?q="+search_input+"&category="+category_id+"&color_id="+color_id+"&size_id="+size_id+"&min="+min+"&max="+max+"&sort="+sort;
        window.location.href = link;
    })
    $('.size_id').click(function(){
        var search_input = $('#search_input').val();
        var category_id = $('input[class="category_id"]:checked').val();
        var color_id = $('input[class="color_id"]:checked').val();
        var size_id = $('input[class="size_id"]:checked').val();
        var min = $('#min').val();
        var max = $('#max').val();
        var sort = $('.sort :selected').val();
        var link = "{{route('shop')}}"+"?q="+search_input+"&category="+category_id+"&color_id="+color_id+"&size_id="+size_id+"&min="+min+"&max="+max+"&sort="+sort;
        window.location.href = link;
    })
    $('.sort').change(function(){
        var search_input = $('#search_input').val();
        var category_id = $('input[class="category_id"]:checked').val();
        var color_id = $('input[class="color_id"]:checked').val();
        var size_id = $('input[class="size_id"]:checked').val();
        var min = $('#min').val();
        var max = $('#max').val();
        var sort = $('.sort :selected').val();
        var link = "{{route('shop')}}"+"?q="+search_input+"&category="+category_id+"&color_id="+color_id+"&size_id="+size_id+"&min="+min+"&max="+max+"&sort="+sort;
        window.location.href = link;
    })
</script>
@endsection
