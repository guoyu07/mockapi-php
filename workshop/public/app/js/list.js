(function ($, bootbox) {
    var page = {el: {}, func: {}};
    $(function () {
        page.func.init = function () {
            page.el.searchText = $('#nav-search-input');
            page.el.listTable = $('#listTable');
            page.el.listTableTbody = $('#listTable tbody');
        };

        page.func.bindEvent = function(){
            page.el.searchText.on('keydown', function(e){
                if(e.which == 13){
                    page.func.doQuery(1);
                }
            });

            page.el.listTableTbody.on("click", "a.delete-rule",function(e) {
                var target = $(e.target);
                var tds = target.parents('tr').children('td');
                var bgColor = tds.first().css('background-color');
                tds.css({'background-color': '#FF0000'});
                bootbox.confirm('确定删除规则 <span style="color: #ff0000;font-weight: bold;">' + target.attr('data') + '</span> ?', function(result) {
                    if(result) {
                        alert('删除成功');
                    }else{
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
                url: 'rule/list',
                type: 'post',
                dataType: 'json',
                data: conditions,
                success: function (data) {
                    if (data && data.error == 0 && data.data && data.data.list) {
                        cbk(data.data.list);
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
                        '<a class="green edit-rule" title="编辑" href="#" data="' + item['_id'] + '"><i class="icon-pencil bigger-130" data="' + item['_id'] + '"></i></a>' +
                        '<a class="red delete-rule" title="删除" href="#" data="' + item['_id'] + '"><i class="icon-trash bigger-130" data="' + item['_id'] + '"></i></a>' +
                        '</div>' +
                        '</td>');
                    page.el.listTableTbody.append(row);
                });
            }
        };

        /**
         * 执行查询
         */
        page.func.doQuery = function (mode) {
            var url = Util.getQueryStringByName('url');
            if (mode == 1) {
                url = page.el.searchText.val();
            }
            page.func.query({
                    url: url
                },
                page.func.renderTable);
        };

        page.func.init();
        page.func.bindEvent();
        page.func.doQuery();
    });
})(jQuery, bootbox);