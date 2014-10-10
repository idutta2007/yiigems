
(function ($) {
    $.widget( "yiigems.numberField", {
        // default options
        options: {
            inputType: "decimal" // integer, decimal, float, double
        },

        _create: function(){
            this._super();
        },

        _init: function(){
            this._super();
            if ( this.options.inputType == "integer" ){
                this._initIntegerField();
            }
            else if ( this.options.inputType == "decimal" || this.options.inputType == "float" ||
                      this.options.inputType == "double" || this.options.inputType == "number" ){
                this._initDecimalField();
            }
        },
                
        _initIntegerField: function(){
            var opts = this.options;

            this.element.on( "keydown", function(evt){
                var e = evt || window.event;
                var key = e.keyCode || e.which;
                if ( !e.shiftKey && !e.altKey && !e.ctrlKey ){

                    // Numbers
                    if( key >= 48 && key <= 57 ) return;

                    // Numeric keypads
                    if( key >= 96 && key <= 105 ) return;

                    // Backspace, tab and enter
                    if( key == 8 || key == 9 || key == 13 ) return;

                    // Left right arrow keys
                    if( key == 37 || key == 39 ) return;

                    // Ins and Del
                    if( key == 45 || key == 46 ) return;

                    // Ins and Del
                    if( key == 45 || key == 46 ) return;
                }
                e.returnValue = false;
                if(e.preventDefault) e.preventDefault();
            });
        },

        _initDecimalField: function(){
            var element = this.element;
            var opts = this.options;

            element.on( "keydown", function(evt){
                var e = evt || window.event;
                var key = e.keyCode || e.which;
                if ( !e.shiftKey && !e.altKey && !e.ctrlKey ){
                    // Numbers
                    if( key >= 48 && key <= 57 ) return;

                    // Numeric keypads
                    if( key >= 96 && key <= 105 ) return;

                    // Backspace, tab and enter
                    if( key == 8 || key == 9 || key == 13 ) return;

                    // Left right arrow keys
                    if( key == 37 || key == 39 ) return;

                    // Ins and Del
                    if( key == 45 || key == 46 ) return;

                    // Ins and Del
                    if( key == 45 || key == 46 ) return;

                    // Period and minus sign
                    if ( key == 190 || key == 189 || key == 110 ) return;
                }
                e.returnValue = false;
                if(e.preventDefault) e.preventDefault();
            });
        }
    });

})(jQuery);