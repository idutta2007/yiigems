(function ($) {
    $.widget( "yiigems.editableField", {
        // default options
        options: {
            gridId: null,
            columnId: null,
            popupId: null,
            okButtonSelector: null,
            cancelButtonSelector: null,
            updateUrl: null,
            currentTarget: null,
            updateUrl: null,
            emptyText: "Edit"
        },

        _create: function(){
            this._super();
        },

        _init: function(){
            this._super();
            
            var widget = this;
            var opts = widget.options;
            
            var linksSelector = "#" + opts.gridId + " " + "a[data-column-id='" + opts.columnId + "']";
            
            // When clicked on any cell in the column display popup
            $(document).on('click', linksSelector, function(){
                opts.currentTarget = $(this);
                $("#" + opts.popupId).popup("option", "target", $(this));
                $("#" + opts.popupId).popup('displayPopup');
                
                if ($("#" + opts.popupId + " input").length == 1){
                    $("#" + opts.popupId + " input").val($(this).data("link-text"));
                    $("#" + opts.popupId + " input").focus();
                }
                else if($("#" + opts.popupId + " select").length == 1){
                    $("#" + opts.popupId + " select").val($(this).data("link-text"));
                    $("#" + opts.popupId + " select").focus();
                }
                else if($("#" + opts.popupId + " textarea").length == 1){
                    $("#" + opts.popupId + " textarea").val($(this).data("link-text"));
                    $("#" + opts.popupId + " textarea").focus();
                }
            });
            
            // Hide popup when cancel is pressed
            $(opts.cancelButtonSelector).on('click', function(){
                $("#" + opts.popupId).popup('hidePopup');
            });
            
            // when ok is clicked, send ajax request
            $(opts.okButtonSelector).on('click', function(){
                 widget.updateColumn();
                 return false;
            });
            
            // when user presses return update column
            $("#" + opts.popupId).on( 'keypress', function(ev){
                if(ev.keyCode === 13 ){
                    widget.updateColumn();
                    return false;
                }
            });
        },
                
        updateColumn: function(){
            var widget = this;
            var opts = this.options;
            if (!opts.currentTarget) return;
            
            var id = opts.currentTarget.data("model-id");
            var column = opts.currentTarget.data("attribute-name");
            var value = widget.getEditorValue();
            if(value) value = value.trim();
            
            if ( opts.updateUrl ){
                $.ajax({
                    url: opts.updateUrl,
                    type: 'POST',
                    data: {id: id, column: column, value: value},
                    success: function() {
                        widget.updateLinkText(value);
                        $("#" + opts.popupId).popup('hidePopup');
                    },
                    error: function() {
                        alert('update failed. Reload page and try again.')
                    }
                });
            }
        },
                
        getEditorValue: function(){
           var opts = this.options;
           if ( $("#" + opts.popupId + " input").length == 1 ){
               return $("#" + opts.popupId + " input").val();
           }
           else if ( $("#" + opts.popupId + " select").length == 1 ){
               return $("#" + opts.popupId + " select").val();
           }
           else if ( $("#" + opts.popupId + " textarea").length == 1 ){
               return $("#" + opts.popupId + " textarea").val();
           }
           return null;
        },
                
        updateLinkText: function(value){
            var opts = this.options;
            opts.currentTarget.data("link-text", value);
            if (value ){
                opts.currentTarget.text(value); 
            }
            else {
                opts.currentTarget.text(opts.emptyText);
            }
        }
    });
})(jQuery);


