var App = {};

(function($, bootbox){
    bootbox.setDefaults({locale: 'zh_CN'});
    App.showSuccessDialog = function (message, cbk) {
        bootbox.dialog({
            title: '<i class="icon-ok bigger-120 green"></i>',
            message: message,
            buttons: {
                ok: {
                    label: '确定',
                    callback: cbk
                }
            }
        });
    };

    App.showErrorDialog = function (message, cbk) {
        bootbox.dialog({
            title: '<i class="icon-warning-sign bigger-120 red"></i>',
            message: message,
            buttons: {
                ok: {
                    label: '确定',
                    callback: cbk
                }
            }
        });
    };

    App.showConfirmDialog = function(message, cbk) {
        bootbox.confirm({
            message: message,
            callback: cbk,
        });
    };
})(jQuery, bootbox);