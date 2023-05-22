@props(['type'])

@php
    switch ($type) {
        case 'info':
            $color='blue';
            break;

            case 'danger':
            $color='red';
            break;
        default:
            $color='green';
            break;
    }
@endphp



<div  role="alert">
    <div class="bg-{{$color}}-500 text-white font-bold rounded-t px-4 py-2">
      {{ $title }}
    </div>
    <div {{$attributes->merge(['class'=>"border border-t-0 border-$color-400 rounded-b bg-$color-100 px-4 py-3 text-$color-700"])}}>
      <p>{{ $slot }}</p>
    </div>
  </div>
