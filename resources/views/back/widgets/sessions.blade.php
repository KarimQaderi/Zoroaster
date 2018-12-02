
<script>


    $(".voyager .files_cachess button").on("click", function () {
        var  t=$(this);
        var id=$('.files_cachess input[type="text"]').val();
        if(id=='') id=0;
        $.ajax({
            type: 'GET',
            {{--url: '{{ route('back-ajax.AjaxFilesCache',['','','']) }}/'+t.attr('data-type')+'/'+$('.files_cachess select').find(':selected').val()+'/'+id,--}}
            // data: {
            //     _token: $('meta[name="_token"]').attr('content'),
            //     type: 'Forget',
            //     select: $('.files_cache select').find(':selected').val(),
            // },
            success: function (data) {
                alert(data);
            }
        });
    });

</script>



<div class="widget session_cache uk-width-auto" uk-grid>

    <div class="uk-text-right">
        <button data-type="Forget"  class="uk-button-primary">
            Forget
        </button>
        <button data-type="Flush" class="uk-button-danger">
            Flush
        </button>
    </div>

    <div class="uk-text-left">
        <h1>Sessions Cache</h1>
        <div>
            Cache Size: <code>{{ $size_cache->size }}</code>
        </div>
        <div>
            Folder Count : <code>{{ $size_cache->folder }}</code>
        </div>
        <div>
            File Count : <code>{{ str_replace('-','',$size_cache->count-$size_cache->folder)-1 }}</code>
        </div>
    </div>
</div>


