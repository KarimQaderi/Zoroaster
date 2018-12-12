<span class="label">{{ $field->label }}</span>&nbsp;
<div class="pivot_check_box">
    <span class="uk-text-warning uk-text-small-2">{{ Zoroaster::getMeta($field,'helpText') }}</span>
    <div class="baron__scroller">
        @foreach($show as $item)
            <label for="{{ $item->{$field->model_show_foreign_key} }}">
                {{ $item->{$field->model_show_title} }}
                <input @if (in_array($item->{$field->model_show_foreign_key},$pivot)) checked @endif id="{{ $item->{$field->model_show_foreign_key} }}"
                       value="{{ $item->{$field->model_show_foreign_key} }}" name="{{ $field->name }}[]" class="uk-checkbox" type="checkbox">
            </label>
        @endforeach
    </div>
    <div class="baron__track">
            <div class="baron__bar"></div>
    </div>
</div>

<script>
    baron({
        root: '.pivot_check_box',
        scroller: '.baron__scroller',
        bar: '.baron__bar',
        scrollingCls: '_scrolling',
        draggingCls: '_dragging'
    }).fix({
        elements: '.header__title',
        outside: 'header__title_state_fixed',
        before: 'header__title_position_top',
        after: 'header__title_position_bottom',
        clickable: true
    }).controls({
        // Element to be used as interactive track. Note: it could be different from 'track' param of baron.
        track: '.baron__track',
        forward: '.baron__down',
        backward: '.baron__up'
    });
</script>