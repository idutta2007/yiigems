(function ($) {
    $.widget( "yiigems.transientMessage", {
        // default options
        options: {
            iconClass: "icon-info pull-left",
            fadeInDuration: 300,
            stayDuration: 500,
            fadeOutDuration: 300,
            containerSelector: 'body'
        },

        _create: function(){
            this._super();
        },

        _init: function(){
            this._super();
            this.element.css({
                display: "none",
                position: "absolute"
            });
        },
                
        displayMessage: function(message){
           var widget = this;
           var opts = this.options;
           var msg = this.element;
           var htmlText = opts.iconClass ? "<span class='" + opts.iconClass + "'></span> " + message : message;
           msg.find( ".msg-container").html( htmlText );
           msg.css({ display: "inline-block"});

           msg.position({
               my: "center center",
               at: "center center",
               of: window,
               collision: "fit fit"
           });

            // Call twice to prevent first time mis-positioning
            msg.position({
                my: "center center",
                at: "center center",
                of: window,
                collision: "fit fit"
            });

            // Convert from string to integers
            if ( typeof opts.fadeInDuration == 'string') opts.fadeInDuration = parseInt(opts.fadeInDuration);
            if ( typeof opts.stayDuration == 'string') opts.stayDuration = parseInt(opts.stayDuration);
            if ( typeof opts.fadeOutDuration == 'string') opts.fadeOutDuration = parseInt(opts.fadeOutDuration);
            msg.hide().fadeIn(opts.fadeInDuration, function(){
                msg.delay(opts.stayDuration).fadeOut(opts.fadeOutDuration);
            });
        }
    });

})(jQuery);