(function ($) {
    $.widget( "ui.dialog", $.ui.dialog, {
        _createWrapper: function() {
            this._super();
            this.uiDialog.css( "padding", 0 );
            this.uiDialog.css( "border-color", this.options.borderColor );
            this.uiDialog.css( "border-width", "2px" );
            this.uiDialog.addClass( this.options.dialogAddClass );
            this.uiDialog.removeClass( "ui-corner-all" );
        },

        _createTitlebar: function() {
            var uiDialogTitle;
            this.uiDialogTitlebar = $(this.options.titleMarkup)
                .css( "cursor", "move")
                .prependTo( this.uiDialog );

            this._on( this.uiDialogTitlebar, {
                mousedown: function( event ) {
                    // Don't prevent click on close button (#8838)
                    // Focusing a dialog that is partially scrolled out of view
                    // causes the browser to scroll it into view, preventing the click event
                    if ( !$( event.target ).closest(".dialog-close-button") ) {
                        // Dialog isn't getting focus when dragging (#8063)
                        this.uiDialog.focus();
                    }
                }
            });

            this.uiDialogTitlebarClose = this.uiDialogTitlebar.find( ".dialog-close-button");
            this.uiDialogTitlebarClose.css( "cursor", "pointer");
            this._on( this.uiDialogTitlebarClose, {
                click: function( event ) {
                    event.preventDefault();
                    this.close( event );
                }
            });
        },

        _makeDraggable: function() {
            var that = this,
                options = this.options;

            function filteredUi( ui ) {
                return {
                    position: ui.position,
                    offset: ui.offset
                };
            }

            this.uiDialog.draggable({
                cancel: ".ui-dialog-content, .dialog-close-btn",
                handle: ".titleBar",
                containment: "document",
                start: function( event, ui ) {
                    $( this ).addClass("ui-dialog-dragging");
                    that._blockFrames();
                    that._trigger( "dragStart", event, filteredUi( ui ) );
                },
                drag: function( event, ui ) {
                    that._trigger( "drag", event, filteredUi( ui ) );
                },
                stop: function( event, ui ) {
                    options.position = [
                        ui.position.left - that.document.scrollLeft(),
                        ui.position.top - that.document.scrollTop()
                    ];
                    $( this ).removeClass("ui-dialog-dragging");
                    that._unblockFrames();
                    that._trigger( "dragStop", event, filteredUi( ui ) );
                }
            });
        }
    });
})(jQuery);

