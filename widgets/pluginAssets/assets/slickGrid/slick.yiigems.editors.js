/***
 * Contains basic SlickGrid editors.
 * @module Editors
 * @namespace Slick
 */

(function($) {
    // register namespace
    $.extend(true, window, {
        "Slick": {
            "Editors": {
                "Number": NumberEditor,
                "Time": TimeEditor,
                "DropDown": DropDownEditor,
            }
        }
    });

    function NumberEditor(args) {
        var $input;
        var defaultValue;
        var scope = this;

        this.init = function() {
            $input = $("<input type=text class='editor-text' />");

            $input.bind("keydown", function(e) {
                if (e.keyCode === $.ui.keyCode.LEFT || e.keyCode === $.ui.keyCode.RIGHT) {
                    e.stopImmediatePropagation();
                }
            });

            $input.appendTo(args.container);
        };

        this.destroy = function() {
            $input.remove();
        };

        this.focus = function() {
            $input.focus();
        };

        this.loadValue = function(item) {
            defaultValue = item[args.column.field];
            $input.val(defaultValue);
            $input[0].defaultValue = defaultValue;
            $input.focus();
        };

        this.serializeValue = function() {
            return parseFloat($input.val()) || 0.0;
        };

        this.applyValue = function(item, state) {
            item[args.column.field] = state;
        };

        this.isValueChanged = function() {
            return (!($input.val() == "" && defaultValue == null)) && ($input.val() != defaultValue);
        };

        this.validate = function() {
            if (isNaN($input.val())) {
                return {
                    valid: false,
                    msg: "Please enter a valid number"
                };
            }
            return {
                valid: true,
                msg: null
            };
        };
        this.init();
    }

    function TimeEditor(args) {
        var $input;
        var defaultValue;
        var dialogOpen = false;

        this.init = function() {
            $input = $("<input/>", {
                type: 'text',
                class: 'editor-text'
            });
            $input.appendTo(args.container);
            $input.timepicker({
                showPeriod: true,
                beforeShow: function() {
                    dialogOpen = true;
                },
                onClose: function() {
                    dialogOpen = false;
                }
            });
            $input.focus();
            $input.timepicker("show");
        };

        this.destroy = function() {
            $input.timepicker("hide");
            $input.timepicker("destroy");
            $input.remove();
        };
        
        this.focus = function() {
            $input.focus();
        };
        
        this.loadValue = function(item) {
            defaultValue = item[args.column.field];
            $input.val(defaultValue);
        };

        this.serializeValue = function() {
            return $input.val();
        };

        this.applyValue = function(item, state) {
            item[args.column.field] = state;
        };

        this.isValueChanged = function() {
            return (!($input.val() == "" && defaultValue == null)) && ($input.val() != defaultValue);
        };

        this.validate = function() {
            return {
                valid: true,
                msg: null
            };
        };
        this.init();
    }
    
    function DropDownEditor(args) {
        var $select;
        var defaultValue;

        this.init = function() {
            $select = $("<select></select>", {
                class: 'editor-dropdown'
            });
            if ( args.column.dropDownItems ){
                for( var i =0; i < args.column.dropDownItems.length; i++ ){
                    $("<option>", {
                        value: args.column.dropDownItems[i],
                    }).html(args.column.dropDownItems[i]).appendTo($select);
                }
            }
            $select.appendTo(args.container);
            $select.focus();
        };

        this.destroy = function() {
            $select.remove();
        };

        this.focus = function() {
            $select.focus();
        };

        this.loadValue = function(item) {
            defaultValue = item[args.column.field];
            $select.val(item[args.column.field]);
            $select.select();
        };

        this.serializeValue = function() {
            return $select.val();
        };

        this.applyValue = function(item, state) {
            item[args.column.field] = state;
        };

        this.isValueChanged = function() {
            return ($select.val() != defaultValue);
        };

        this.validate = function() {
            return {
                valid: true,
                msg: null
            };
        };
        this.init();
    }
})(jQuery);
