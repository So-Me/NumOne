var d = function (arg) {
    console.log(arg);
};

(function ($, window) {
    var methods = {
        checkboxGroup: function () {
            var allCtrl = this.filter('.all');
            var eCtrl = this.not('.all');
            allCtrl.change(function () {
                var selfCheck = $(this).prop('checked');
                eCtrl.each(function () {
                    var that = $(this);
                    if (that.prop('checked') ^ selfCheck) {
                        // here why we need to do that??
                        that.prop('checked', selfCheck)
                            .click()
                            .prop('checked', selfCheck);
                    }
                });
            });
            return this;
        },
        tabSelect: function () {
            var all = this;
            return this.click(function () {
                var that = $(this);
                all.removeClass('on');
                that.addClass('on').parent().data('selected', that.text());
            });
        }
    };

    $.fn.widget = function (method) {
        if ( methods[method] ) {
            return methods[method].apply( 
                this, 
                Array.prototype.slice.call( arguments, 1 ));
        } else {
            $.error( 'Method ' +  method + ' does not exist on jQuery.widget' );
        }    
    }
})(jQuery, window);

// Usage:
// $(['input[type=checkbox].group']).widget('checkboxGroup');
