function ajaxGET(url,success,error) {
    $.ajax({
        type: 'GET',
        url: url,
        data: getUrlVars(),
        success: function (data) {
            success(data);
        },
        error: function (data) {
            error(data);
        }
    });
}

function setParameters(param) {
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

    ChangeUrl('', url + hash);
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
    for (var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
        vars.push({name: hash[0], value: hash[1]});
        // vars[hash[0]] = hash[1];
    }
    return vars;
}

