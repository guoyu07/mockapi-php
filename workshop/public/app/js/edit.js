(function ($, bootbox, Util, Rule, Config, App) {
    var page = {el: {}, func: {}, var: {}};
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

            page.var.ruleId = Util.getQueryStringByName('_id');
            page.var.mode = Util.getQueryStringByName('mode');
            if(page.var.mode != 1){
                page.el.btnSave.prop('disabled', true);
            }
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
                    url: (page.var.mode == 2) ? Config.url.modifyRule : Config.url.addRule,
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
            if (page.var.mode == 2) {
                rule._id = page.var.ruleId;
            }
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

        /**
         * 查询规则
         * @param url
         * @param cbk
         */
        page.func.findRuleById = function (id, cbk) {
            $.ajax({
                url: Config.url.findRuleById,
                type: 'post',
                dataType: 'json',
                data: {
                    "_id": id
                },
                success: function (resp) {
                    if (resp && resp.error == 0 && resp.data) {
                        cbk(resp.data);
                    } else {
                        cbk(null);
                    }
                }
            });
        };

        page.func.renderForm = function (rule) {
            if (rule) {
                page.el.btnSave.prop('disabled', false);
                page.el.inputUrl.val(rule.url);
                if (rule.group !== null) {
                    page.el.inputGroup.val(rule.group);
                }
                if (rule.jsonp !== null) {
                    page.el.inputJsonp.val(rule.jsonp);
                }
                if ($.isPlainObject(rule.res)) {
                    page.el.textAreaResponse.val(Util.formatJson(Rule.serialize(rule.res)));
                } else {
                    page.el.textAreaResponse.val(rule.res);
                }
                page.el.textAreaResponse.trigger('input');
            } else {
                App.showConfirmDialog('规则 <span style="color: #ff0000;font-weight: bold;">' + page.var.ruleId + '</span> 不存在，是否新建规则?', function (result) {
                    if (result) {
                        window.location.href = Config.url.displayAddRule;
                    }
                });
            }
        };

        page.func.loadRule = function () {
            if (page.var.mode != 1 && page.var.ruleId) {
                page.func.findRuleById(page.var.ruleId, page.func.renderForm);
            }
        };

        page.func.init();
        page.func.bindEvent();
        page.func.loadRule();
    });
})(jQuery, bootbox, Util, Rule, Config, App);