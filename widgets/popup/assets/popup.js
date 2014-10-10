(function ($) {
    $.widget( "yiigems.popup", {
        // default options
        options: {
            popupId: null,
            target: null,
            okButtonClass: null,
            cancelButtonClass: null,
            location: null
        },

        _create: function(){
            this._super();
        },

        _init: function(){
            this._super();
            
            var widget = this;
            var opts = widget.options;
            
            // Add the popup to the end of the body tag
            var popup = $('#x-' + opts.popupId);
            $('body').append(popup);
            popup.attr('id', opts.popupId );
            
            // Display popup when clicked on target
            if ( opts.target.length > 0 ){
                $(opts.target).on('click', function() {
                    widget.displayPopup();
                });
            }
            
            // Hide popup when clicked on closeIcon
            if (opts.closable) {
                var closeIcon = $('#' + opts.popupId + " .closeIcon");
                closeIcon.on('click', function() {
                    widget.hidePopup();
                });
            }
        },
                
        displayPopup: function(){
            var widget = this;
            var opts = widget.options;
            var popup = $("#" + opts.popupId);
            var target = $(opts.target);
            
            popup.show();
            if (opts.location == 'bottom') {
                popup.position({
                    my: 'center top+12',
                    at: 'center bottom',
                    of: target
                });
            }
            if (opts.location == 'top') {
                popup.position({
                    my: 'center bottom-12',
                    at: 'center top',
                    of: target
                });
            }
            else if (opts.location == 'left') {
                popup.position({
                    my: 'right-12 center',
                    at: 'left center',
                    of: target
                });
            }
            else if (opts.location == 'right') {
                popup.position({
                    my: 'left+12 center',
                    at: 'right center',
                    of: target
                });
            }
        },
            
        hidePopup: function(){
            var widget = this;
            var opts = widget.options;
            var popup = $("#" + opts.popupId);
            popup.hide();
        }
    });
})(jQuery);