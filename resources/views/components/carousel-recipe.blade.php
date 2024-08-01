<div class="carousel-recipes">
    @foreach ($_recipes ?? [] as $item)
        @php
            $item = (object) $item;
        @endphp

        <div class="carousel-item">
            <x-recipes-item
                :type="$item->type ?? ''"
                :title="$item->title ?? ''"
                :image="$item->image ?? ''"
                :details="$item->details ?? null"
                :timeStr="$item->timeStr ?? ''"
                :portionsStr="$item->portionsStr ?? ''"
                :url="$item->url ?? null"
            />
        </div>
    @endforeach
</div>