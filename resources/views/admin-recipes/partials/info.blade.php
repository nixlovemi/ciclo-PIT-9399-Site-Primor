@inject('mRecipe', 'App\Models\Recipe')

@php
/*
View variables:
===============
    - $RECIPE: App\Models\Recipe
    - $READONLY: bool
*/
@endphp

<div class="row">
    <div class="col-12">
        <div class="form-group">
            <label>Nome *</label>
            <input maxlength="120" {{ (!$READONLY) ?: 'disabled' }} value="{{ old('f-title') ?: $RECIPE?->title }}" name="f-title" type="text" class="form-control input-default" placeholder="Nome" />
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-md-3">
        <div class="form-group">
            <label>Tipo *</label>
            <select
                class="form-control"
                name="f-type"
                {{ (!$READONLY) ?: 'disabled' }}
            >
                @foreach (array_merge(
                    ['' => 'Selecione ...'],
                    $mRecipe::TYPES
                ) as $type)
                    <option
                        value="{{ $type }}"
                        {{ $type !== (old('f-type') ?: $RECIPE?->type) ? '': 'selected' }}
                    >{{ $type }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-12 col-md-3">
        <div class="form-group">
            <label>Dificuldade *</label>
            <select
                class="form-control"
                name="f-difficulty"
                {{ (!$READONLY) ?: 'disabled' }}
            >
                @foreach (array_merge(
                    ['' => 'Selecione ...'],
                    $mRecipe::DIFFICULTIES
                ) as $difficulty)
                    <option
                        value="{{ $difficulty }}"
                        {{ $difficulty !== (old('f-difficulty') ?: $RECIPE?->difficulty) ? '': 'selected' }}
                    >{{ $difficulty }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="col-12 col-md-6">
        <div class="form-group">
            <label>Slug *</label>
            <input maxlength="120" {{ (!$READONLY) ?: 'disabled' }} value="{{ old('f-slug') ?: $RECIPE?->slug }}" name="f-slug" type="text" class="form-control input-default" placeholder="Slug" />
            <small class="form-text text-muted">Slug é a parte da URL que identifica a página em questão. Ex: primor.com.br/receitas/<b>jantar-arroz-com-feijao</b></small>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12 col-md-4">
        <div class="form-group">
            <label>Tempo *</label>
            <input maxlength="12" {{ (!$READONLY) ?: 'disabled' }} value="{{ old('f-time-str') ?: $RECIPE?->time_str }}" name="f-time-str" type="text" class="form-control input-default" placeholder="Tempo" />
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="form-group">
            <label>Porções *</label>
            <input maxlength="12" {{ (!$READONLY) ?: 'disabled' }} value="{{ old('f-portions-str') ?: $RECIPE?->portions_str }}" name="f-portions-str" type="text" class="form-control input-default" placeholder="Porções" />
        </div>
    </div>

    <div class="col-12 col-md-4">
        <div class="form-group">
            <label>Ativo *</label>
            <select
                class="form-control"
                name="f-active"
                {{ (!$READONLY) ?: 'disabled' }}
            >
                @foreach (['1' => 'Sim', '0' => 'Não'] as $active => $activeLabel)
                    <option
                        value="{{ $active }}"
                        {{ $active != old('f-active', $RECIPE?->active ?? 1) ? '': 'selected' }}
                    >{{ $activeLabel }}</option>
                @endforeach
            </select>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <label>Thumb *</label>
        <br />
        @if (empty($RECIPE?->getThumbFullUrl()))
            <img src="data:image/png;base64, iVBORw0KGgoAAAANSUhEUgAAAC0AAAAtCAMAAAANxBKoAAAAAXNSR0IB2cksfwAAAAlwSFlzAAALEwAACxMBAJqcGAAAADNQTFRF4+Pj4eHh3Nzcx8fH39/f09PTysrK0dHR1tbW1dXV3d3dycnJzMzM0NDQ2tra2NjYzc3N5aw23AAAALlJREFUeJzt010PgiAYBWAPA7/o4///y1ZioQwSrRvf16Ku2sIbGD6cHXGg+ORB1ll/pxHWkxdaAG6eKO/XnGoo2DjWoxgTmjRDDG/hbFJvIW0BXRhSmz2TGL73oWeCGD2FY9Rn7g2zNoXXA/nCTS1Dw5Te0pWrrUvVx27XSXp8vEYrLqpkwxldyT5AlNckfTDqFrdw4URDy1Mc2HCimyH4pY9J0PrxXyCWXW96P+8AvQs/fouz/gt9B/wPOS6V11N8AAAAAElFTkSuQmCC" alt="recipe-thumb" class="recipe-images-adm" />
        @else
            <a href="{{ $RECIPE?->getThumbFullUrl() }}" target="_blank">
                <img src="{{ $RECIPE?->getThumbFullUrl() }}" alt="recipe-thumb" class="recipe-images-adm" />
            </a>
        @endif
        
        <input
            style="width:calc(100% - 65px); display:inline-block; margin-left:8px;"
            class="form-control form-control-sm"
            type="file"
            accept="image/x-png,image/jpeg,image/jpg"
            name="f-thumb-url"
            {{ (!$READONLY) ?: 'disabled' }}
        />
        <small class="form-text text-muted">Selecione uma imagem na proporção 400x400</small>
    </div>
</div>

<div class="row">
    <div class="col-12">
        <label>Banner *</label>
        <br />
        @if (empty($RECIPE?->getThumbFullUrl()))
            <img src="data:image/png;base64, iVBORw0KGgoAAAANSUhEUgAAAC0AAAAtCAMAAAANxBKoAAAAAXNSR0IB2cksfwAAAAlwSFlzAAALEwAACxMBAJqcGAAAADNQTFRF4+Pj4eHh3Nzcx8fH39/f09PTysrK0dHR1tbW1dXV3d3dycnJzMzM0NDQ2tra2NjYzc3N5aw23AAAALlJREFUeJzt010PgiAYBWAPA7/o4///y1ZioQwSrRvf16Ku2sIbGD6cHXGg+ORB1ll/pxHWkxdaAG6eKO/XnGoo2DjWoxgTmjRDDG/hbFJvIW0BXRhSmz2TGL73oWeCGD2FY9Rn7g2zNoXXA/nCTS1Dw5Te0pWrrUvVx27XSXp8vEYrLqpkwxldyT5AlNckfTDqFrdw4URDy1Mc2HCimyH4pY9J0PrxXyCWXW96P+8AvQs/fouz/gt9B/wPOS6V11N8AAAAAElFTkSuQmCC" alt="recipe-thumb" class="recipe-images-adm" />
        @else
            <a href="{{ $RECIPE?->getBannerFullUrl() }}" target="_blank">
                <img src="{{ $RECIPE?->getBannerFullUrl() }}" alt="recipe-banner" class="recipe-images-adm" />
            </a>
        @endif
        
        <input
            style="width:calc(100% - 65px); display:inline-block; margin-left:8px;"
            class="form-control form-control-sm"
            type="file"
            accept="image/x-png,image/jpeg,image/jpg"
            name="f-banner-url"
            {{ (!$READONLY) ?: 'disabled' }}
        />
        <small class="form-text text-muted">Selecione uma imagem na proporção 1600x524</small>
    </div>
</div>