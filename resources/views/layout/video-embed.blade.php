@php
/*
View variables:
===============
    - $VIDEO_SRC: string
*/
@endphp

<div class="embed-responsive embed-responsive-16by9 mb-5">
    <iframe class="embed-responsive-item" src="{{ $VIDEO_SRC ?? '' }}" allowfullscreen></iframe>
</div>