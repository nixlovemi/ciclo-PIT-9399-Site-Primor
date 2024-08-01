<div class="recipes-item">
    <div class="type">{{ $type ?? '' }}</div>
    <div class="title">
        <a href="{{ $url }}">
            {{ $title ?? '' }}
    	</a>
    </div>
    <div class="img">
        <a href="{{ $url }}">
            <img class="responsive" src="{{ $image ?? '' }}" />
        </a>
    </div>
    <div class="footer">
        @if ($details && $details != '')
            <p class="text-center mb-3">{!! $details !!}</p>
        @endif

        <div class="row">
            <div class="col">
                <i class="far fa-clock"></i>
                {{ $timeStr ?? '' }}
            </div>
            <div class="col">
                <i class="fas fa-user-friends"></i>
                {{ $portionsStr ?? '' }}
            </div>
        </div>
    </div>
</div>