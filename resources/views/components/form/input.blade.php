@props([
    'id' => null,
    'label' => null ,
    'value' => '',
    'name',
    'required'=> 0
])

@php
    $id = $id ?? $name;
@endphp

@if(isset($label))
<x-form.label :required="$required">
    {{$label}}
</x-form.label>
@endif

<input id="{{$id}}" name="{{$name}}" value="{{old($name , $value)}}" {{ $attributes->class(['form-control' , 'is-invalid' => $errors->has($name)])}}>

@error($name)
<p class="invalid-feedback">{{$message}}</p>
@endError