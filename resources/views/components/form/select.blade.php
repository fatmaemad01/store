@props([
    'name',
    'selected' => null ,
    'options',
    'label' => null,
    'required' =>0,
    'value' =>'',
])

@php
    $id = $id ?? $name;
@endphp

<x-form.label :required="$required">
    {{$label}}
</x-form.label>
<select name="{{ $name }}" class="form-control">
    <option value="$value">Select One</option>
    @foreach($options as $key => $label)
        <option value="{{ $key }}" {{ $selected == $key ? 'selected' : '' }}>
            {{ $label }}
        </option>
    @endforeach
</select>

