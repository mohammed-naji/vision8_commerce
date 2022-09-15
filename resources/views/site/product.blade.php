@extends('site.master')

@section('title', $product->trans_name .' | '. config('app.name'))

@section('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css" integrity="sha512-xh6O/CkQoPOWDdYTDqeRdPCVd1SpvCA9XXcUnZS2FmJNp1coAFzvtCN9BmamE+4aHK8yyUHUSCcJHgXloTyT2A==" crossorigin="anonymous" referrerpolicy="no-referrer" />

<style>.star-rating{
	font-size: 0;
}
.star-rating__wrap{
	display: inline-block;
	font-size: 1rem;
}
.star-rating__wrap:after{
	content: "";
	display: table;
	clear: both;
}
.star-rating__ico{
	float: right;
	padding-left: 2px;
	cursor: pointer;
	color: #FFB300;
}
.star-rating__ico:last-child{
	padding-left: 0;
}
.star-rating__input{
	display: none;
}
.star-rating__ico:hover:before,
.star-rating__ico:hover ~ .star-rating__ico:before,
.star-rating__input:checked ~ .star-rating__ico:before
{
	content: "\f005";
}</style>
@stop

@section('content')

{{-- @dump($product->album->first()) --}}
<section class="single-product">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<ol class="breadcrumb">
					<li><a href="{{ route('site.index') }}">Home</a></li>
					<li><a href="{{ route('site.shop') }}">Shop</a></li>
					<li class="active">{{ $product->trans_name }}</li>
				</ol>
			</div>
			<div class="col-md-6">
				<ol class="product-pagination text-right">
                    @if ($next)
                    <li><a href="{{ route('site.product', $next->slug) }}"><i class="tf-ion-ios-arrow-left"></i> Next </a></li>
                    @endif

                    @if ($prev)
                    <li><a href="{{ route('site.product', $prev->slug) }}">Preview <i class="tf-ion-ios-arrow-right"></i></a></li>
                    @endif

				</ol>
			</div>
		</div>
		<div class="row mt-20">
			<div class="col-md-5">
				<div class="single-product-slider">
					<div id='carousel-custom' class='carousel slide' data-ride='carousel'>
						<div class='carousel-outer'>
							<!-- me art lab slider -->
							<div class='carousel-inner '>
								<div class='item active'>
									<img src="{{ asset('uploads/products/'.$product->image) }}" alt='' data-zoom-image="{{ asset('uploads/products/'.$product->image) }}" />
								</div>

								@foreach ($product->album as $image)
                                <div class='item'>
									<img src='{{ asset('uploads/products/'.$image->path) }}' alt='' data-zoom-image="{{ asset('uploads/products/'.$image->path) }}" />
								</div>
                                @endforeach

							</div>

							<!-- sag sol -->
							<a class='left carousel-control' href='#carousel-custom' data-slide='prev'>
								<i class="tf-ion-ios-arrow-left"></i>
							</a>
							<a class='right carousel-control' href='#carousel-custom' data-slide='next'>
								<i class="tf-ion-ios-arrow-right"></i>
							</a>
						</div>

						<!-- thumb -->
						<ol class='carousel-indicators mCustomScrollbar meartlab'>
							<li data-target='#carousel-custom' data-slide-to='0' class='active'>
								<img src='{{ asset('uploads/products/'.$product->image) }}' alt='' />
							</li>

                            @foreach ($product->album as $image)
							<li data-target='#carousel-custom' data-slide-to='{{ $loop->iteration }}'>
								<img src='{{ asset('uploads/products/'.$image->path) }}' alt='' />
							</li>
                            @endforeach

						</ol>
					</div>
				</div>
			</div>
			<div class="col-md-7">
                @if (session('msg'))
                    <div class="alert alert-success">
                        {{ session('msg') }}
                    </div>
                @endif
				<div class="single-product-details">
                    @php
                    $rating = $product->reviews->avg('star');
                    @endphp

					<h2>{{ $product->trans_name }}</h2>
                    <small>{{ $rating }} <i class="tf-ion-star"></i> Based On {{ $product->reviews->count() }}</small>

                    <br>

                    @foreach(range(1,5) as $i)
                        <span class="fa-stack" style="width:1em">
                            <i class="far fa-star fa-stack-1x"></i>

                            @if($rating >0)
                                @if($rating >0.5)
                                    <i class="fas fa-star fa-stack-1x"></i>
                                @else
                                    <i class="fas fa-star-half fa-stack-1x"></i>
                                @endif
                            @endif
                            @php $rating--; @endphp
                        </span>
                    @endforeach
					<p class="product-price">${{ $product->price }}</p>

					<div class="product-description mt-20">
						{!! Str::words($product->trans_content, 20, '...') !!}
					</div>
					{{-- <div class="color-swatches">
						<span>color:</span>
						<ul>
							<li>
								<a href="#!" class="swatch-violet"></a>
							</li>
							<li>
								<a href="#!" class="swatch-black"></a>
							</li>
							<li>
								<a href="#!" class="swatch-cream"></a>
							</li>
						</ul>
					</div>
					<div class="product-size">
						<span>Size:</span>
						<select class="form-control">
							<option>S</option>
							<option>M</option>
							<option>L</option>
							<option>XL</option>
						</select>
					</div> --}}
					<form action="{{ route('site.add_to_cart') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <div class="product-quantity">
                            <span>Quantity:</span>
                            <div class="product-quantity-slider">
                                <input id="product-quantity" type="text" value="1" name="quantity">
                            </div>
                        </div>
                        <div class="product-category">
                            <span>Categories:</span>
                            <ul>
                                <li><a href="{{ route('site.category', $product->category_id) }}">{{ $product->category->trans_name }}</a></li>

                            </ul>
                        </div>
                        <button class="btn btn-main mt-20">Add To Cart</button>
                    </form>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-12">
				<div class="tabCommon mt-20">
					<ul class="nav nav-tabs">
						<li class="active"><a data-toggle="tab" href="#details" aria-expanded="true">Details</a></li>
						<li class=""><a data-toggle="tab" href="#reviews" aria-expanded="false">Reviews ({{ $product->reviews->count() }})</a></li>
					</ul>
					<div class="tab-content patternbg">
						<div id="details" class="tab-pane fade active in">
							<h4>Product Description</h4>
							{!! $product->trans_content !!}
						</div>
						<div id="reviews" class="tab-pane fade">
							<div class="post-comments">
						    	<ul class="media-list comments-list m-bot-50 clearlist">
                                    @foreach ($product->reviews as $item)
                                        <!-- Comment Item start-->
								    <li class="media">

								        <a class="pull-left" href="#!">
								            <img class="media-object comment-avatar" src="https://ui-avatars.com/api/?name={{ $item->user->name }}" alt="" width="50" height="50" />
								        </a>

								        <div class="media-body">
								            <div class="comment-info">
								                <h4 class="comment-author">
								                    <a href="#!">{{ $item->user->name }}</a>

								                </h4>
								                <time datetime="{{ $item->created_at }}">
                                                    {{ $item->created_at->format('F d, Y') }}, at {{ $item->created_at->format('h:i') }}
                                                </time>
								                <a class="comment-button" href="#!"><i class="tf-ion-star"></i>{{ $item->star }}</a>
								            </div>

								            <p>
								                {{ $item->comment }}
								            </p>
								        </div>

								    </li>
								    <!-- End Comment Item -->
                                    @endforeach


							</ul>
							</div>
                            <h3>Add New Review</h3>
                            <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
                            <form method="post" action="{{ route('site.product_review', $product->slug) }}">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">
                                <div class="star-rating">
                                    <div class="star-rating__wrap">
                                      <input class="star-rating__input" id="star-rating-5" type="radio" name="rating" value="5">
                                      <label class="star-rating__ico fa fa-star-o fa-lg" for="star-rating-5" title="5 out of 5 stars"></label>
                                      <input class="star-rating__input" id="star-rating-4" type="radio" name="rating" value="4">
                                      <label class="star-rating__ico fa fa-star-o fa-lg" for="star-rating-4" title="4 out of 5 stars"></label>
                                      <input class="star-rating__input" id="star-rating-3" type="radio" name="rating" value="3">
                                      <label class="star-rating__ico fa fa-star-o fa-lg" for="star-rating-3" title="3 out of 5 stars"></label>
                                      <input class="star-rating__input" id="star-rating-2" type="radio" name="rating" value="2">
                                      <label class="star-rating__ico fa fa-star-o fa-lg" for="star-rating-2" title="2 out of 5 stars"></label>
                                      <input class="star-rating__input" id="star-rating-1" type="radio" name="rating" value="1">
                                      <label class="star-rating__ico fa fa-star-o fa-lg" for="star-rating-1" title="1 out of 5 stars"></label>
                                    </div>
                                  </div>
                                <textarea name="comment" class="form-control" placeholder="Comment" rows="4"></textarea>

                                <button class="btn btn-main mt-20">Post Review</button>
                            </form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<section class="products related-products section">
	<div class="container">
		<div class="row">
			<div class="title text-center">
				<h2>Related Products</h2>
			</div>
		</div>
		<div class="row">
            @foreach ($related as $product)
            <div class="col-md-3">
				@include('site.includes.product')
			</div>
            @endforeach

		</div>
	</div>
</section>
@stop
