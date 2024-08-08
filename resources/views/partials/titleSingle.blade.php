@php
/*
View variables:
===============
    - $TITLE: string
    - $TITLE_CLASS: string
*/
$TITLE = $TITLE ?? '';
$TITLE_CLASS = $TITLE_CLASS ?? '';
@endphp

<h2>
    @if(str_word_count($TITLE) == 1)
        <span class="title black {{ $TITLE_CLASS }}">{{ $TITLE }}</span>
    @endif

    @if(str_word_count($TITLE) > 1)
        @php
        $arrTitle = explode(' ', trim($TITLE));
        @endphp

        <span class="title stash">{{ $arrTitle[0] }}</span>
        <br />
        @php
        array_shift($arrTitle);
        @endphp
        
        <span class="title black {{ $TITLE_CLASS }}">{{ implode(' ', $arrTitle) }}</span>
    @endif
</h2>