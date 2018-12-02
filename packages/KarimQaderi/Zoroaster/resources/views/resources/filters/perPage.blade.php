<div>
    <label>تعداد در هر صفحه</label>
    <div class="body">
        @php($perPages=['25','50','100','300','500','1000'])
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


        function setGetParameter(paramName, paramValue) {
            var url = window.location.href;
            var hash = location.hash;
            url = url.replace(hash, '');
            if (url.indexOf(paramName + "=") >= 0) {
                var prefix = url.substring(0, url.indexOf(paramName));
                var suffix = url.substring(url.indexOf(paramName));
                suffix = suffix.substring(suffix.indexOf("=") + 1);
                suffix = (suffix.indexOf("&") >= 0) ? suffix.substring(suffix.indexOf("&")) : "";
                url = prefix + paramName + "=" + paramValue + suffix;
            }
            else {
                if (url.indexOf("?") < 0)
                    url += "?" + paramName + "=" + paramValue;
                else
                    url += "&" + paramName + "=" + paramValue;
            }
            window.location.href = url + hash;
        }
    });
</script>