$(function () {
    $('.post-gold-price-btn').click(function () {
        $.get(
            '/statistics',
            {
                action: 'get_post_gold_price_div'
            },
            function (ret) {
                $$.appendDiv.show(ret);
            });
    });
});
