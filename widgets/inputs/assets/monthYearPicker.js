
(function ($) {
    $.widget( "yiigems.monthPicker", {
        // default options
        options: {
            selectedMonth: "",
            selectedYear: "",
        },

        _create: function(){
            this._super();
        },

        _init: function(){
            this._super();
            
            var widget = this;
            var opts = this.options;
            
            var input = this.element.find('input');
            input.on('focusin', function(){
                widget.showPopup();
            });
            input.on('keydown', function(ev){
                var keyCode = ev.keyCode ? ev.keyCode : ev.which;
                if (keyCode === 27 ){
                    widget.hidePopup();
                    return false;
                }
            });
            $(document).on('click', function(ev){
                var popup = $("#" + opts.popupId).get(0);
                if ( !$.contains(popup, ev.target ) && !$.contains(widget.element.get(0), ev.target) ){
                    widget.hidePopup();
                }
            });
            
            var triggerIcon = this.element.find('span.triggerIcon');
            triggerIcon.position({
                my: "left center",
                at: "right center",
                of: input,
                collision: 'none none'
            });
            
            triggerIcon.on('click', function(){
                input.focus();
                return false;
            });
            
            var closeIcon = this.element.find('span.closeIcon');
            closeIcon.css('cursor', 'pointer');
            closeIcon.on('click', function(ev){
                widget.hidePopup();
            });
            
            var months = this.element.find('.month');
            months.on( 'click', function(){
                opts.selectedMonth = $(this).data("month");
                opts.selectedMonthNumber = $(this).data("month-number");
                if (opts.monthFieldSelctor) $(opts.monthFieldSelctor).val(opts.selectedMonth);
                if (opts.monthNumberFieldSelctor) $(opts.monthNumberFieldSelctor).val(opts.selectedMonthNumber);
                
                var value = widget.getDisplayedValue();
                input.val(value);
                if (!opts.allowYearSelection ){
                    widget.hidePopup();
                }
            });
            
            var years = this.element.find('.year');
            years.on( 'click', function(){
                opts.selectedYear = $(this).data("year");
                if (opts.yearFieldSelctor) $(opts.yearFieldSelctor).val(opts.selectedYear);
                
                var value = widget.getDisplayedValue();
                input.val(value);
                
                widget.hidePopup();
            });
        },
                
        getDisplayedValue: function(month, year, format){
            var opts = this.options;
            var month = opts.selectedMonth;
            var monthNumber = opts.selectedMonthNumber;
            var year = opts.selectedYear;
            
            if ( opts.allowMonthSelection && !opts.allowYearSelection){
                if ( opts.format.indexOf("{month-number}") > 0 ){
                    return monthNumber;
                }
                return month;
            }
            else if ( !opts.allowMonthSelection && opts.allowYearSelection){
                return year;
            }
            var result = opts.format.replace( "{month}", month );
            result = result.replace( "{month-number}", monthNumber );
            return result.replace( "{year}", year );
        },
           
        showPopup: function() {
            var popup = $("#" + this.options.popupId);
            var input = this.element.find("input");
            popup.hide().fadeIn();
            popup.position({
                my: "left top+2",
                at: "left bottom",
                of: input,
                collision: 'flip flip'
            });
        },
                
        hidePopup: function() {
            var popup = $("#" + this.options.popupId);
            popup.hide();
        }
    });

})(jQuery);