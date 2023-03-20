@extends('layout.dashboard')

@section ('title',$title)


@section('breadcrumb')
@parent
<li class="breadcrumb-item active">Categories</li>
@endSection

@section('content')

<x-flash-message />

<div class="table-toolbar mb-3 d-flex justify-content-between">
    <div class="table-toolbar mb-3">
        <a href="{{route('dashboard.categories.create')}}" class="btn btn-sm btn-outline-primary">Create</a>
        <a href="{{route('dashboard.categories.trash')}}" class="btn btn-sm btn-outline-danger">Trash</a>
    </div>
    <div>
        <form action="{{route('dashboard.categories.index')}}" class="d-flex">
            <input type="text" name="search" value="{{request('search')}}" class="form-control">
            <button type="submit" class="btn btn-dark ml-2">Search</button>
        </form>
    </div>
</div>
<div class="table-responsive">
    <table class="table">
        <thead>
            <tr>
                <th>Image</th>
                <th>ID</th>
                <th>Name</th>
                <th>Parent</th>
                <th>Created At</th>
                <th colspan="2">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($categories as $category)
            <tr>
                <td>
                    @if ($category->image)

                    <img src="{{ Storage::disk('public')->url($category->image) }}" alt="x" height="60">
                    @else
                    <img src="{{ asset('/images/product.jpg')}}" alt="nn" height="60">
                    @endif
                </td>
                <td>{{$category->id}}</td>
                <td>{{$category->name}}</td>
                <td>{{$category->parent_name}}</td>
                <td>{{$category->created_at}}</td>
                <td>
                    <a href="{{route('dashboard.categories.edit', $category->id)}}" class="btn btn-sm btn-outline-success">Edit</a>
                </td>
                <td>
                    <form action="{{route('dashboard.categories.destroy',$category->id)}}" method="post">
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

