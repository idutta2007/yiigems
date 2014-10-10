(function ($) {
    $.widget( "yiigems.dropdownButton", {
        // default options
        options: {
        },

        _create: function(){
            this._super();
        },

        _init: function(){
            this._super();
            
            var widget = this;
            var opts = this.options;
            
            widget.element.on("click", function(ev){
                widget.showPopup();
                return false;
            });
            
            $(document).on('click', function(ev){
                var popup = $("#" + opts.popupId).get(0);
                if ( !$.contains(popup, ev.target ) && !$.contains(widget.element.get(0), ev.target) ){
                    widget.hidePopup();
                }
            });
        },
                
        showPopup: function() {
            var widget = this;
            widget.element.addClass("selected");
            
            var popup = $("#" + widget.options.popupId);
            
            var my = "left top+3";
            var at = "left bottom";
            var alignment = this.options.popupAlignment;
            if ( alignment == "right" ){
                my = "right top+3";
                at = "right bottom";
            }
            else if ( alignment == "center" ){
                my = "center top+3";
                at = "center bottom";
            }
            else {
               my = "left top+3";
               at = "left bottom";
            }
            
            popup.hide().css( "opacity", 1 ).show().position({
                    my: my,
                    at: at,
                    of: widget.element,
                    collision: 'flip flip'
            }).css("opacity", 1);
        },
                
        hidePopup: function() {
            this.element.removeClass("selected");
            var popup = $("#" + this.options.popupId);
            popup.hide();
        }
    });
})(jQuery);


