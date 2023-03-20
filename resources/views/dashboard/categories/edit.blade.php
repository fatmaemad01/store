@extends('layout.dashboard')

@section('title','Edit Category')

@section('breadcrumb')
@parent
<li class="breadcrumb-item ">Categories</li>
<li class="breadcrumb-item active">Edit</li>
@endSection

@section('content')


<form action="{{route('dashboard.categories.update' , $category->id)}}" method="post" enctype="multipart/form-data">
    @method('put')
    @include('dashboard.categories._form' , [
        'button' => 'Update',
        ])

</form>
@endSection