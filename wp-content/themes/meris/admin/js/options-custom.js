jQuery(document).ready(function($) {

	// Loads the color pickers
	$('.of-color').wpColorPicker();

	// Image Options
	$('.of-radio-img-img').click(function(){
		$(this).parent().parent().find('.of-radio-img-img').removeClass('of-radio-img-selected');
		$(this).addClass('of-radio-img-selected');
	});

	$('.of-radio-img-label').hide();
	$('.of-radio-img-img').show();
	$('.of-radio-img-radio').hide();

	// Loads tabbed sections if they exist
	if ( $('.nav-tab-wrapper').length > 0 ) {
		options_framework_tabs();
	}

	function options_framework_tabs() {

		var $group = $('.group'),
			$navtabs = $('.nav-tab-wrapper a'),
			active_tab = '';

		// Hides all the .group sections to start
		$group.hide();

		// Find if a selected tab is saved in localStorage
		if ( typeof(localStorage) != 'undefined' ) {
			active_tab = localStorage.getItem('active_tab');
		}

		// If active tab is saved and exists, load it's .group
		if ( active_tab != '' && $(active_tab).length ) {
			$(active_tab).fadeIn();
			$(active_tab + '-tab').addClass('nav-tab-active');
		} else {
			$('.group:first').fadeIn();
			$('.nav-tab-wrapper a:first').addClass('nav-tab-active');
		}

		// Bind tabs clicks
		$navtabs.click(function(e) {

			e.preventDefault();

			// Remove active class from all tabs
			$navtabs.removeClass('nav-tab-active');

			$(this).addClass('nav-tab-active').blur();

			if (typeof(localStorage) != 'undefined' ) {
				localStorage.setItem('active_tab', $(this).attr('href') );
			}

			var selected = $(this).attr('href');

			$group.hide();
			$(selected).fadeIn();

		});
	}
	
	////
	
	$("#optionsframework .section-start_group > h4.heading").click(function(){
		if($(this).parent().hasClass("group_close")){$(this).parent().removeClass("group_close").addClass("group_open");}	else										 
		if($(this).parent().hasClass("group_open")){$(this).parent().removeClass("group_open").addClass("group_close");}															
     });
	////
	
	$(".widget-area-column").change(function(){
											 
		var column            = parseInt($(this).val());
		var width             = parseInt(12/column);
		var citem             = "";
		
		var sanitize_areaname = $(this).parents(".list-item ").find(".section-widget-sanitize-areaname").val();
		if(column > 1){
		for(var i=1;i<=column;i++){
			citem = citem + '<label> Column '+i+' width :</label><select id="widget-area-column-item-'+i+'" name="widget-area[widget-area-column-item]['+sanitize_areaname+'][]" class="widget-area-column-item">';
			for(var j=0;j<12;j++){
				var selected            = "";
				if(j == width) selected = ' selected="selected" ';
				citem = citem + '<option '+selected+' value="'+j+'">'+j+'/12 </option>';
				}
				
				citem = citem + '</select>';
			}
		}
		$(this).parents(".list-item ").find(".widget-secton-column").html(citem);
		
		});
 
 ////
 
  $(function() {
	  $( "#list-widget-areas" ).sortable({
	  cursor: "move",
	  items :".list-item", 
	  opacity: 0.6, 
	  revert: true, 
	  handle : ".widget-area-name"
	  });
  });
  ////

  ////
});


