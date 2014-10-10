(function ($) {
    $.widget( "yiigems.simpleList", {
        // default options
        options: {
            itemTag : "li",
            itemContentWrapper : null,
            itemIconClass : "icon-arrow-right"
        },

        _create: function(){
            this._super();
        },

        _init: function(){
            this._super();
            var list = this.element;
            var options = this.options;
            
            // Add icons
            if ( options.itemIconClass ){
                var markup = "<span class='" + options.itemIconClass + "'> ";
                list.find(options.itemTag).prepend( markup);
            }
            
            // Add item content wrapper
            if ( options.itemContentWrapper){
                var wrapperTag = null;
                if ( options.itemContentWrapper.indexOf( "<") == 0 ){
                    wrapperTag = options.itemContentWrapper;
                }
                else {
                    var wrapperTag = "<" + options.itemContentWrapper + "  class='content'></" + options.itemContentWrapper + ">";
                }
                list.find(options.itemTag).wrapInner(wrapperTag);
            }
        }
    });

})(jQuery);