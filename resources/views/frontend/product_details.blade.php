@extends('frontend.master')

@section('content')
<!-- breadcrumb_section - start
================================================== -->
<div class="breadcrumb_section">
    <div class="container">
        <ul class="breadcrumb_nav ul_li">
            <li><a href="index.html">Home</a></li>
            <li>Product Details</li>
        </ul>
    </div>
</div>
<!-- breadcrumb_section - end
================================================== -->

<!-- product_details - start
================================================== -->
<section class="product_details section_space pb-0">
    <div class="container">
        <div class="row">
            <div class="col col-lg-6">
                <div class="product_details_image">
                    <div class="details_image_carousel">
                        @foreach ($thumnails as $thumbnail)
                        <div class="slider_item">
                            <img src="{{ asset('uploads/product/thumbnail') }}/{{ $thumbnail->thumbnail }}" alt="image_not_found">
                        </div>
                        @endforeach
                    </div>

                    <div class="details_image_carousel_nav">
                        @foreach ($thumnails as $thumbnail)
                        <div class="slider_item">
                            <img src="{{ asset('uploads/product/thumbnail') }}/{{ $thumbnail->thumbnail }}" alt="image_not_found">
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="product_details_content">
                    <h2 class="item_title">{{ $product_info->first()->product_name }}</h2>
                    <p>{{ $product_info->first()->short_desp }}</p>


                    @php
                        if($total_review == 0){
                            $avg = 0;
                        }
                        else{
                            $avg = round($total_star/$total_review);
                        }
                    @endphp

                    <div class="item_review">
                        <ul class="rating_star ul_li">
                            @for ($i=1; $i<=$avg; $i++)
                            <li><i class="fas fa-star"></i></li>
                            @endfor
                        </ul>
                        <span class="review_value">{{$avg}} Rating(s)</span>
                    </div>

                    <div class="item_price">
                        <span>TK <span id="price">{{ $product_info->first()->after_discount }}</span></span>
                        @if ($product_info->first()->discount)
                        <del>TK {{ $product_info->first()->product_price }}</del>
                        @else
                        @endif

                    </div>
                    <hr>

                    <div class="item_attribute">
                        <form action="{{ route('cart.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col col-md-6">
                                    <input type="hidden" value="{{ $product_info->first()->id }}" name="product_id">
                                    <div class="select_option clearfix">
                                        <h4 class="input_title">Color *</h4>
                                        <select class="form-control" id="color_id" name="color_id">
                                            <option value="">Choose A Option</option>
                                            @foreach ($available_colors as $color)
                                                <option value="{{ $color->rel_to_color->id }}">{{ $color->rel_to_color->color_name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col col-md-6">
                                    <div class="select_option clearfix">
                                        <h4 class="input_title">Size *</h4>
                                        <select class="form-control" id="size_id" name="size_id">
                                            <option value="">Choose A Option</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="quantity_wrap">
                            <div class="quantity_input">
                                <button type="button" class="input_number_decrement">
                                    <i class="fal fa-minus"></i>
                                </button>
                                <input class="input_number" type="text" value="1" name="quantity">
                                <button type="button" class="input_number_increment">
                                    <i class="fal fa-plus"></i>
                                </button>
                            </div>
                            <div class="total_price">Total: TK <span id="total">{{ $product_info->first()->after_discount }}</span></div>
                        </div>

                        <ul class="default_btns_group ul_li">
                            @auth('customerlogin')
                            <li class="abc">
                                <button class="btn btn_primary addtocart_btn" type="submit">Add To Cart</button>
                            </li>
                            @else
                            <li><a class="btn btn_primary addtocart_btn" href="{{ route('customer.login.register') }}">Add To Cart</a></li>
                            @endauth
                        </ul>
                    </div>
                </form>
            </div>
        </div>

        <div class="details_information_tab">
            <ul class="tabs_nav nav ul_li" role=tablist>
                <li>
                    <button class="active" data-bs-toggle="tab" data-bs-target="#description_tab" type="button" role="tab" aria-controls="description_tab" aria-selected="true">
                    Description
                    </button>
                </li>
                <li>
                    <button data-bs-toggle="tab" data-bs-target="#additional_information_tab" type="button" role="tab" aria-controls="additional_information_tab" aria-selected="false">
                    Additional information
                    </button>
                </li>
                <li>
                    <button data-bs-toggle="tab" data-bs-target="#reviews_tab" type="button" role="tab" aria-controls="reviews_tab" aria-selected="false">
                    Reviews(2)
                    </button>
                </li>
            </ul>

            <div class="tab-content">
                <div class="tab-pane fade show active" id="description_tab" role="tabpanel">
                    <p>{!! $product_info->first()->long_desp !!}</p>
                </div>

                <div class="tab-pane fade" id="additional_information_tab" role="tabpanel">
                    <p>
                    Return into stiff sections the bedding was hardly able to cover it and seemed ready to slide off any moment. His many legs, pitifully thin compared with the size of the rest of him, waved about helplessly as he looked what's happened to me he thought It wasn't a dream. His room, a proper human room although a little too small
                    </p>

                    <div class="additional_info_list">
                        <h4 class="info_title">Additional Info</h4>
                        <ul class="ul_li_block">
                            <li>No Side Effects</li>
                            <li>Made in USA</li>
                        </ul>
                    </div>

                    <div class="additional_info_list">
                        <h4 class="info_title">Product Features Info</h4>
                        <ul class="ul_li_block">
                            <li>Compatible for indoor and outdoor use</li>
                            <li>Wide polypropylene shell seat for unrivalled comfort</li>
                            <li>Rust-resistant frame</li>
                            <li>Durable UV and weather-resistant construction</li>
                            <li>Shell seat features water draining recess</li>
                            <li>Shell and base are stackable for transport</li>
                            <li>Choice of monochrome finishes and colourways</li>
                            <li>Designed by Nagi</li>
                        </ul>
                    </div>
                </div>

                <div class="tab-pane fade" id="reviews_tab" role="tabpanel">
                    <div class="average_area">
                        <div class="row align-items-center">
                            <div class="col-md-12 order-last">
                                <div class="average_rating_text">
                                    <ul class="rating_star ul_li_center">
                                        @for ($i=1; $i<=$avg; $i++)
                                        <li><i class="fas fa-star"></i></li>
                                        @endfor
                                    </ul>
                                    <p class="mb-0">
                                      Average Star Rating: <span>{{$avg}} out of 5</span> ({{$total_review}} vote)
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="customer_reviews">
                        <h4 class="reviews_tab_title">{{$total_review}} reviews for this product</h4>
                        @foreach ($reviews as $review)
                            <div class="customer_review_item clearfix">
                                <div class="customer_image">
                                    <img src="{{asset('frontend/images/team/team_1.jpg')}}" alt="image_not_found">
                                </div>
                                <div class="customer_content">
                                    <div class="customer_info">
                                        <ul class="rating_star ul_li">
                                            @for ($i=1; $i<=$review->star; $i++)
                                            <li><i class="fas fa-star"></i></li>
                                            @endfor
                                        </ul>
                                        <h4 class="customer_name">{{$review->rel_to_customer->name}}</h4>
                                        <span class="comment_date">{{$review->created_at->format('d-M-Y')}}</span>
                                    </div>
                                    <p class="mb-0">{{$review->review}}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @auth('customerlogin')
                    @if (App\Models\OrderProduct::where('customer_id', Auth::guard('customerlogin')->id())->where('product_id', $product_info->first()->id)->exists())

                    @if (App\Models\OrderProduct::where('customer_id', Auth::guard('customerlogin')->id())->where('product_id', $product_info->first()->id)->where('review', '!=', null)->first() == false)
                    <div class="customer_review_form">
                        <h4 class="reviews_tab_title">Add a review</h4>
                        <form action="{{route('review')}}" method="POST">
                            @csrf
                            <div class="form_item">
                                <input type="text" name="name" value="{{Auth::guard('customerlogin')->user()->name}}">
                            </div>
                            <div class="form_item">
                                <input type="email" name="email" value="{{Auth::guard('customerlogin')->user()->email}}">
                            </div>
                            <div class="your_ratings">
                                <h5>Your Ratings:</h5>
                                <button type="button" class="star" value="1"><i class="fal fa-star"></i></button>
                                <button type="button" class="star" value="2"><i class="fal fa-star"></i></button>
                                <button type="button" class="star" value="3"><i class="fal fa-star"></i></button>
                                <button type="button" class="star" value="4"><i class="fal fa-star"></i></button>
                                <button type="button" class="star" value="5"><i class="fal fa-star"></i></button>
                            </div>
                            <input type="hidden" id="product_id" value="{{$product_info->first()->id}}" name="product_id">
                            <input type="hidden" id="star" value="" name="star">
                            <div class="form_item">
                                <textarea name="review" placeholder="Your Review*"></textarea>
                            </div>
                            <button type="submit" class="btn btn_primary">Submit Now</button>
                        </form>
                    </div>
                    @else
                    <div class="alert alert-info">
                        <h3>You already reviewed this product</h3>
                    </div>
                    @endif

                    @else
                    <div class="alert alert-info">
                        <h3>You did not purchase this product yet</h3>
                    </div>
                    @endif

                    @else
                    <div class="alert alert-info">
                        <h3>Please Sign in to Review This Product <a href="{{route('customer.login.register')}}" class="btn btn-primary float-end">Login</a></h3>
                    </div>
                    @endauth
                </div>
            </div>
        </div>
    </div>
</section>
<!-- product_details - end
================================================== -->

<!-- related_products_section - start
================================================== -->
<section class="related_products_section section_space">
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="best-selling-products related-product-area">
                    <div class="sec-title-link">
                        <h3>Related products</h3>
                        <div class="view-all"><a href="#">View all<i class="fal fa-long-arrow-right"></i></a></div>
                    </div>
                    <div class="product-area clearfix">
                        @forelse ($related_products as $related)
                        <div class="grid">
                            <div class="product-pic">
                                <img src="{{ asset('uploads/product/preview') }}/{{ $related->preview }}" alt>

                            </div>
                            <div class="details">
                                <h4><a href="{{ route('product.details', $related->slug) }}">{{ $related->product_name }}</a></h4>
                                <p><a href="#">{{ $related->short_desp }}</a></p>
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
                                            <bdi>
                                                <span class="woocommerce-Price-currencySymbol">TK </span>{{ $related->after_discount }}
                                            </bdi>
                                        </span>
                                    </ins>
                                </span>
                                <div class="add-cart-area">
                                    <button class="add-to-cart">Add to cart</button>
                                </div>
                            </div>
                        </div>
                        @empty
                        <h3>No Related Product Found</h3>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- related_products_section - end
================================================== -->
@endsection

@section('footer_script')

<script>
    var quantity = $('.input_number').val();
    $('.input_number_increment').click(function (){
        quantity++
        $('.input_number').val(quantity);
        var price = $('#price').html();
        var total = price*quantity;
        $('#total').html(total);
    });
    $('.input_number_decrement').click(function (){
        if(quantity > 1){
            quantity--
        }
        $('.input_number').val(quantity);
        var price = $('#price').html();
        var total = price*quantity;
        $('#total').html(total);
    });
</script>


    <script>
        $('#color_id').change(function(){
            var color_id = $(this).val();
            var product_id = "{{ $product_info->first()->id }}";

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type:'POST',
                url:'/getSize',
                data:{'color_id':color_id, 'product_id':product_id},
                success:function(data){
                    $('#size_id').html(data);
                }
            });

        });
    </script>

    <script>
        $('#size_id').change(function(){
            var color_id = $('.colr_id').attr('data-col');
            var product_id = "{{ $product_info->first()->id }}";
            var size_id = $(this).val();

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type:'POST',
                url:'/getStock',
                data:{'color_id':color_id, 'product_id':product_id, 'size_id':size_id},
                success:function(data){
                    $('.abc').html(data);
                }
            });

        });
    </script>

    @if (session('cart'))
        <script>
            Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: '{{ session('cart') }}',
            showConfirmButton: false,
            timer: 1500
            })
        </script>
    @endif

    <script>
        $('.star').click(function(){
            var star = $(this).val();
            $('#star').val(star);
        });
    </script>
@endsection
