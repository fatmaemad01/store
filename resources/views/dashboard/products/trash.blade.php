@extends('layout.dashboard')

@section ('title','Trashed Products')


@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Products</li>
<li class="breadcrumb-item active">Trash</li>
@endSection

@section('content')
<div class="table-toolbar mb-3">
    <a href="{{route('dashboard.products.index')}}" class="btn btn-sm btn-outline-primary">Back</a>
</div>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
            <th>Image</th>
                <th>ID</th>
                <th>Name</th>
                <th>Category</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>SKU</th>
                <th>Status</th>
                <th>Created At</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $product)
            <tr>
                <td>
                    @if ($product->image)

                    <img src="{{ Storage::disk('public')->url($product->image) }}" alt="x" height="60">
                    @else
                    <img src="{{ asset('/images/product.jpg')}}" alt="nn" height="60">
                    @endif
                </td>
                <td>{{$product->id}}</td>
                <td>{{$product->name}}</td>
                <td>{{$product->category_id}}</td>
                <td>{{$product->price}}</td>
                <td>{{$product->quantity}}</td>
                <td>{{$product->sku}}</td>
                <td>{{$product->status}}</td>
                <td>{{$product->created_at}}</td>
                <td>
                    <form action="{{route('dashboard.products.restore',$product->id)}}" method="post">
                        @csrf
                        @method('patch')
                        <button type="submit" class="btn btn-sm btn-outline-success">Restore</button>
                    </form>
                </td>
                <td>
                    <form action="{{route('dashboard.products.destroy',$product->id)}}" method="post">
                        @csrf
                        @method('delete')
                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endSection