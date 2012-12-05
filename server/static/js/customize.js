$(function () {
    $('form').validate();
    $('form input[type=file]').change(function () {
        var form = $(this).parents('form');
        form.validate().cancelSubmit = true;
        form.submit();
    });

    $('.del-img-btn').click(function () {
        var that = $(this);
        var form = that.parents('form');
        that.parents('li').remove();
        form.append('<input name="action" value="del_img">');
        form.validate().cancelSubmit = true;
        form.submit();
    });
});
