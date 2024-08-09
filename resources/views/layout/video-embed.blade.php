@php
/*
View variables:
===============
    - $VIDEO_SRC: string
    - $ROUNDED: bool
*/

$ROUNDED = $ROUNDED ?? false;
$roundedClass = ($ROUNDED) ? 'embed-responsive-rounded': '';
@endphp

<div class="embed-responsive embed-responsive-16by9 {{$roundedClass}} mb-5">
    <iframe
        src="{{ $VIDEO_SRC ?? '' }}"
        frameborder="0"
        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
        referrerpolicy="strict-origin-when-cross-origin"
        allowfullscreen
    ></iframe>
</div>