<div>
    <label>زباله</label>
    <div class="body">
        <select class="uk-select" name="FilterTrashed">
            @foreach($FilterTrashed as $key=>$value)
                <option @if(request()->FilterTrashed == $key) selected @endif value="{{ $key }}">{{ $value }}</option>
            @endforeach
        </select>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('[name="FilterTrashed"]').change(function () {
            setGetParameter('FilterTrashed', $('[name="FilterTrashed"]').find(':selected').val());
        });
    });
</script>