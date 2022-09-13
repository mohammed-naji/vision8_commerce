@extends('site.master')

@section('title', 'Home | ' . config('app.name'))

@section('content')
    <div class="hero-slider">
        @foreach ($products_slider as $item)
            <div class="slider-item th-fullpage hero-area"
                style="background-image: url({{ asset('uploads/products/' . $item->image) }});">
                <div class="container">
                    <div class="row">
                        <div class="col-lg-8 text-center">
                            <p data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".1">PRODUCTS</p>
                            <h1 data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".5">{{ $item->trans_name }}
                            </h1>
                            <a data-duration-in=".3" data-animation-in="fadeInUp" data-delay-in=".8" class="btn"
                                href="{{ route('site.product', $item->slug) }}">Shop Now</a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

    </div>

    <section class="product-category section">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title text-center">
                        <h2>Product Category</h2>
                    </div>
                </div>
                <div class="col-md-6">
                    @isset($categories[0])
                    <div class="category-box">
                        <a href="{{ route('site.category', $categories[0]->id) }}">
                            <img src="{{ asset('uploads/categories/'.$categories[0]->image) }}" alt="" />
                            <div class="content">
                                <h3>{{ $categories[0]->trans_name }}</h3>
                            </div>
                        </a>
                    </div>
                    @endisset

                    @if (isset($categories[1]))
                    <div class="category-box">
                        <a href="{{ route('site.category', $categories[1]->id) }}">
                            <img src="{{ asset('uploads/categories/'.$categories[1]->image) }}" alt="" />
                            <div class="content">
                                <h3>{{ $categories[1]->trans_name }}</h3>
                            </div>
                        </a>
                    </div>
                    @endif

                </div>
                <div class="col-md-6">
                    @isset($categories[2])
                    <div class="category-box category-box-2">
                        <a href="{{ route('site.category', $categories[2]->id) }}">
                            <img src="{{ asset('uploads/categories/'.$categories[2]->image) }}" alt="" />
                            <div class="content">
                                <h3>{{ $categories[2]->trans_name }}</h3>
                            </div>
                        </a>
                    </div>
                    @endisset
                </div>
            </div>
        </div>
    </section>

    <section class="products section bg-gray">
        <div class="container">
            <div class="row">
                <div class="title text-center">
                    <h2>Trendy Products</h2>
                </div>
            </div>
            <div class="row">
                @foreach ($products_latest as $product)
                <div class="col-md-4">
                    @include('site.includes.product')
                </div>
                @endforeach


            </div>
        </div>
    </section>


    <!--
      Start Call To Action
      ==================================== -->
    <section class="call-to-action bg-gray section">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <div class="title">
                        <h2>SUBSCRIBE TO NEWSLETTER</h2>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Fugiat, <br> facilis numquam impedit ut
                            sequi. Minus facilis vitae excepturi sit laboriosam.</p>
                    </div>
                    <div class="col-lg-6 col-md-offset-3">
                        <div class="input-group subscription-form">
                            <input type="text" class="form-control" placeholder="Enter Your Email Address">
                            <span class="input-group-btn">
                                <button class="btn btn-main" type="button">Subscribe Now!</button>
                            </span>
                        </div><!-- /input-group -->
                    </div><!-- /.col-lg-6 -->

                </div>
            </div> <!-- End row -->
        </div> <!-- End container -->
    </section> <!-- End section -->

    <section class="section instagram-feed">
        <div class="container">
            <div class="row">
                <div class="title">
                    <h2>View us on instagram</h2>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="instagram-slider" id="instafeed"
                        data-accessToken="IGQVJYeUk4YWNIY1h4OWZANeS1wRHZARdjJ5QmdueXN2RFR6NF9iYUtfcGp1NmpxZA3RTbnU1MXpDNVBHTzZAMOFlxcGlkVHBKdjhqSnUybERhNWdQSE5hVmtXT013MEhOQVJJRGJBRURn">
                    </div>
                </div>
            </div>
        </div>
    </section>
@stop
