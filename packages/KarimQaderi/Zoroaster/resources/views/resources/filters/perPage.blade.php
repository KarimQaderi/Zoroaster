<div>
    <label>تعداد در هر صفحه</label>
    <div class="body">
        <select class="uk-select" name="perPage">
            @foreach($perPages as $perPage)
                <option @if(request()->perPage == $perPage) selected @endif value="{{ $perPage }}">{{ $perPage }}</option>
            @endforeach
        </select>
    </div>
</div>

<script>
    $(document).ready(function () {
        $('[name="perPage"]').change(function () {
            setGetParameter('perPage', $('[name="perPage"]').find(':selected').val());
        });
    });
</script>