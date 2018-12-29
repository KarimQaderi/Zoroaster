<label>
    <span class="label">{{ $field->label }}</span>
    <div class="body"><span class="uk-border-pill @if($value===1) boolen-green @else boolen-red @endif"></span>@if($value===1) روشن @else خاموش @endif</div>
</label>