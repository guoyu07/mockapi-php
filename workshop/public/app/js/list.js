(function ($, bootbox, Util, Config, App) {
    var page = {el: {}, func: {}};
    $(function () {
        page.func.init = function () {
            page.el.searchText = $('#nav-search-input');
            page.el.listTable = $('#listTable');
            page.el.listTableTbody = $('#listTable tbody');
            page.el.searchText.val(Util.getQueryStringByName('url'));
        };

        page.func.bindEvent = function () {
            $('table th input:checkbox').on('click', function () {
                var that = this;
                $(this).closest('table').find('tr > td:first-child input:checkbox')
                    .each(function () {
                        this.checked = that.checked;
                        $(this).closest('tr').toggleClass('selected');
                    });

            });

            page.el.searchText.on('keydown', function (e) {
                if (e.which == 13) {
                    page.func.doQuery();
                }
            });

            page.el.listTableTbody.on("click", "a.delete-rule", function (e) {
                var target = $(e.target);
                var tds = target.parents('tr').children('td');
                var bgColor = tds.first().css('background-color');
                tds.css({'background-color': '#FF0000'});
                var id = target.attr('data');
                App.showConfirmDialog('确定删除规则 <span style="color: #ff0000;font-weight: bold;">' + id + '</span> ?', function (result) {
                    if (result) {
                        $.ajax({
                            url: Config.url.removeRule,
                            type: 'post',
                            dataType: 'json',
                            data: {
                                '_id': id
                            },
                            success: function (resp) {
                                if (resp.error == 0) {
                                    App.showSuccessDialog('删除成功');
                                    page.func.doQuery();
                                } else {
                                    App.showErrorDialog('删除失败：' + resp.message);
                                }
                            },
                            error: function (xhr, status, error) {
                                page.func.showErrorDialog('删除失败：' + (status ? status : error));
                            }
                        });
                    } else {
                        tds.css({'background-color': bgColor});
                    }
                });
            });
        };

        /**
         * 查询规则
         * @param url
         * @param cbk
         */
        page.func.query = function (conditions, cbk) {
            $.ajax({
                url: Config.url.listRule,
                type: 'post',
                dataType: 'json',
                data: conditions,
                success: function (resp) {
                    if (resp && resp.error == 0 && resp.data && resp.data.list) {
                        cbk(resp.data.list);
                    } else {
                        cbk(null);
                    }
                }
            });
        };

        /**
         * 渲染表格
         * @param list
         */
        page.func.renderTable = function (list) {
            page.el.listTableTbody.children().remove();
            if (list) {
                $.each(list, function (index, item) {
                    var row = $('<tr></tr>');
                    row.append('<td class="center">' +
                        '<label><input type="checkbox" class="ace" value="' + item['_id'] + '"/>' +
                        '<span class="lbl"></span></label></td>');
                    row.append('<td>' + item['_id'] + '</td>');
                    row.append('<td>' + item.url + '</td>');
                    row.append('<td>' + (item.group === null ? '' : item.group) + '</td>');
                    row.append('<td>' +
                        '<div class="visible-md visible-lg hidden-sm hidden-xs action-buttons">' +
                        '<a class="green edit-rule" title="编辑" href="/display/edit?mode=2&_id=' + item['_id'] + '" data="' + item['_id'] + '"><i class="icon-pencil bigger-130" data="' + item['_id'] + '"></i></a>' +
                        '<a class="blue copy-rule" title="复制" href="/display/edit?mode=3&_id=' + item['_id'] + '" data="' + item['_id'] + '"><i class="icon-copy bigger-130" data="' + item['_id'] + '"></i></a>' +
                        '<a class="red delete-rule" title="删除" href="javascript:void();" data="' + item['_id'] + '"><i class="icon-trash bigger-130" data="' + item['_id'] + '"></i></a>' +
                        '</div>' +
                        '</td>');
                    page.el.listTableTbody.append(row);
                });
            }
        };

        /**
         * 执行查询
         */
        page.func.doQuery = function () {
            var url = page.el.searchText.val();
            page.func.query({
                    url: url
                },
                page.func.renderTable);
        };

        page.func.init();
        page.func.bindEvent();
        page.func.doQuery();
    });
})(jQuery, bootbox, Util, Config, App);