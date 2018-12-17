function ajaxGET(url, data, success, error) {
    $.ajax({
        type: 'GET',
        url: url,
        data: data,
        success: function (data) {
            success(data);
        },
        error: function (data) {
            error(data);
        }
    });
}

function RemoveParameter(param) {
    var url = window.location.href;
    var hash = location.hash;
    $.each(param, function (key, value) {
        url = url.replace(hash, '');
        if (url.indexOf(value[0] + "=") >= 0) {
            var prefix = url.substring(0, url.indexOf(value[0]));
            var suffix = url.substring(url.indexOf(value[0]));
            suffix = suffix.substring(suffix.indexOf("=") + 1);
            suffix = (suffix.indexOf("&") >= 0) ? suffix.substring(suffix.indexOf("&")) : "";
            url = prefix + value[0] + "=" + value[1] + suffix;
        }
        else {
            if (url.indexOf("?") < 0)
                url += "?" + value[0] + "=" + value[1];
            else
                url += "&" + value[0] + "=" + value[1];
        }

    });

    url = url + hash;
    var vars = [], hash, hashs;
    var hashes = url.slice(url.indexOf('?') + 1).split('&');

    if (url.indexOf('?') !== -1)
        for (var i = 0; i < hashes.length; i++) {
            hash = hashes[i].split('=');
            vars.push({name: hash[0], value: hash[1]});
        }

    return [url, vars];
}

function setParameters(param) {
    var url = [];
    var getVars = getUrlVars();
    for (var i = 0; i < param.length; i++)
        getVars.push({name: param[i].name, value: param[i].value});


    for (var i = 0; i < getVars.length; i++)
        url.push([getVars[i].name, getVars[i].value])

    var Remove = RemoveParameter(url);
    ChangeUrl('', Remove[0]);
    return Remove[1];
}

function ChangeUrl(title, url) {
    if (typeof (history.pushState) != "undefined") {
        var obj = {Title: title, Url: url};
        history.pushState(obj, obj.Title, obj.Url);
    } else {
        alert("Browser does not support HTML5.");
    }
}

function getUrlVars() {
    var vars = [], hash, hashs;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');

    if (window.location.href.indexOf('?') === -1) return vars;
    for (var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
        vars.push({name: hash[0], value: hash[1]});
    }
    return vars;
}

function mergeArray(array_1, array_2) {
    for (var i = 0; i < array_2.length; i++) {
        array_1.push({name: array_2[i].name, value: array_2[i].value});
    }

    return array_1;
}

function index_resources(resource) {

    $this = $('[data-resource="' + resource + '"]');

    $($this).html("<span uk-icon=\"load\"></span>");

    var param = getUrlVars();
    param.push({name: 'resource', value: resource});

    ajaxGET(Zoroaster_resource_ajax_index, param,
        function (data) {
            $('[data-resource="' + data.resource + '"]').html(data.render);
        }, function (data) {
            var errors = data.responseJSON;
        });
}

function Destroy($resourceId, resource_ajax) {
    $this = $(this);
    $destroy_resourceId = $resourceId;

    $.each($destroy_resourceId, function (_key, _value) {
        resource_ajax.find('[destroy-resourceId="' + _value + '"]').addClass('destroy-resourceid');
    });

    $.ajax({
        type: 'DELETE',
        url: Zoroaster_resource_destroy,
        data: {
            _token: $('meta[name="_token"]').attr('content'),
            resourceId: $destroy_resourceId,
            resource: resource_ajax.attr('data-resource')

        },
        success: function (data) {
            $.each($destroy_resourceId, function (_key, _value) {
                resource_ajax.find('[destroy-resourceId="' + _value + '"]').remove();
            });
        },
        error: function (data) {
            var errors = data.responseJSON;
        }
    });
}

function DestroySoftDeleting($resourceId, resource_ajax) {
    $destroy_resourceId = $resourceId;

    $.each($destroy_resourceId, function (_key, _value) {
        resource_ajax.find('[destroy-resourceId="' + _value + '"]').addClass('destroy-resourceid');
    });

    $.ajax({
        type: 'POST',
        url: Zoroaster_resource_softDeleting,
        data: {
            _token: $('meta[name="_token"]').attr('content'),
            resourceId: $destroy_resourceId,
            resource: resource_ajax.attr('data-resource')
        },
        success: function (data) {
            $.each(data, function (_key, _value) {
                var destroy = resource_ajax.find('[destroy-resourceId="' + _value.id + '"]');
                destroy.find('.action_btn').html(_value.col);
                destroy.removeClass('destroy-resourceid');
            });

        },
        error: function (data) {
            var errors = data.responseJSON;
        }
    });
}

function Restore($resourceId, resource_ajax) {
    $destroy_resourceId = $resourceId;

    $.each($destroy_resourceId, function (_key, _value) {
        resource_ajax.find('[destroy-resourceId="' + _value + '"]').addClass('Restore-resourceid');
    });

    $.ajax({
        type: 'PUT',
        url: Zoroaster_resource_restore,
        data: {
            _token: $('meta[name="_token"]').attr('content'),
            resourceId: $destroy_resourceId,
            resource: resource_ajax.attr('data-resource')
        },
        success: function (data) {
            $.each(data, function (_key, _value) {
                var destroy = resource_ajax.find('[destroy-resourceId="' + _value.id + '"]');
                destroy.find('.action_btn').html(_value.col);
                destroy.removeClass('Restore-resourceid');
            });

        },
        error: function (data) {
            var errors = data.responseJSON;
        }
    });
}

