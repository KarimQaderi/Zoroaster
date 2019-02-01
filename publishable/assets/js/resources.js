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

function setParameters(param) {
    var UrlResource = new URLSearchParams();
    var url = [];
    var getVars = getUrlVars();

    for (var i = 0; i < getVars.length; i++)
        UrlResource.set(getVars[i].name, getVars[i].value);

    for (var i = 0; i < param.length; i++)
        UrlResource.set(param[i].name, param[i].value);

    ChangeUrl('', '?' + UrlResource.toString());

    for (let p of UrlResource) {
        url.push({name: p[0], value: p[1]});
    }

    return url;
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
    var vars = [], hash;
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');

    if (window.location.href.indexOf('?') === -1) return vars;
    for (var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
        vars.push({name: hash[0], value: hash[1]});
    }
    return vars;
}

function get_data_index_resources(resource) {

    $this = $('[data-resource="' + resource + '"]');

    return [
        {name: 'resource', value: resource},
        {name: 'viaRelationshipFieldName', value: $this.attr('data-viaRelationshipFieldName')},
        {name: 'viaRelationship', value: $this.attr('data-viaRelationship')},
        {name: 'viaResourceId', value: $this.attr('data-viaResourceId')},
        {name: 'relationshipType', value: $this.attr('data-relationshipType')},
    ]
}

function index_resources(resource) {

    $this = $('[data-resource="' + resource + '"]');

    $($this.find('.data_table')).html("<span uk-icon=\"load\"></span>");

    var param = getUrlVars();

    ajaxGET($this.attr('data-route'), mergeArray(param, get_data_index_resources(resource)),
        function (data) {

            if (isset(data.error))
                notification(data.error, 'danger');

            $('[data-resource="' + data.resource + '"] .data_table').html(data.render);
        }, function (data) {
            var errors = data.responseJSON;
        });
}

function Destroy($resourceId, resource_ajax) {

    $destroy_resourceId = $resourceId;

    if (!isString(resource_ajax))
        $.each($destroy_resourceId, function (_key, _value) {
            resource_ajax.find('[destroy-resourceId="' + _value + '"]').addClass('destroy-resourceid');
        });

    $.ajax({
        type: 'DELETE',
        url: Zoroaster_resource_destroy,
        data: {
            _token: $('meta[name="_token"]').attr('content'),
            resourceId: $destroy_resourceId,
            resource: isString(resource_ajax) ? Zoroaster_resource_name : resource_ajax.attr('data-resource')

        },
        success: function (data) {
            if (!isString(resource_ajax))
                $.each($destroy_resourceId, function (_key, _value) {
                    resource_ajax.find('[destroy-resourceId="' + _value + '"]').remove();
                });
            else
                UIkit.modal.alert('رکورد حذف شد',
                    {
                        labels: {ok: 'باشه'},
                        addClass: 'modal_alert'
                    }).then(function () {
                    window.location = Zoroaster_resource_index;
                });
        },
        error: function (data) {
            var errors = data.responseJSON;
        }
    });
}

function DestroySoftDeleting($resourceId, resource_ajax) {
    $destroy_resourceId = $resourceId;

    if (!isString(resource_ajax))
        $.each($destroy_resourceId, function (_key, _value) {
            resource_ajax.find('[destroy-resourceId="' + _value + '"]').addClass('destroy-resourceid');
        });

    $.ajax({
        type: 'POST',
        url: Zoroaster_resource_softDeleting,
        data: {
            _token: $('meta[name="_token"]').attr('content'),
            resourceId: $destroy_resourceId,
            resource: isString(resource_ajax) ? Zoroaster_resource_name : resource_ajax.attr('data-resource')
        },
        success: function (data) {
            if (!isString(resource_ajax))
                $.each(data, function (_key, _value) {
                    var destroy = resource_ajax.find('[destroy-resourceId="' + _value.id + '"]');
                    destroy.find('.action_btn').html(_value.col);
                    destroy.removeClass('destroy-resourceid');
                });
            else
                UIkit.modal.alert('رکورد حذف شد',
                    {
                        labels: {ok: 'باشه'},
                        addClass: 'modal_alert'
                    }).then(function () {
                    location.reload();
                });
        },
        error: function (data) {
            var errors = data.responseJSON;
        }
    });
}

