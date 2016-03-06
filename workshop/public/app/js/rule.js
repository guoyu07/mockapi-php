var Rule = {
    checkRule: function (rule) {
        if (!rule.url) {
            return '请求路径不能为空！';
        }
        if (!Util.isUri(rule.url)) {
            return '请求路径格式错误！';
        }
        if (rule.group && !/^[\w_\-]+$/.test(rule.group)) {
            return '分组名称格式错误！';
        }
        if (rule.jsonp && !/^[\w_]+$/.test(rule.jsonp)) {
            return 'jsonp回调函数名称格式错误！';
        }
        if (!rule.res) {
            return '响应内容不能为空！';
        }
        return true;
    },
    serialize: function(rule){
        if(rule){
            return JSON.stringify(rule);
        }
        return '';
    }
}