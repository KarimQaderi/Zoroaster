<label>
    <span class="label">{{ $field->label }}</span>
    <span class="uk-text-warning uk-text-small-2">{{ Zoroaster::getMeta($field,'helpText') }}</span>
    <textarea name="{{ $field->name }}">{{ old($field->name,$value) }}</textarea>
</label>

<script>
    var simplemde = new SimpleMDE({
        element: $('[name="{{ $field->name }}"]')[0],
        spellChecker:false,
        toolbar: [
            {
                name: "bold",
                action: SimpleMDE.toggleBold,
                className: "bold",
                title: "Bold",
            }, {
                name: "italic",
                action: SimpleMDE.toggleItalic,
                className: "italic",
                title: "italic",
            },{
                name: "link",
                action: SimpleMDE.drawLink,
                className: "link",
                title: "link",
            },{
                name: "image",
                action: SimpleMDE.drawImage,
                className: "image",
                title: "image",
            },{
                name: "preview",
                action: SimpleMDE.togglePreview,
                className: "view",
                title: "preview",
            },
        ]

    });

    $('.editor-toolbar > a').each(function (index, ele) {
        var old_class = $(ele).attr('class');
        if ($(ele).attr('class')=='view')
        {
            $(ele).attr('uk-icon', old_class);
            $(ele).addClass('no-disable');
        }
        else
        $(ele).attr('uk-icon', old_class);
    });
</script>