function Restore($resourceId, resource_ajax) {
    $destroy_resourceId = $resourceId;

    if (!isString(resource_ajax))
        $.each($destroy_resourceId, function (_key, _value) {
            resource_ajax.find('[destroy-resourceId="' + _value + '"]').addClass('Restore-resourceid');
        });

    $.ajax({
        type: 'PUT',
        url: Zoroaster_resource_restore,
        data: {
            _token: $('meta[name="_token"]').attr('content'),
            resourceId: $destroy_resourceId,
            resource: isString(resource_ajax) ? Zoroaster_resource_name : resource_ajax.attr('data-resource')
        },
        success: function (data) {

            if (!isString(resource_ajax))
                $.each(data, function (_key, _value) {
                    var destroy = resource_ajax.find('[destroy-resourceId="' + _value.id + '"]');
                    destroy.find('.action_btn').html(_value.col);
                    destroy.removeClass('Restore-resourceid');
                });
            else
                UIkit.modal.alert('رکورد بازیابی شد',
                    {
                        labels: {ok: 'باشه'},
                        addClass: 'modal_alert'
                    }).then(function () {
                    location.reload();
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
            Restore([$this.attr('resourceId')], ($this.attr('data-view') === 'Detail') ? 'Detail' : $this.closest('.resource-ajax'));
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
            DestroySoftDeleting([$this.attr('resourceId')], ($this.attr('data-view') === 'Detail') ? 'Detail' : $this.closest('.resource-ajax'));
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
            Destroy([$this.attr('resourceId')], ($this.attr('data-view') === 'Detail') ? 'Detail' : $this.closest('.resource-ajax'));
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

        $resourceClass = $(this).closest('.resource-ajax').attr('data-resource');

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

        index_resources($resourceClass);

    });

    // Search dataTable
    $(document).on('keyup', '.resource-ajax .search', function (e) {

        if (e.keyCode == 13) {
            $resourceClass = $(this).closest('.resource-ajax').attr('data-resource');
            $val = $('[data-resource="' + $resourceClass + '"] .search input').val();
            var param = [{name: $resourceClass + '_search', value: $val}];
            param = setParameters(param);
            index_resources($resourceClass);
        }
    });

    // dataTables_paginate
    $(document).on('click', '.dataTables_paginate div', function (e) {

        $resourceClass = $(this).closest('.resource-ajax').attr('data-resource');

        var page = $(this).attr('data-page');

        var param = [{name: $resourceClass + '_Page', value: page}];

        param = setParameters(param);

        index_resources($resourceClass);

    });
});


function activeEelementByClass($activeEelementByClass) {

    $.each($activeEelementByClass, function ($item, $items) {
        $('.' + $items.class).addClass('hidden');
    });
}

function activeEelementByClassFind($activeEelementByClass, $find) {

    $found = null;
    $.each($activeEelementByClass, function ($item, $items) {
        if ($items.optionsKey == $find)
            $found = $items.class;
    });
    return $found;
}


function mergeArray(array_1, array_2) {
    for (var i = 0; i < array_2.length; i++) {
        array_1.push({name: array_2[i].name, value: array_2[i].value});
    }

    return array_1;
}


function isset($var) {
    if (typeof ($var) != "undefined" && $var !== null) {
        return true;
    }
    return false;
}

function isString($var) {
    if (Object.prototype.toString.call($var) == '[object String]')
        return true;
    else
        return false;
}


function dd($var) {
    console.log($var);
}

function notification(massage, type) {
    UIkit.notification(massage, {pos: 'bottom-right', status: type})
}

function route(name, parameters = []) {

    if (!isset(Zoroaster_jsRoute[name])) {
        dd($name + ' روت  پیدا نشد');
        return null;
    }

    var route = Zoroaster_jsRoute[name];
    $.each(parameters, function ($key, $value) {
        route = route.replace('{' + $key + '}', $value);
    });
    return route;

}

function click(selector, $function) {
    $(document).on('click', selector, function (e) {
        $function(this);
    });
}

function change(selector, $function) {
    $(document).on('change', selector, function (e) {
        $function(this);
    });
}