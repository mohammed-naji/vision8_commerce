@extends('admin.master')

@section('title', 'Products | ' . env('APP_NAME'))

@section('content')
<!-- Page Heading -->
<h1 class="h3 mb-4 text-gray-800">All Products</h1>

@if (session('msg'))
    <div class="alert alert-{{ session('type') }}">
        {{ session('msg') }}
    </div>
@endif

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Image</th>
            <th>Price</th>
            <th>Sale Price</th>
            <th>Quantity</th>
            <th>Category</th>
            <th>Created At</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($products as $product)
        <tr>
            <td>{{ $product->id }}</td>
            <td>{{ $product->trans_name }}</td>
            <td><img width="80" src="{{ asset('uploads/products/'.$product->image) }}" alt=""></td>
            <td>{{ $product->price }}</td>
            <td>{{ $product->sale_price }}</td>
            <td>{{ $product->quantity }}</td>
            <td>{{ $product->category_id }}</td>
            <td>{{ $product->created_at ? $product->created_at->diffForHumans() : '' }}</td>
            <td>
                <a class="btn btn-sm btn-primary" href="{{ route('admin.products.edit', $product->id) }}"><i class="fas fa-edit"></i></a>
                <form class="d-inline" action="{{ route('admin.products.destroy', $product->id) }}" method="POST">
                    @csrf
                    @method('delete')
                    <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure')"><i class="fas fa-trash"></i></button>
                </form>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

{{ $products->links() }}

@stop
