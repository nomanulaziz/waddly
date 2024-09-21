@props(['width' => 90, 'employer'])

<img src="{{ asset($employer->logo) }}" alt="" class="rounded-xl" width="{{ $width }}">
