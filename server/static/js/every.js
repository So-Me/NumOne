/* 
 * by xc
 */

 var d = function (arg) {
    console.log(arg);
 };


// 我自己做的库
(function () {

    // 附加层的关闭按钮
    var appendParent = null;
    var refreshAllAppendDivFunc = 
    window.refreshAppendDiv = refreshAllAppendDivFunc; // 兼容性

    var xcJsLib = {
        appendDiv: {
            hasInit: false,
            appendParent: null,
            init: function () {
                this.appendParent = $('.append-parent');
                this.hasInit = true;
            },
            refreshAll: function () {
                if (!this.hasInit)
                    this.init();

                // 表单验证
                var forms = $('.append-div form');
                if (forms.validate)
                    forms.validate();

                var ap = this.appendParent;
                ap.find('.close-btn').click(function () {
                    $(this).parents('.append-div').hide().parents('.append-parent').hide();
                });

                var isDown = false;
                var title = ap.find('.title');
                var origX, origY;
                title.mousedown(function (e) {
                    isDown = true;
                    var divPos = title.parents('.append-div').offset();
                    origX = e.pageX - divPos.left;
                    origY = e.pageY - divPos.top;
                }).mouseup(function () {
                    isDown = false;
                }).mouseout(function () {
                    isDown = false; // fix bug
                }).mousemove(function (e) {
                    var x, y;
                    if (isDown) {
                        x = e.pageX;
                        y = e.pageY;
                        title.parents('.append-div').offset({
                            left: x - origX,
                            top: y - origY
                        });
                    }
                });
            },
            show: function (arg) {
                if (!this.hasInit)
                    this.init();
                var argIsHtml = 1;
                if (argIsHtml) {
                    var html = arg;
                    var div = this.add(html);
                    div.show();
                    var ap = this.appendParent;
                    ap.show();
                    var w = ap.width();
                    var h = ap.height();
                    var dw = w - div.width();
                    var dh = h - div.height();
                    
                    var offset = {
                        top: dh > 0 ? dh / 2 : 0,
                        left: dw > 0 ? dw / 2 : 0
                    };
                    div.css({
                        top: offset.top + 'px',
                        left: offset.left + 'px'
                    });
                }
            },
            add: function (html) {
                if (!this.hasInit)
                    this.init();
                var div = $(html);
                this.appendParent.append(div);
                this.refreshAll();
                return div;
            }
        },
        popup: {
            globalHide: false
        }
    };
    window.$$ = xcJsLib;
})();

$(function () {
    $$.appendDiv.refreshAll();

    // 单击任何地方，弹出层就消失
    $('body').click(function (e) {
        if ($(e.target).parents('.popup').length === 0 && $$.popup.globalHide) {
            $('.popup').hide();
        }
        $$.popup.globalHide = true;
    });
});
