@php
/*
View variables:
===============
    - $VIDEO_SRC: string
    - $POSTER: string
    - $ROUNDED: bool
*/

$ROUNDED = $ROUNDED ?? false;
$roundedClass = ($ROUNDED) ? 'embed-responsive-rounded': '';
@endphp

<div class="embed-responsive embed-responsive-16by9 {{$roundedClass}} mb-5">
    <video {{ isset($POSTER) && !empty($POSTER) ? 'poster='.$POSTER: ''}} controls>
        <source src="{{ $VIDEO_SRC ?? '' }}" />
        Your browser does not support the video tag.
    </video>
</div>