jQuery(function() {
        var listItem = jQuery('#list-widget-areas');
        
        jQuery(document).on('click','#addItem' ,function() {
		jQuery("#list-item-notice").html("");											 
		var column   = jQuery(this).parents("#section-widget").find("#widget_layout").val();		
		var areaName = jQuery(this).parents("#section-widget").find("#list-item-val").val();
		var i      = listItem.find('.list-item').size() + 1;	
		if(areaName == "" || areaName == null){
			jQuery("#list-item-notice").html("Widget area name is required.");
			return false;
			}
		var repeated = false;
		jQuery(".section-widget-area-name-item").each(function(){
				if(jQuery(this).val() == areaName)	{
					repeated = true;
					}								   
															   
               });	
		if(repeated == true){
			jQuery("#list-item-notice").html("Widget area name already exists.");
			return false;
			}
		
	 jQuery.ajax({
				 type:"POST",
				 dataType:"html",
				 url:ajaxurl,
				 data:"column="+column+"&areaname="+areaName+"&num="+i+"&action=meris_widget_area_generator",
				 success:function(data){
					
					jQuery(data).appendTo(listItem);
					jQuery('.of-color').wpColorPicker();
					jQuery('[data-toggle="confirmation"]').confirmation({title: "Remove this item?",onConfirm:function(){jQuery(this).parents(".list-item").remove();}});
	
	var optionsframework_upload;
	var optionsframework_selector;

	function optionsframework_add_file(event, selector) {

		var upload = jQuery(".uploaded-file"), frame;
		var $el = jQuery(this);
		optionsframework_selector = selector;

		event.preventDefault();

		// If the media frame already exists, reopen it.
		if ( optionsframework_upload ) {
			optionsframework_upload.open();
		} else {
			// Create the media frame.
			optionsframework_upload = wp.media.frames.optionsframework_upload =  wp.media({
				// Set the title of the modal.
				title: $el.data('choose'),

				// Customize the submit button.
				button: {
					// Set the text of the button.
					text: $el.data('update'),
					// Tell the button not to close the modal, since we're
					// going to refresh the page when the image is selected.
					close: false
				}
			});

			// When an image is selected, run a callback.
			optionsframework_upload.on( 'select', function() {
				// Grab the selected attachment.
				var attachment = optionsframework_upload.state().get('selection').first();
				optionsframework_upload.close();
				optionsframework_selector.find('.upload').val(attachment.attributes.url);
				if ( attachment.attributes.type == 'image' ) {
					optionsframework_selector.find('.screenshot').empty().hide().append('<img src="' + attachment.attributes.url + '"><a class="remove-image">Remove</a>').slideDown('fast');
				}
				optionsframework_selector.find('.upload-button').unbind().addClass('remove-file').removeClass('upload-button').val(optionsframework_l10n.remove);
				optionsframework_selector.find('.of-background-properties').slideDown();
				optionsframework_selector.find('.remove-image, .remove-file').on('click', function() {
					optionsframework_remove_file( jQuery(this).parents('.section:first') );
				});
			});

		}

		// Finally, open the modal.
		optionsframework_upload.open();
	}

	function optionsframework_remove_file(selector) {
		selector.find('.remove-image').hide();
		selector.find('.upload').val('');
		selector.find('.of-background-properties').hide();
		selector.find('.screenshot').slideUp();
		selector.find('.remove-file').unbind().addClass('upload-button').removeClass('remove-file').val(optionsframework_l10n.upload);
		// We don't display the upload button if .upload-notice is present
		// This means the user doesn't have the WordPress 3.5 Media Library Support
		if ( jQuery('.section-upload .upload-notice').length > 0 ) {
			jQuery('.upload-button').remove();
		}
		selector.find('.upload-button').on('click', function(event) {
			optionsframework_add_file(event, jQuery(this).parents('.section:first'));
		});
	}

	jQuery('.remove-image, .remove-file').on('click', function() {
															  
		optionsframework_remove_file( jQuery(this).parents('.section:first') );
    });

    jQuery('.upload-button').on('click', function( event ) {
    	optionsframework_add_file(event, jQuery(this).parents('.section:first'));
    });

		 },error:function(){
					 alert("error");
					 }
				 });
	 
						});

		
 jQuery(document).on('click','.edit-section' ,function() {
       jQuery(this).parents(".list-item").find(".section-widget-area-wrapper").toggle();
   }); 

 jQuery('[data-toggle="confirmation"]').confirmation({title: "Remove this item?",onConfirm:function(){jQuery(this).parents(".list-item").remove();}});

	
});