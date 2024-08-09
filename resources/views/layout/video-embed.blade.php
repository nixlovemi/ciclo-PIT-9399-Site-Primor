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
    <!--<iframe class="embed-responsive-item" src="{{ $VIDEO_SRC ?? '' }}" allowfullscreen></iframe>-->
    
    <video controls>
        <source src="{{ $VIDEO_SRC ?? '' }}" />
        Your browser does not support the video tag.
    </video> 
</div>