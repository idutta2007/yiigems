(function ($) {
    $.widget( "yiigems.titleBox", {
        // default options
        options: {
            expandIcon: "icon-collapse-alt",
            collapseIcon: "icon-expand-alt",
            expandDuration: 400
        },

        _create: function(){
            this._super();
        },

        _init: function(){
            this._super();

            var id =  this.element.attr("id");
            var header = "#" + id + ">.header";
            var content = "#" + id + ">.content";
            var title = "#" + id + ">.header span.titleIcon";
            var options = this.options;

            $(header).css("cursor", "pointer");
            $(header).click( function(){
                var span = null;
                if ( $(content).is(':visible')){
                    $(title).removeClass(options.collapseIcon );
                    $(title).removeClass( options.expandIcon );
                    $(title).addClass(options.expandIcon);
                }
                else {
                    $(title).removeClass( options.collapseIcon );
                    $(title).removeClass( options.expandIcon );
                    $(title).addClass(options.collapseIcon);
                }
                $(content).slideToggle(options.expandDuration);
            });
        }
    });

})(jQuery);

