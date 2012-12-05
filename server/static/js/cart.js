$(function () {

    // 删除按钮 弹出面板
    $('.del.btn').click(function () {
        var that = $(this);
        that.siblings('.popup').show();
    });

    // 确认删除按钮
    $('.del .popup .ok-btn').click(function () {
        var entry = $(this).parents('.product-entry');
        var id = entry.data('id');
        $.get(
            '/cart', 
            {
                a: 'del',
                id: id
            },
            function (ret) {
                entry.remove();
                $('a.cart .count').text(ret);
            });
    });

    // 取消删除按钮
    $('.del .popup .cancel-btn').click(function () {
        $(this).parent().hide();
    });

    // 备注表单
    (function () {
        var form = $('form.remark');
        var ti = form.find('.text-in').hide();
        var btn = form.find('.mbtn').hide();
        $('form.remark .text-show').click(function () {
            var that = $(this).hide();
            var thisForm = that.parents('form.remark');
            thisForm.find('.text-in').show().focus().width(that.width());
            thisForm.find('.mbtn').show();
        });
        var submitBtn = $('form.remark input[type=submit]');
        form.each(function () {
            var curForm = $(this).ajaxForm(function () {
                ti.hide();
                btn.hide();
                curForm.find('.text-show').show().text(curForm.find('.text-in').val());
            });
        });
    })();

    // 编辑地址
    $('.edit-addr-btn').click(function () {
        var id = $('input[name=address][checked]').data('id');
        $.get(
            '/address', 
            {
                action: 'get_edit_div',
                target: id
            },
            function (ret) {
                $$.appendDiv.show(ret);
            },
            'html');
    });
});
