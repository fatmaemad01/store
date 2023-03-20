@props([
    'id' => null,
    'label' => null ,
    'value' => '',
    'name'
])

@php
    $id = $id ?? $name;
@endphp

@if(isset($label))
<label for="{{$id ?? ''}}"> {{$label}}</label>
@endif

<textarea id="{{$id}}" name="{{$name}}"  {{ $attributes->class(['form-control' , 'is-invalid' => $errors->has($name)])}}> {{ old($name , $value) }} </textarea>

@error($name)
<p class="invalid-feedback">{{$message}}</p>
@endError