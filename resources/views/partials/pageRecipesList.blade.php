@php
/*
View variables:
===============
    - $RECIPES: array
*/
$RECIPES = $RECIPES ?? [];
@endphp

<div class="row">
    @foreach ($RECIPES as $item)
        @php
        $item = (object) $item;
        @endphp

        <div class="col-6 col-sm-4 col-md-3 mb-4">
            <x-recipes-item
                :type="$item->type ?? ''"
                :title="$item->title ?? ''"
                :image="$item->image ?? ''"
                :timeStr="$item->timeStr ?? ''"
                :portionsStr="$item->portionsStr ?? ''"
                :url="$item->url ?? null"
            />
        </div>
    @endforeach
</div>