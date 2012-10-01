(function($){
    // Color picker, see farbtastic.js
    var farbtastic = {};

    // Color picker currently active
    var active_color_picker;
    
    // To keep track of the current element
    var current_el_parent_id;

    // All input elements using color picker, see theme-options.php
    var all_input_elements_id = ['#primary_color', '#entry_title_color'];
    
    // Set input value and color sample. Also a callback function to farbtastic.
	var pickColor = function(a) {
        var current_input_id = current_el_parent_id.replace('_div', '');

        farbtastic[current_input_id].setColor(a);
        $(current_input_id).val(a);
        $(current_el_parent_id + ' .color-sample').css('background-color', a);
	};

    var toggleEntryTitleDiv = function() {
        var checked = $('#entry_title_color_checkbox').prop('checked');
            
        $('#entry_title_color_div').toggle( checked );
    }

	$(document).ready( function() {
        // Hide Entry Title Div if the checkbox is unchecked.
        toggleEntryTitleDiv();

        // Create a link on default-color
		$('.default-color').wrapInner('<a href="#" />');

        // Loop through all color input to...
        $.each(all_input_elements_id, function(index, id) {
            current_el_parent_id = id + '_div';
            
            // ...initialize a color picker
            farbtastic[id] = $.farbtastic(current_el_parent_id + ' .color-picker', pickColor);
            
            // ...set color sample
            pickColor( $(id).val() );

            // ...bind focus event to determine current text input
            $(id).focus( function() {
                current_el_parent_id = '#' + this.id + '_div';
            });

            // ...bind keyup event
            $(id).keyup( function() {
                var id = '#' + this.id;
                var a = $(id).val(),
                    b = a;

                a = a.replace(/[^a-fA-F0-9]/g, '');
                if ( '#' + a !== b )
                    $(id).val(a);
                if ( a.length === 3 || a.length === 6 )
                    pickColor( '#' + a );
            });
        });

        // Determine which element is in use, and show color picker
        $('.pickcolor').click( function(e) {
            current_el_parent_id = '#' + this.parentNode.id;
            active_color_picker = $(current_el_parent_id + ' .color-picker');
			active_color_picker.show();
			e.preventDefault();
		});

        // Hide color picker
		$(document).mousedown( function() {
            if (active_color_picker) {
                active_color_picker.hide();
                active_color_picker = undefined;
            }
		});

        // Reset text input and color sample to default
		$('.default-color a').click( function(e) {
            current_el_parent_id = '#' + this.parentNode.parentNode.parentNode.id;
			pickColor( this.innerHTML );
			e.preventDefault();
		});
        
        // Toggle Entry Title Div when checkbox is clicked.
        $('#entry_title_color_checkbox').click(toggleEntryTitleDiv);

	});
})(jQuery);