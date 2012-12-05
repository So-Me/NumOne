
$(function () {

    // 不是我啰嗦，这些get_xxx_div的操作真的可以抽象出来

    $('input[type=checkbox].group').widget('checkboxGroup');

    $('.price-detail-btn').click(function () {
        var id = $(this).parents('.order-entry').data('id');
        $.get(
            '/order',
            {
                action: 'get_price_detail_div',
                target: id
            },
            function (ret) {
                if (ret)
                    $$.appendDiv.show(ret);
                else 
                    alert('请等待订单确认');
            });
    });

    // 修改订单信息
    $('.edit-info-btn').click(function () {
        var that = $(this);
        var id = that.parents('.order-entry').data('id');
        $.get(
            '/order/' + id,
            {
                a: 'get_info_div'
            },
            function (ret) {
                var appendDiv = $(ret);
                $('.append-parent').append(appendDiv).show();
                appendDiv.show();
                $$.appendDiv.refreshAll();
            });
    });

    // 订单推进
    $('.next-btn').click(function () {
        var that = $(this);
        var id = that.parents('.order-entry').data('id');
        $.get(
            '/order',
            {
                action: 'get_action_div',
                target: id
            },
            function (ret) {
                if (ret)
                    $$.appendDiv.show(ret);
                else
                    alert('请先选择工厂');
            }, 'html');
    });

    // 选择工厂 弹出框
    $('.choose-factory-btn').click(function () {
        var id = $(this).parents('.order-entry').data('id');
        $.get(
            '/order',
            {
                action: 'get_factory_div',
                target: id
            },
            function (ret) {
                $$.appendDiv.show(ret);
            });
    });

    // 价格计算
    $('.price-change-btn').click(function () {
        var that = $(this);
        
        var entry = that.parents('.order-entry');
        if (entry.find('.text.choose-factory-btn').length === 0) {
            alert('请先选择工厂');
            return;
        }
        
        var id = entry.data('id');
        $.get(
            '/order/' + id,
            {
                a: 'get_price_div',
                title: that.data('title'),
                type: that.data('type')
            },
            function (ret) {
                $$.appendDiv.show(ret);
            }, 'html');
    });

    // 客户已付
    $('.pay-btn').click(function () {

        var that = $(this);
        var id = that.parents('.order-entry').data('id');
        $.get(
            '/order/' + id,
            {
                a: 'get_pay_div'
            },
            function (ret) {
                $$.appendDiv.show(ret);
            });
    });

    // 填写主石
    $('.stone-btn').click(function () {
        var id = $(this).parents('.order-entry').data('id');
        $.get(
            '/order',
            {
                action: 'get_stone_div',
                target: id
            },
            function (ret) {
                $$.appendDiv.show(ret);
            }, 'html');
    });

    // 主石详情
    $('.stone-detail-btn').click(function () {
        $$.popup.globalHide = false;
        var that = $(this);
        var id = that.data('id');
        var div = that.siblings('.stone-detail');
        if (div.html()) {
            div.toggle();
        } else {
            $.get(
                '/stone',
                {
                    action: 'get_stone_detail_div',
                    target: id
                },
                function (ret) {
                    div.html(ret).show();
                });
        }
    });

    $('.detail-btn').click(function () {
        var that = $(this);
        var entry = that.parents('.order-entry');
        var id = entry.data('id');
        var div = entry.find('.order-detail');
        if (div.html()) {
            div.toggle();
            return;
        }
        $.get(
            '/order',
            {
                action: 'get_detail_div',
                target: id
            },
            function (ret) {
                div.html(ret).show();
            })
    });
});
