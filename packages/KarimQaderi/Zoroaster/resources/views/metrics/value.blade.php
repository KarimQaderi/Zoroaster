<div class="metrics">
    <div uk-grid>
        <div class="uk-width-1-2 label">{{ $label }}</div>
        <div class="uk-width-1-2 uk-text-left">
            <select>
                @foreach($ranges as $key => $_value)
                    <option @if ($range == $key) selected @endif value="{{ $key }}">{{ $_value }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="count">{{ (int)($value) }}</div>
</div>
