<ul>
    @foreach ($_items ?? [] as $item)
        @php
            $item = (object) $item;
            $url = $item->url ?? 'javascript:;';
            $title = $item->title ?? 'Item';
        @endphp

        <li>
            <a href="{{ $url }}">{{ $title }}</a>
        </li>
    @endforeach
</ul>