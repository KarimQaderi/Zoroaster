function Prompt($title, $formSubmit, $btn_name, $value = '', $alert = '') {
    $.confirm({
        animation: 'zoom',
        closeAnimation: 'zoom',
        title: $title,
        columnClass: 'zoroaster_prompt',
        smoothContent: false,
        content:
            '<form class="formName">' +
            '<input type="text" value="' + $value + '" class="uk-input" required />' +
            '<div class="alert-danger">' + $alert + '</div>' +
            '</form>',
        buttons: {
            formSubmit: {
                text: isset($btn_name.submit) ? $btn_name.submit : 'ثبت',
                btnClass: 'btn-blue',
                action: function () {
                    $formSubmit(this.$content.find('input').val(), this);
                }
            },
            cancel: {
                text: isset($btn_name.cancel) ? $btn_name.cancel : 'لــــغــــو',
                action: function () {
                    //close
                },
            }
        },
        onContentReady: function () {
            // bind to events
            var jc = this;
            this.$content.find('form').on('submit', function (e) {
                // if the user submits the form by pressing enter in the field.
                e.preventDefault();
                jc.$$formSubmit.trigger('click'); // reference the button and click it
            });
        }
    })
}

function Confirm_delete(title, $function) {
    Confirm(title, $function, {confirm: 'حذف'}, 'Confirm_delete');
}

function Confirm(title, confirm_function, btn_name, columnClass = '') {
    var that = $.confirm({
        animation: 'zoom',
        closeAnimation: 'zoom',
        title: title,
        content: null,
        smoothContent: false,
        columnClass: 'zoroaster_confirm ' + columnClass,
        buttons: {
            confirm: {
                text: isset(btn_name.confirm) ? btn_name.confirm : 'ثبت',
                btnClass: isset(btn_name.submit_class) ? btn_name.submit_class : 'btn-blue',
                action: function () {
                    confirm_function();
                }
            },
            cancel: {
                text: isset(btn_name.cancel) ? btn_name.cancel : 'لــــغــــو',
                btnClass: isset(btn_name.cancel_class) ? btn_name.cancel_class : '',
                action: function () {
                }
            },
        }
    });
}