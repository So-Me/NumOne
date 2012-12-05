
$(function () {

    // 展开详细信息
    $('.entry').click(function () {
        $(this).siblings('.more-info').toggle();
    });

    // 修改订单按钮
    $('.edit-btn').click(function () {
        var that = $(this);
        var cusId = that.parents('.entry').data('id');
        $.get(
            '/user/' + cusId,
            {
                a: 'get_edit_div'
            },
            function (ret) {
                $$.appendDiv.show(ret);
            });
        return false;
    });

    // 表单验证
    $('form.add').validate();

    // 用户充值
    $('.recharge-btn').click(function () {
        var id = $(this).data('id'); // customer id
        $.get(
            '/user',
            {
                action: 'get_recharge_div',
                target: id
            },
            function (ret) {
                $$.appendDiv.show(ret);
            });
    });
});
