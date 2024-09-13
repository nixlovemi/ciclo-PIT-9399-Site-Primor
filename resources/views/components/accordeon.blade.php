<style>
    /* =========== ACCORDEON =========== */
    .accordion [data-toggle="collapse"] .fa-chevron-down {
        display: none;
    }
    .accordion [data-toggle="collapse"] .fa-chevron-up {
        display: inline-block;
    }
    .accordion [data-toggle="collapse"].collapsed .fa-chevron-down {
        display: inline-block;
    }
    .accordion [data-toggle="collapse"].collapsed .fa-chevron-up {
        display: none;
    }
    /* ================================= */
</style>

<div id="{{ $id }}" class="accordion">
    <div class="card">
        <div class="card-header">
            <h5 class="mb-0" data-toggle="collapse" data-target="#{{ $idCode }}-1" aria-expanded="true" aria-controls="{{ $idCode }}-1">
                <i class="fas fa-chevron-down" aria-hidden="true"></i>
                <i class="fas fa-chevron-up" aria-hidden="true"></i>
                {!! $title !!}
            </h5>
        </div>
        <div id="{{ $idCode }}-1" class="collapse show" data-parent="#{{ $id }}" style="">
            <div class="card-body">
                {!! $content !!}
            </div>
        </div>
    </div>
</div>