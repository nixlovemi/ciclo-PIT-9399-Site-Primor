<div class="carousel-single">
    @foreach ($slides ?? [] as $slide)
        @php
            $slide = (object) $slide;

            $url = $slide->url ?? 'javascript:;';
            $hasDescShort = $slide->descriptionShort && !empty($slide->descriptionShort);
            $classesDescShort = ($hasDescShort) ? 'd-none d-lg-block': '';
        @endphp

        <div class="carousel-item">
            <div class="text-box">
                <p>
                    {!! $slide->title ?? '' !!}
                </p>
                <p class="text mb-4 {{ $classesDescShort }}">
                    {!! $slide->description ?? '' !!}
                </p>

                @if ($hasDescShort)
                    <p class="text mb-4 d-block d-lg-none">
                        {!! $slide->descriptionShort ?? '' !!}
                    </p>
                @endif
                
                <a class="button" href="{{ $url }}">SAIBA MAIS</a>
            </div>
            <img class="responsive" alt="Primor - Banner 0{{ $loop->index + 1 }}" src="{{ $slide->image ?? '' }}" />
        </div>
    @endforeach
</div>