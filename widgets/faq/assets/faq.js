(function ($) {
    $.fn.faq = function (customOptions) {
        customOptions = customOptions || {};
        var options = {
            duration: 300,
            createNavLinks: true,
            expandIconClass : "icon-expand-alt",
            collapseIconClass : "icon-collapse-alt"
        };
        $.extend(options, customOptions);
        
        return this.each(function () {
            // Add icons
            var markup = "<span class='faq-icon " + options.expandIconClass + "'></span>";
            $(this).find( ".question").prepend( markup);
            
            // Add navigation links after answer
            if ( options.createNavLinks ){
                addNavigationLink( $(this).find( ".answer"), options );
            }
            
            // hide answers and navigation links initially
            $(this).find( ".answer, .faqnav").css({
                display: "none"
            });
            
            
            // Handle clicks on the question
            $(this).find( ".question").click(function(){
                var span = null;
                if ( $(this).next().is(':visible')){
                    span = $(this).find( "span.faq-icon");
                    span.removeClass(options.expandIconClass);
                    span.removeClass(options.collapseIconClass);
                    span.addClass(options.expandIconClass);
                }
                else {
                    span = $(this).find( "span.faq-icon");
                    span.removeClass(options.expandIconClass);
                    span.removeClass(options.collapseIconClass);
                    span.addClass(options.collapseIconClass);
                }
                $(this).next('.answer').slideToggle(options.duration);
                $(this).next().next('.faqnav').slideToggle(options.duration);
            });
            
            // handle click on back to top link
            $(this).find('.faqnav .backToTop').click(function(ev){
                $('html, body').animate({scrollTop:0}, 'fast');
                ev.preventDefault();
                return false;
            });
            
            // handle click on collapse all link
            var faq = $(this);
            $(this).find('.faqnav .collapseAll').click(function(ev){
                faq.find(".answer, .faqnav").hide( "fast" );
                var span = faq.find( "span.faq-icon");
                span.removeClass(options.expandIconClass);
                span.removeClass(options.collapseIconClass);
                span.addClass(options.expandIconClass);
                ev.preventDefault();
                return false;
            });
            
            $(this).find('.faqnav .expandAll').click(function(ev){
                faq.find( ".answer, .faqnav").show( "fast");
                var span = faq.find( "span.faq-icon");
                span.removeClass(options.expandIconClass);
                span.removeClass(options.collapseIconClass);
                span.addClass(options.collapseIconClass);
                ev.preventDefault();
                return false;
            });
            
        });
    }
    
    function addNavigationLink( answer, options ){
        var markup = "<div class='faqnav'>";
        markup += "<a class='backToTop' href='javascript:void(0)'>Back to Top</a>";
        markup += "<span class='separator'>|</span>";
        markup += "<a class='collapseAll' href='javascript:void(0)'>Collapse All</a>";
        markup += "<span class='separator'>|</span>";
        markup += "<a class='expandAll' href='javascript:void(0)'>Expand All</a>";
        $(markup).insertAfter( answer );
    }
    
})(jQuery);