$(document).ready(function () {


    // MianForceDeletingAll
    $(document).on('click', '.MianForceDeletingAll', function () {
        $this = $(this).closest('.resource-ajax');
        $getKeyName = $this.attr('data-getKeyName');

        var arrResourceId = [];

        $this.find('.key_dataTable_' + $getKeyName + ':checked').each(function () {
            arrResourceId.push(this.value);
        });

        UIkit.modal.confirm(
            '<h2>حذف رکورد ها</h2>' +
            '<h3>شما دارید این  رکورد ها رو حذف می کنید مطمئن هستید</h3>'
            , {
                labels: {ok: 'حذف', cancel: 'خیر'},
                addClass: 'modal_delete'
            }).then(function () {
            Destroy(arrResourceId, $this);
        });

    });

    // ForceDeletingAll
    $(document).on('click', '.ForceDeletingAll', function () {

        $this = $(this).closest('.resource-ajax');
        $getKeyName = $this.attr('data-getKeyName');
        $isForceDeleting = $this.attr('data-isForceDeleting');

        var arrResourceId = [];

        $this.find('.key_dataTable_' + $getKeyName + ':checked').each(function () {
            arrResourceId.push(this.value);
        });

        UIkit.modal.confirm(
            '<h2>حذف رکورد ها</h2>' +
            '<h3>شما دارید این  رکورد ها رو حذف می کنید مطمئن هستید</h3>'
            , {
                labels: {ok: 'حذف', cancel: 'خیر'},
                addClass: 'modal_delete'
            }).then(function () {
            if ($isForceDeleting)
                DestroySoftDeleting(arrResourceId, $this);
            else
                Destroy(arrResourceId, $this);

        });

    });

    // restore-one-resource
    $(document).on('click', '.restore-one-resource', function () {

        $this = $(this);

        UIkit.modal.confirm(
            '<h2>بازیابی رکورد</h2>' +
            '<h3>شما دارید این رکورد رو بازیابی می کنید مطمئن هستید</h3>'
            , {
                labels: {ok: 'بله', cancel: 'خیر'},
                addClass: 'modal_restore'
            }).then(function () {
            Restore([$this.attr('resourceId')], $this.closest('.resource-ajax'));
        });

    });

    // softDeleting
    $(document).on('click', '.softDeleting', function () {

        $this = $(this);

        UIkit.modal.confirm(
            '<h2>حذف رکورد</h2>' +
            '<h3>شما دارید این رکورد رو حذف می کنید مطمئن هستید</h3>'
            , {
                labels: {ok: 'حذف', cancel: 'خیر'},
                addClass: 'modal_delete'
            }).then(function () {
            DestroySoftDeleting([$this.attr('resourceId')], $this.closest('.resource-ajax'));
        });

    });

    // ForceDeleting
    $(document).on('click', '.ForceDeleting', function () {

        $this = $(this);

        UIkit.modal.confirm(
            '<h2>حذف رکورد</h2>' +
            '<h3>شما دارید این رکورد رو حذف می کنید مطمئن هستید</h3>'
            , {
                labels: {ok: 'حذف', cancel: 'خیر'},
                addClass: 'modal_delete'
            }).then(function () {
            Destroy([$this.attr('resourceId')], $this.closest('.resource-ajax'));
        });

    });

    // dataTable checkbox checked
    $(document).on('change', '.key_dataTable', function () {
        $this = $(this).closest('.resource-ajax');
        $getKeyName = $this.attr('data-getKeyName');

        if ($(this).is(':checked'))
            $('.key_dataTable_' + $getKeyName).prop('checked', true);
        else
            $('.key_dataTable_' + $getKeyName).prop('checked', false);

    });

    // Sort dataTable
    $(document).on('click', '.dataTables th.cursor-pointer', function () {

        $this = $(this).closest('.resource-ajax');
        $resourceClass = $this.attr('data-resource');
        $ThisresourceClass = $('[data-resource="' + $resourceClass + '"]');

        var name = $(this).attr('data-sortable_field');
        var sort = $(this).attr('data-sortable');

        switch (sort) {
            case '':
                sort = 'desc';
                break;

            case 'desc':
                sort = 'asc';
                break;

            case 'asc':
                sort = 'desc';
                break;
        }

        var param = [];
        param.push({name: $resourceClass + '_sortable_direction', value: sort});
        param.push({name: $resourceClass + '_sortable_field', value: name});

        param = setParameters(param);

        param.push({name: 'resource', value: $resourceClass});


        $ThisresourceClass.html("<span uk-icon=\"load\"></span>");
        ajaxGET(Zoroaster_resource_ajax_index, param,
            function (data) {
                $('[data-resource="' + data.resource + '"]').html(data.render);
            },
            function (data) {
                var errors = data.responseJSON;
            }
        );

    });

    // Search dataTable
    $(document).on('keyup', '.resource-ajax .search', function (e) {

        if (e.keyCode == 13) {
            $this = $(this).closest('.resource-ajax');
            $resourceClass = $this.attr('data-resource');
            $ThisresourceClass = $('[data-resource="' + $resourceClass + '"]');
            $val = $('[data-resource="' + $resourceClass + '"] .search input').val();

            $this.html("<span uk-icon=\"load\"></span>");

            var param = [{name: $resourceClass + '_search', value: $val}];

            param = setParameters(param);

            param.push({name: 'resource', value: $resourceClass});

            ajaxGET(Zoroaster_resource_ajax_index, param,
                function (data) {
                    $('[data-resource="' + data.resource + '"]').html(data.render);
                }, function (data) {
                    var errors = data.responseJSON;
                });

        }
    });
});