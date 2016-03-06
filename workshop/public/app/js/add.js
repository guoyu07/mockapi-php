(function ($, bootbox, Util, Rule, Config) {
    var page = {el: {}, func: {}};
    $(function () {
        page.func.init = function () {
            page.el.inputUrl = $('#inputUrl');
            page.el.inputGroup = $('#inputGroup');
            page.el.inputGroup = $('#inputGroup');
            page.el.inputJsonp = $('#inputJsonp');
            page.el.textAreaResponse = $('#textAreaResponse');
            page.el.alertError = $('#alertError');
            page.el.btnSave = $('#btnSave');
            page.el.btnReset = $('#btnReset');
            page.el.strongMessage = $('#strongMessage');

            page.el.textAreaResponse.autosize({append: "\n"});
        };

        page.func.bindEvent = function () {
            page.el.btnSave.click(function () {
                var rule = page.func.getRuleData();
                var checkResult = Rule.checkRule(rule);
                if (checkResult !== true) {
                    page.func.showError(checkResult);
                    return;
                }
                page.func.clearMessage();
                page.el.btnSave.prop('disabled', true);
                $.ajax({
                    url: Config.url.addRule,
                    type: 'post',
                    dataType: 'json',
                    data: {
                        rule: Rule.serialize(rule)
                    },
                    success: function (resp) {
                        if (resp.error == 0) {
                            page.func.showSuccess('保存成功');
                        } else {
                            page.func.showError('保存失败：' + resp.message);
                        }
                        page.el.btnSave.prop('disabled', false);
                    },
                    error: function (xhr, status, error) {
                        page.func.showError('保存失败：' + (status ? status : error));
                        page.el.btnSave.prop('disabled', false);
                    }
                });
            });

            page.el.btnReset.click(function () {
                $.each([page.el.inputUrl, page.el.inputGroup, page.el.textAreaResponse, page.el.inputJsonp],
                    function (index, item) {
                        item.val('');
                    });
            });
        };

        page.func.getRuleData = function () {
            var rule = {
                url: $.trim(page.el.inputUrl.val()),
                group: $.trim(page.el.inputGroup.val()),
                jsonp: $.trim(page.el.inputJsonp.val()),
                res: $.trim(page.el.textAreaResponse.val()),
            };
            return rule;
        };
        page.func.showError = function (message) {
            page.el.strongMessage.html(message);
            page.el.alertError.removeClass('hidden').removeClass('alert-success').addClass('alert-danger');
            page.el.alertError.show();
        };

        page.func.showSuccess = function (message) {
            page.el.strongMessage.html(message);
            page.el.alertError.removeClass('hidden').removeClass('alert-danger').addClass('alert-success');
            page.el.alertError.show();
            page.el.alertError.hide(1000, 'linear', function () {
                page.func.clearMessage();
            });
        };

        page.func.clearMessage = function () {
            page.el.strongMessage.html('');
            page.el.alertError.addClass('hidden');
        };

        page.func.init();
        page.func.bindEvent();
    });
})(jQuery, bootbox, Util, Rule, Config);