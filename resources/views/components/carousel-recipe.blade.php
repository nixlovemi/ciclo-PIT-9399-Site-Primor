<div class="carousel-recipes">
    @foreach ($_recipes ?? [] as $item)
        @php
            $item = (object) $item;
        @endphp

        <div class="carousel-item">
            <div class="recipes-item">
                <div class="type">{{ $item->type ?? '' }}</div>
                <div class="title">{{ $item->title ?? '' }}</div>
                <div class="img">
                    <img class="responsive" src="{{ $item->image ?? '' }}" />
                </div>
                <div class="footer">
                    @if ($item->details && $item->details != '')
                        <p class="text-center mb-3">{!! $item->details !!}</p>
                    @endif

                    <div class="row">
                        <div class="col">
                            <i class="far fa-clock"></i>
                            {{ $item->timeStr ?? '' }}
                        </div>
                        <div class="col">
                            <i class="fas fa-user-friends"></i>
                            {{ $item->portionsStr ?? '' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>