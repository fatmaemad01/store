@extends('layout.dashboard')

@section('title','Create Product')

@section('breadcrumb')
@parent
<li class="breadcrumb-item ">Products</li>
<li class="breadcrumb-item active">Create</li>
@endSection

@section('content')

@if($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach($errors->all() as $error)
        <li>{{$error}}</li>
        @endforeach
    </ul>
</div>
@endif
<form action="{{route('dashboard.products.store')}}" method="post" enctype="multipart/form-data">

    @include('dashboard.products._form' , [
        'button' => 'Create',
        ])

</form>
@endSection