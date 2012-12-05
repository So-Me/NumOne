$(function () {
    // 表单验证 
    $('form.add').validate();

    $('.pay-factory-btn').click(function () {
        var that = $(this);
        var factory_id = that.parents('table').data('id');
        var order_id = that.parents('.entry').data('id');
        $.get(
            '/factory',
            {
                action: 'get_pay_div',
                target: factory_id,
                order: order_id
            },
            function (ret) {
                $$.appendDiv.show(ret);
            });
    });

    $('.view-order-facotry-btn').click(function () {
        var that = $(this);
        var factory_id = that.parents('table').data('id');
        var order_id = that.parents('.entry').data('id');
        // may be this can use load....
        $.get(
            '/factory',
            {
                action: 'get_account_records_div',
                target: factory_id,
                order: order_id
            },
            function (ret) {
                that.siblings('.record').html(ret);
            });
    });

    //
    $('.supply-btn').click(function () {
        var that = $(this);
        var factory_id = that.data('id');
        $.get(
            '/factory',
            {
                action: 'get_stone_recharge_div',
                target: factory_id,
            },
            function (ret) {
                $$.appendDiv.show(ret);
            });
    });
});
