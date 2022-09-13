@extends('site.master')

@section('title', 'About | ' . config('app.name'))

@section('content')
<section class="page-header">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
                <form action="{{ route('site.search') }}" method="GET"><input type="search" name="q" class="form-control" placeholder="Search..." value="{{ request()->q }}"></form>
			</div>
		</div>
	</div>
</section>

<section class="products section">
	<div class="container">
        <div class="row">
            @foreach ($products as $product)
            <div class="col-md-4">
                @include('site.includes.product')
            </div>
            @endforeach
        </div>

        {{ $products->links() }}
	</div>
</section>
@stop
