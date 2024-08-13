<div class="carousel-recipes">
    @foreach ($_recipes ?? [] as $item)
        @php
            $item = (object) $item;
        @endphp

        <div class="carousel-item">
            <x-recipes-item
                :type="$item->type ?? ''"
                :title="$item->title ?? ''"
                :image="$item->getThumbFullUrl()"
                :details="null"
                :timeStr="$item->time_str ?? ''"
                :portionsStr="$item->portions_str ?? ''"
                :url="$item->getSingleUrl()"
            />
        </div>
    @endforeach
</div>