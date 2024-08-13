@php
/*
View variables:
===============
    - $RECIPES: Illuminate\Database\Eloquent\Collection ([] of App\Models\Recipe)
*/
$RECIPES = $RECIPES ?? [];
@endphp

<div class="row">
    @foreach ($RECIPES as $item)
        <div class="col-6 col-sm-4 col-md-3 mb-4">
            <x-recipes-item
                :type="$item->type ?? ''"
                :title="$item->title ?? ''"
                :image="$item->getThumbFullUrl()"
                :timeStr="$item->time_str ?? ''"
                :portionsStr="$item->portions_str ?? ''"
                :url="$item->getSingleUrl()"
            />
        </div>
    @endforeach
</div>