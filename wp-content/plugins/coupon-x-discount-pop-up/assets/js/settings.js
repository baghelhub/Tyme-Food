const { __, _x, _n, _nx } = wp.i18n;
jQuery(document).ready(function($) {
	let current_dialog = '';

	let slideIndex = 0;

	//Show WC missing pop up on plugin activation
	if( $('.webcomepopup').length > 0 ) {
		$('.webcomepopup').show();
	}
	else if($('.empty-widget').length > 0 ) {
		$('.empty-widget').show();
	}
	//Add flag once the first widget pop up is displayed
	$('.welcompopupbtn').click(function() {
		href = $(this).attr('href');
		url = cx_data.site_url+'/wp-json/couponx/v1/update_popup_status';
		$.post( {
    		url   :url,
    		headers: { 'X-WP-Nonce': $('input[name="cx_nonce"]').val() },
	    	function( response ) {
	    		console.log( response );
	    	}
	    });
		location.href = href;
	})
	keep_editing = 0;

	//Initialize datepickers
	if($('.active_start_date').length > 0 ) {
		$('.active_start_date').datepicker({
		    dateFormat: 'yy-mm-dd',
		    minDate: 0,
		    onSelect: function(dateText) {
		        sd = new Date(dateText);
		        $(".active_end_date").datepicker('option', 'minDate', sd);
		    }
		});
		$('.active_end_date').datepicker({
		    dateFormat: 'yy-mm-dd',
		    minDate: 0
		});

		//Initialize select2
		$('.cart_collections').select2();
		$('.cart_products').select2();

		$('.fonts-input').select2();
		$('.select2-selection__rendered').removeAttr('title')
		
		$(".tab-shape").select2({
		    minimumResultsForSearch: Infinity
		});

		$(".animation-effect").select2({
		    minimumResultsForSearch: Infinity
		});
			
		$(".country-dropdown, .mobile-dropdown, .desktop-dropdown, .mobile-browser-dropdown, .desktop-browser-dropdown").select2({
		    minimumResultsForSearch: Infinity	
		});
		$('#timer_date').datepicker({
		    dateFormat: 'yy-mm-dd',
		    minDate: 0
		    
		});
		
		$('.day-rule-enable').select2({
			minimumResultsForSearch: -1			
		});
		$('.day-timezone').select2({
			minimumResultsForSearch: -1			
		});
		$('.display_start_date').datepicker({
		    dateFormat: 'yy-mm-dd',
		    minDate: 0,
		    onSelect: function(dateText) {
		        sd = new Date(dateText);
		        $(".display_end_date").datepicker('option', 'minDate', sd);
		    }
		});
		$('.display_end_date').datepicker({
		    dateFormat: 'yy-mm-dd',
		    minDate: 0
		});
		$('#timer_time').timepicker();
		$('.display_start_time').timepicker();
		$('.display_end_time').timepicker();

		
		$('.day-start-time').timepicker();
		$('.day-end-time').timepicker();
		
	}
	$('.dashicons').tooltip({
	        content: function () {
	            return $(this).prop('title');
	        },
	        show: null, 
	        close: function (event, ui) {
	            ui.tooltip.hover(
	            function () {
	                $(this).stop(true).fadeTo(400, 1);
	            },    
	            function () {
	                $(this).fadeOut("400", function () {
	                    $(this).remove();
	                })
	            });
	        }
	    });
	$('.accordion-btn').click(function(e) {
		e.preventDefault();
		if( ! $(".advanced-panel").hasClass('down')) {
			$(".advanced-panel").slideDown("slow")
				.addClass('down');
		}
		else {
			$(".advanced-panel").slideUp("slow")
				.removeClass('down');
		}
		
	})
	//Close first widget popup
	$('.close-chaty-maxvisitor-popup').click(function() {
		$('.first-widget-popup').addClass('hide');
		$('.popup-overlayout-cls').css('display', 'none');
	})


	//Tabs on create widget page
	tabs = $( ".tabs" ).tabs();
	$('.screen-tab').tabs();
	
	validation_popup  = $('.validation-popup').dialog({
	    resizable: false,
		modal: true,
		draggable: false,
		height: 'auto',
		width: 400,
		overflow: 'auto',
		autoOpen : false,
		dialogClass: 'fixPosition'
	});

	layout_validation = $('.layout-validation').dialog({
	    resizable: false,
		modal: true,
		draggable: false,
		height: 'auto',
		width: 400,
		overflow: 'auto',
		autoOpen : false,
		dialogClass: 'fixPosition'
	});
	
	function validate_next_step( href ) {

		error = 0;
		if( href == '#popup_design') {

			if($('.active-type').length == 0) {
				error =1;
				validation_popup.dialog( "open" );
				current_dialog = validation_popup;
				tabs.tabs( "option", "active", 1 );
			}
			else if($('.active-type').hasClass('custom-coupon-code') || 
				$('.active-type').hasClass('select-wp-generate-unique-coupon') ) {
				
				error = validate_coupon_form();
				if( error == 1) {
					tabs.tabs( "option", "active", 1 );
					return;
				}
				if( !$('.discount-code-wrap').hasClass('hide') ) {
					$('input.coupon-type').val(3);
				}
				else {
					$('input.coupon-type').val(2);
				}
				text = 'Unique Code';
				coupont_type = $('input.coupon-type').val();
				if( coupont_type == 3 )
					text = $('.discount-code').val();
				$('.couponapp-code-option .couponapp-inner-text').val(text);
				$('.couponapp-code-option .coupon-code-text').text(text);
				$('.couponapp-inner-text').val(text);
				$('.coupon-popup').removeClass('hide');
				$('.announcement-popup').addClass('hide');
				$('.cp').removeClass('hide')
				$('.an').addClass('hide')
				if( $('.coupon-widget-style').find('.input-field-radio:checked').val() == '' )
					$('#input-field-radio-style-1').trigger('click');
					
				
			}
			else if( $('.active-type').hasClass('select-wp-exisitng-coupon') ) {
				console.log($('.ex-coupon:checked').length)
				if( $('.ex-coupon:checked').length == 0 ) {
					error =1;
					tabs.tabs( "option", "active", 1 );
					$('.ex-error').removeClass('hide');
					$("body, html").animate({
						scrollTop: $(".ex-error").offset().top - 130
					}, 500);
					return;
				}
				else {
					let code = $('.ex-coupon:checked').attr('data-code');
					$('.couponapp-code-option .coupon-code-text').text(code);
					$('.couponapp-inner-text').val(code);
					$('input.coupon-type').val(1);
					$('.ex-error').addClass('hide');
					$('.coupon-popup').removeClass('hide');
					$('.announcement-popup').addClass('hide')
					error = 0;
					$('.cp').removeClass('hide')
					$('.an').addClass('hide')
					if( $('.coupon-widget-style').find('.input-field-radio:checked').val() == '' )
						$('#input-field-radio-style-1').trigger('click')
					
				}
			}

			if(error == 0) {
				console.log(href)
				tabs.tabs( "option", "active", 2 );
				$("body, html").animate({
					scrollTop: 0
				}, 500);
			}
		}
		else if( href == '#triggers_targetting') { 
			if($('.active-type').length == 0) {
				error =1;
				validation_popup.dialog( "open" );
				current_dialog = validation_popup;
				tabs.tabs( "option", "active", 1 );
			}
			else if( $('#popup_type').val() == '' ) {
				error = 1;
				tabs.tabs( "option", "active", 2 );
				layout_validation.dialog("open")
				current_dialog = layout_validation;
				return;
			}
			if(error == 0) {
				console.log(href)
				tabs.tabs( "option", "active", 3 );
				$("body, html").animate({
					scrollTop: 0
				}, 500);
			}
			
		}

	}

	$('.widget-tabs').find('a').click(function( e ) {
		//e.preventDefault()
		href = $(this).attr('href');
		if( href == '#triggers_targetting' || href == '#popup_design')
			validate_next_step( href );
   		
	})
	// //Move to next tab.
	$('.next-step').click(function(e) {
		e.preventDefault();
		href = $(this).attr('tab');
		error = 0;
		if( href == '#triggers_targetting' || href == '#popup_design')
			validate_next_step( href );	
		else {
			$('a[href="'+href+'"]').trigger('click');
			
		}
		
	})


	//Display custom uploaded icon in preview
	$('#tab-custom-icon-upload').change(function(event) {
		$('#tab-custom-icon-option').trigger('click')
		 if(event.target.files.length > 0){
		 	let name = event.target.files[0].name;
		 	var file_extension = name.split('.').pop().toLowerCase();
		 	
		 	let src = URL.createObjectURL(event.target.files[0]);

		 	
		 	if(!/(\svg|\gif|\jpg|\jpeg|\png)$/i.test(name)) {
                alert('Invalid file type');
                //$('.tab-icon[value="tab-icon-1"]').prop('checked', 'checked')
                $('#tab-custom-icon-option').val('')
                return false;
            } 

		    img = "<img src='"+src+"' class='custom-tab-img' />";
		    $('.tab-preview').find('.icon-img').html(img)
		  }
	})

	$( '.fonts-input' ).on( 'change', function(){
			$('.select2-selection__rendered').removeAttr('title')
			var font_val = $(this).val();
			font_arr = font_val.split('-');
			font = font_arr[1].replace(/_/g, ' ');
			font_type = font_arr[0].replace(/_/g, '');
			$( '.couponapp-google-font' ).remove();
			$( 'head' ).append( '<link href="https://fonts.googleapis.com/css?family='+ font +':400,600,700" rel="stylesheet" type="text/css" class="couponapp-google-font">' );
			if ( font_type == 'System stack' ) {
				font = '-apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Helvetica, Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol"';
			}
			
			$( '.tab-preview .preview-box' ).css( 'font-family',font );
			$( '.popup-preview .preview-box' ).css( 'font-family',font );
			$('.coupon-button').css( 'font-family',font+' !important' );
		} );

	// Hide/Show custom position settings
	$('.custom-pos').click(function() {
		let pos = $(this).val();
		if( pos == 'custom' ) {
			$('.custom-position').removeClass('hide');
		}
		else {
			$('.custom-position').addClass('hide');
		}
	});

	// Hide/show pending message div
	$('.pmsg').click(function() {
		
		if( $(this).is(':checked') ) {
			$('.pending-msg').removeClass('hide');
			$('.coupon-pending-message').removeClass('hide');
			$('.coupon-pending-message').text($('.no_msg').val());
		}
		else {
			$('.pending-msg').addClass('hide');
			$('.coupon-pending-message').addClass('hide');
		}
	});

	// Hide/show number of messages
	$('.no_msg').change(function() {
		if( parseInt($(this).val()) < 1 ) {
			$(this).val(1);
		} 
		$('.coupon-pending-message').text($(this).val())
	})

	$('.delay-time').change(function() {
		if( parseInt($(this).val()) < 0 ) {
			$('.delay-time').val(0)
		} 
	})

	$('.scroll-page').change(function() {
		if( parseInt($(this).val()) < 0 ) {
			$('.scroll-page').val(0)
		}
	})

	$('.close-time').change(function() {
		if( parseInt($(this).val()) < 0 ) {
			$('.close-time').val(0)
		} 
	})

	
	//Add flag once the first widget pop up is displayed
	$('.close-popup-button').click(function() {
		$('.webcomepopup').hide();
		url = cx_data.site_url+'/wp-json/couponx/v1/update_popup_status';
		$.post( {
    		url   :url,
    		headers: { 'X-WP-Nonce': $('input[name="cx_nonce"]').val() },
	    	function( response ) {
	    		console.log( response );
	    	}
	    });
	})
	
	function validate_coupon_form() {
		error = 0;
		if( !$('.discount-code-wrap').hasClass('hide') && $('#discount-code').val() == '' ) {
			error = 1;
			$('.discount_code_error').removeClass('hide');
		}
		else {
			$('.discount_code_error').addClass('hide');
		}

		if( $('.discount-value').val() == '' ) {
			error = 1;
			$('.discount_value_error').removeClass('hide');
		}
		else {
			$('.discount_value_error').addClass('hide');
		}

		if( $('.applies_to:checked').val() == 'collections' && 
			$('.cart_collections').next('.select2')
			.find('ul.select2-selection__rendered').find('li').length < 1 ) {
			error = 1;
			$('.applies_to_collections_error').removeClass('hide');
			
		}
		else {
			$('.applies_to_collections_error').addClass('hide');
		}

		if( $('.applies_to:checked').val() == 'products' && 
			$('.cart_products').next('.select2')
			.find('ul.select2-selection__rendered').find('li').length < 1 ) {
			error = 1;
			$('.applies_to_products_error').removeClass('hide');
			
		}
		else {
			$('.applies_to_products_error').addClass('hide');
		}
		
		if( $('.min-req  option:selected').val() == 'subtotal' && 
			$('.discount-min-req').val() == '' ) {
			error = 1;
			$('.min_val_error').removeClass('hide');
		}
		else {
			$('.min_val_error').addClass('hide');
		}
		return error;
	}
	

	//Move to previous tab.
	$('.prev-step').click(function( e ) {
		e.preventDefault();
		href = $(this).attr('tab');
		$('a[href="'+href+'"]').trigger('click');
		$("body, html").animate({
            scrollTop: 0
        }, 500);
	})

	let dash_url = '';
	let trigger_dialog = $( ".validation-trigger" ).dialog({
		resizable: false,
		dialogClass: 'fixPosition',
		modal: true,
		draggable: false,
		height: 'auto',
		width: 400,
		overflow: 'auto',
		autoOpen : false,
		buttons:[
			{
				text: __("Save anyway", 'coupon-x'),
				"class": 'btn btn-red',
				click: function () {
					$('#loader').show();
					save_widget(dash_url);
					$(this).dialog('close');
				}

			},
			{
				text: __("Select trigger", 'coupon-x'),
				"class": 'btn select-trigger',
				click: function () {
					$(this).dialog('close');
					$('a[tab="#triggers_targetting"]').trigger('click')
				}
			}
		]
	});
	//Save widget details
	let save_widget = function( dashboard_url ) {
		let formData = new FormData();
		let result = { };

		//Get form field values and pass it in formdata object.
		$.each($('form#cx_widget').serializeArray(), function() {
			formData.append(this.name, this.value);
			
		});
		$.each($('div.unique-coupon-div :input').serializeArray(), function() {
			
			formData.append(this.name, this.value);
			
		});
		$.each($('div.unique-coupon-div select').serializeArray(), function() {
			formData.append(this.name, this.value);
		});
		if($('.ex-coupon:checked').length > 0) {
			formData.append('cx_settings[ex_coupon][coupon]',$('.ex-coupon:checked').val())
		}
		
		if( ! $("input[name='cx_settings[trigger][display_desktop]'").is(':checked') ) {
			formData.append('cx_settings[trigger][display_desktop]', 0 );
		}
		if( ! $("input[name='cx_settings[trigger][display_mobile]'").is(':checked') ) {
			formData.append('cx_settings[trigger][display_mobile]', 0 );
		}
		if( ! $("input[name='cx_settings[trigger][enable_time_delay]'").is(':checked') ) {
			formData.append('cx_settings[trigger][enable_time_delay]', 0 );
		}
		if( $('.tab-icon:checked').val() == 'custom' ) {
			var file = $('input#tab-custom-icon-upload')[0].files[0];
			formData.append( 'file', file );
		}
		
		url = cx_data.site_url+'/wp-json/couponx/v1/create_widget';
		$.ajax( {
    		url :url,
    		type: 'post',
    		headers: { 'X-WP-Nonce': $('input[name="cx_nonce"]').val() },
    		processData: false,
			contentType: false,
	    	data : formData,
	    	success: function( response ) {
	    		if( response.status == 201 ) {
	    			$('#loader').hide();
	    			$('#wp_error_flash_message').removeClass('hide');
					setTimeout(function(){ $('#wp_error_flash_message').addClass('hide'); }, 6000);
	    		}
	    		else {
	    			$('.widget-id').val(response.widget_id);
		    		$('#loader').hide();
		    		if( $('.first-widget-popup').length > 0 ) {
						$('.first-widget-popup').removeClass('hide')
						$('.popup-overlayout-cls').css('display', 'block');
					}
					else if( dashboard_url != '' ) {
						location.href = dashboard_url;

					}
					else {
						$('#wp_flash_message').removeClass('hide');
						setTimeout(function(){ $('#wp_flash_message').addClass('hide'); }, 6000);
					}
	    		}    		
				
	    	}
	    });
	}

	//Save widget data
	$('.save').click(function( e ) {
		e.preventDefault();
		var result = { };
		dash_url = '';
		trigger = !$('.exit-intent').is(":checked") 
				&& !$('.page-scroll').is(":checked")
				&& !$('.time-delay').is(":checked");
		view = !$('.chk-desktop').is(":checked") 
				&& !$('.chk-mobile').is(":checked");
		error = 0;
		if( $('input.coupon-type').val() == 2 || $('input.coupon-type').val() == 3) {
			error = validate_coupon_form();
		}

		if( $('input.coupon-type').val() == '' ) {
			validation_popup.dialog( "open" );
			current_dialog = validation_popup;
		} 
		else if( $('#popup_type').val() == '' ) {
		
			layout_validation.dialog("open")
			current_dialog = layout_validation;	
			
		} 
		else if( trigger ) {
			$('.trigger-error').text( __( 'Please select a trigger before publishing your widget', 'coupon-x' ) );
			$('.select-trigger').text(__( 'Select trigger', 'coupon-x' ) );
			trigger_dialog.dialog( "open" );
			current_dialog = trigger_dialog;
		}
		else if( view ) {
			$('.trigger-error').text( __( 'Please select mobile/desktop before publishing your widget', 'coupon-x' ) );
			$('.select-trigger').text(__( 'Select device', 'coupon-x' ) );
			trigger_dialog.dialog( "open" );
			current_dialog = trigger_dialog;
		}
		else if( error == 1 ) {
			$('a[tab="#choose_coupon"]').trigger('click');

		}
		else {
			$('#loader').show();
      		save_widget( '' );
		}
	});

	$('.time-delay').click(function() {
		if($(this).is(':checked')) {
			$('.delay-time').removeAttr('disabled')
		}
		else {
			$('.delay-time').attr('disabled', 'disabled')
		}
	})
	$('.page-scroll').click(function() {
		if($(this).is(':checked')) {
			$('.scroll-page').removeAttr('disabled')
		}
		else {
			$('.scroll-page').attr('disabled', 'disabled')
		}
	})

	
	//Save widget data and redirect to widget listing page
	$('.go-to-dashboard').click(function( e ) {
		e.preventDefault();
		url = $(this).attr('href');
		dash_url = url;
		trigger = !$('.exit-intent').is(":checked") 
				&& !$('.page-scroll').is(":checked")
				&& !$('.time-delay').is(":checked");
		view = !$('.chk-desktop').is(":checked") 
				&& !$('.chk-mobile').is(":checked");
		if( $('input.coupon-type').val() == '' ) {
			validation_popup.dialog( "open" );
			current_dialog = validation_popup;
		} 
		else if( trigger ) {
			$('.trigger-error').text( __( 'Please select a trigger before publishing your widget', 'coupon-x' ) );
			$('.select-trigger').text(__( 'Select trigger', 'coupon-x' ) );
			trigger_dialog.dialog( "open" );
			current_dialog = trigger_dialog;
		}
		else if( view ) {
			$('.trigger-error').text( __( 'Please select mobile/desktop before publishing your widget', 'coupon-x' ) );
			$('.select-trigger').text(__( 'Select device', 'coupon-x' ) );
			trigger_dialog.dialog( "open" );
			current_dialog = trigger_dialog;
		}
		else {
			$('#loader').show();
			save_widget( url );	
		}
      	
		
	});

	// Tab design preview js
	$('.tab-shape').change(function() {
		shape = $(this).val();
		new_class = 'couponapp-tab-shape-'+shape;
		
		element = $('.tab-preview').find('.tab-box');
		element.removeClass (function (index, css) {
		   return (css.match (/(^|\s)couponapp-tab-shape-\S+/g) || []).join(' ');
		});
		element.addClass(new_class);
		if(shape == 'hexagon') {
			size = $('.tab-size').val();
			color = $('input[name="cx_settings[tab][tab_color]"]').val();
			
			let span =  '<span class="after hexagon-after" ></span>';
			span += '<span class="before hexagon-before"  ></span>';
			$('.tab-preview').find('.tab-icon').prepend( span );

			$( '.preview-box .tab-icon' ).css('height', size/Math.sqrt(3)  + 'px');
			$( '.hexagon-after' )
				 .css('background-color',color+' !important') 
				.css('height', size/Math.sqrt(3)  + 'px');
			$( '.hexagon-before' )
				 .css('background-color', color+' !important')
				.css('height', size/Math.sqrt(3)  + 'px');

			
		}
		$('.tab-size').trigger('change')
	})


	$('.custom-pos').click(function() {
		pos = $(this).val();

		if(pos == 'custom') {
			pos = $('.custom_position:checked').val();
		}
		
		new_class = 'couponapp-position-'+pos;
		element = $('.tab-preview').find('.tab-box');
		element.removeClass (function (index, css) {
		   return (css.match (/(^|\s)couponapp-position-\S+/g) || []).join(' ');
		});
		element.addClass(new_class)

		$('.tab-box').removeClass (function (index, css) {
		   return (css.match (/(^|\s)couponapp-position-\S+/g) || []).join(' ');
		});
		$('.tab-box').addClass(new_class)
		$('.custom-icon-bg').remove();
		clr = $('#action_bgcolor').val();
		console.log(clr)
		if(pos == 'left') {
			$('body').append('<style class="custom-icon-bg">.tab-text:after {border-right-color:'+clr+' !important;border-left-color:transparent !important}</style>' );
		}
		else if(pos== 'right') {
			$('body').append('<style class="custom-icon-bg">.tab-text:after {border-left-color:'+clr+' !important;border-right-color:transparent !important}</style>' );
		}
	})

	$('input[name="cx_settings[main][consent_text]"').keyup(function() {
		text = $(this).val();
		$('.email-content-checkbox').find('span').text(text)
	})

	$('.custom_position').click(function() {
		pos = $(this).val();

		
		new_class = 'couponapp-position-'+pos;
		element = $('.tab-preview').find('.tab-box');
		element.removeClass (function (index, css) {
		   return (css.match (/(^|\s)couponapp-position-\S+/g) || []).join(' ');
		});
		element.addClass(new_class)

		$('.tab-box').removeClass (function (index, css) {
		   return (css.match (/(^|\s)couponapp-position-\S+/g) || []).join(' ');
		});
		$('.tab-box').addClass(new_class)
		$('.custom-icon-bg').remove();
		clr = $('#action_bgcolor').val();
		console.log(clr)
		if(pos == 'left') {
			$('body').append('<style class="custom-icon-bg">.tab-text:after {border-right-color:'+clr+' !important;border-left-color:transparent !important}</style>' );
		}
		else if(pos== 'right') {
			$('body').append('<style class="custom-icon-bg">.tab-text:after {border-left-color:'+clr+' !important;border-right-color:transparent !important}</style>' );
		}
	})

	$('.tab-icon').change(function() {
		icon = $(this).val();
		icon_color = $('input[name="cx_settings[tab][icon_color]"]').val();
		svg = $('span#'+icon).html();
		$('.tab-preview').find('.icon-img').html(svg);
		$('.tab-preview').find('.tab-icon').find('svg').css('fill', icon_color);
		
	})

	$('.tab-size').change(function() {
		size = $(this).val();
		var icon_size = ( $( this ).val() * 64) /100 ;
		
		$( '.preview-box .tab-icon' )
			.css('width', size + 'px')
			.css('height', size + 'px');
		$( '.preview-box .tab-icon svg' )
			.css('width', icon_size + 'px')
			.css('height', icon_size + 'px')
			.css('top', 'calc(50% - '+ (icon_size/2) +'px)')
			.css('left', 'calc(50% - '+ (icon_size/2) +'px)');

		var $tab_shape = $(".tab-shape").val();
		if ($tab_shape == 'hexagon' ) {
			ht = $( this ).val()/Math.sqrt(3)  + 'px'
			$('.preview-box .tab-icon' )
			.css('width', size + 'px')
			.css('height', size/Math.sqrt(3)  + 'px');
			$( '.hexagon-after' )
			.css('width', size  + 'px')
			.css('height', size/Math.sqrt(3)  + 'px');
			$( '.hexagon-before' )
			.css('width', size  + 'px')
			.css('height', size/Math.sqrt(3)  + 'px');
		}
		
	})

	animation_effect = $('.animation-effect').find('option:selected').val();
	$('.animation-effect').change(function() {
		effect = $(this).val();
		
		old_class = 'couponapp-'+animation_effect+'-animation';
		animation_effect = effect;
		new_class = 'couponapp-'+effect+'-animation';
		
		element = $('.tab-preview').find('.tab-box');
		element.removeClass(old_class);
		element.addClass(new_class)
	});

	$('textarea.custom-css').change(function() {
		$('.coupon-custom-css').remove();
		$('body').append('<style class="coupon-custom-css">'+$(this).val()+'</style');
	})
	$('.call-action').keyup(function() {
		let action_text = $(this).val();
		$('.tab-preview').find('.tab-text').text( action_text );
	})
	
	//Pop up changes
	setup_tabs();
	function setup_tabs() {
		
		if( $('.coupon-widget-style').find('.input-field-radio:checked').val() == 'style-1' ||
		$('.coupon-widget-style').find('.input-field-radio:checked').val() == 'style-3') {
			
			$('.screen-tabs').addClass('hide');
			$('#main_screen').addClass('hide');
			$('#coupon_screen').removeClass('hide');
			$('#announcement_screen').addClass('hide');
			$('.coupon-tabs').find('.coupon-screen').trigger('click');
			$('.cp-clr').removeClass('hide');
			$('#coupon_headline_clr').next('.sp-replacer').removeClass('hide');
			$('#coupon_desc_color').next('.sp-replacer').removeClass('hide');
			if( ! $('.main-headline').hasClass('changed') ) {				
				if( $('.coupon-widget-style').find('.input-field-radio:checked').val() == 'style-3')  {
					$('.coupon-headline').val('Get 10% off now');
					$('.couponapp-link-option h4').text('Get 10% off now');					
				}
				else {
					$('.coupon-headline').val('Thanks! Copy your coupon code');
					$('.couponapp-code-option h4').text('Thanks! Copy your coupon code');
				}
			}
		}  
		else if( $('.coupon-widget-style').find('.input-field-radio:checked').val() == 'style-2') {
			$('#main_screen').removeClass('hide');
			$('#coupon_screen').removeClass('hide');
			$('#announcement_screen').addClass('hide');
			$('.announcement-screen').addClass('hide');
			$('.screen-tabs').find('.main-screen').trigger('click');
			$('.screen-tabs').removeClass('hide');
			$('.coupon-screen').removeClass('hide');

			if($('.widget-id').val() == '') {
				if( ! $('.main-headline').hasClass('changed') ) {
					$('.main-headline').val('Get 10% off now');
					$('.couponapp-email-option h4').text('Get 10% off now');
				}
				if( ! $('.main-desc').hasClass('changed') ) {
					$('.main-desc').val('Minimum order of $25');
					$('.couponapp-email-option .coupon-description').text('Minimum order of $25');
				}
			}
			if($('.cpn-cpy-style').is(':checked')) {
				$('.cp-clr').addClass('hide');
				$('#coupon_headline_clr').next('.sp-replacer').addClass('hide');
				$('#coupon_desc_color').next('.sp-replacer').addClass('hide');
			}
			else {
				$('.cp-clr').removeClass('hide');
				$('#coupon_headline_clr').next('.sp-replacer').removeClass('hide');
				$('#coupon_desc_color').next('.sp-replacer').removeClass('hide');
			}
		}  
		else if( $('.coupon-widget-style').find('.input-field-radio:checked').val() == 'style-4') {
			
			$('.screen-tabs').addClass('hide');
			$('#main_screen').addClass('hide');
			$('#coupon_screen').addClass('hide');
			$('#announcement_screen').removeClass('hide');
			$('.coupon-tabs').find('.announcement-screen').trigger('click');
			$('.an-cpy-style').addClass('hide');
			if($('.widget-id').val() == '') {

				if( ! $('.announcement-headline').hasClass('changed') ) {
					$('.announcement-headline').val('Check out our latest collection');
					$('.couponapp-no-coupon-option h4').text('Check out our latest collection')
				}
				if( ! $('.announcement-desc').hasClass('changed') ) {
					$('.couponapp-no-coupon-option .coupon-description').text('New fall collection is now on sale')
					$('.announcement-desc').val('New fall collection is now on sale');
				}
			}
			$('.an-clr').removeClass('hide');
			if($('.enable-btn').is(':checked')) {
				$('.btn-clr').removeClass('hide');
			}
			$('#announcement_headline_clr').next('.sp-replacer').removeClass('hide');
			$('#announcement_desc_color').next('.sp-replacer').removeClass('hide')
		}  
		else if( $('.coupon-widget-style').find('.input-field-radio:checked').val() == 'style-5') {
			$('#main_screen').removeClass('hide');
			$('#coupon_screen').addClass('hide');
			$('.coupon-screen').addClass('hide');
			$('#announcement_screen').removeClass('hide');
			$('.announcement-screen').removeClass('hide');
			$('.screen-tabs').find('.main-screen').trigger('click');
			$('.screen-tabs').removeClass('hide');
			$('.an-cpy-style').removeClass('hide')

			if($('.widget-id').val() == '') {
				if( ! $('.main-headline').hasClass('changed') ) {
					$('.main-headline').val('Enter email to get regular updates');
					$('.couponapp-email-option h4').text('Enter email to get regular updates');
				}
				if( ! $('.main-desc').hasClass('changed') ) {
					$('.main-desc').val('Keep in touch with latest discounts and promos');
					$('.couponapp-email-option .coupon-description').text('Keep in touch with latest discounts and promos');
				}
				if( ! $('.announcement-headline').hasClass('changed') ) {
					$('.announcement-headline').val('Thank you! You\'re awesome!');
					$('.couponapp-no-coupon-option h4').text('Thank you! You\'re awesome!')
				}
				if( ! $('.announcement-desc').hasClass('changed') ) {
					
					$('.couponapp-no-coupon-option .coupon-description').text('Thanks for filling up')
					$('.announcement-desc').val('Thanks for filling up');
				}
			}
			if($('.cpy-style').is(':checked')) {
				$('.an-clr').addClass('hide');
				$('#announcement_headline_clr').next('.sp-replacer').addClass('hide')
				$('#announcement_desc_color').next('.sp-replacer').addClass('hide')
				
			}
			else {
				$('.an-clr').removeClass('hide')
				$('#announcement_headline_clr').next('.sp-replacer').removeClass('hide');
				$('#announcement_desc_color').next('.sp-replacer').removeClass('hide')
			}
		} 
	}

	$('.coupon-widget-style .input-field-radio').click(function() {
		
		setup_tabs();
		let style = $('.coupon-widget-style').find('.input-field-radio:checked').val();
		if(style == 'style-3') {
			$('.style-3').removeClass('hide');			
		}
		else {
			$('.style-3').addClass('hide');
		}

		if(style == 'style-2') {			
			$('.cpn-cpy').removeClass('hide');
		}
		else {			
			$('.cpn-cpy').addClass('hide');
		}

		$('.ctype').removeClass('checked');
		if( style == 'style-1') {
			$(this).closest('.ctype').addClass('checked');
			$('.couponapp-email-code-option').removeClass('hide');
			$('.couponapp-email-option').addClass('hide');
			$('.couponapp-no-coupon-option').addClass('hide');
			$('.couponapp-email-code-option').find('.form-wrap').removeClass('email-popup');			
			$('.tab-box-content').find('.coupon-button').text('Copy');
			$('.cpy-btn').val('Copy');
			$('.couponapp-link-option').addClass('hide');
			$('.couponapp-code-option').removeClass('hide')
			$('.custom-link').addClass('hide');
		}
		else if(style == 'style-2') {
			$(this).closest('.ctype').addClass('checked');
			$('.couponapp-email-code-option').addClass('hide');
			$('.couponapp-link-option').addClass('hide');
			$('.couponapp-email-option').removeClass('hide');
			$('.couponapp-no-coupon-option').addClass('hide');
			$('.cpy-btn').val('Copy');
			$('.couponapp-email-option').find('.coupon-button').text('Send');
			$('.couponapp-code-option').find('.coupon-button').text('Copy');
		}
		else if(style == 'style-3'){
			$(this).closest('.ctype').addClass('checked');
			$('.couponapp-email-code-option').removeClass('hide');
			$('.couponapp-email-option').addClass('hide');
			$('.couponapp-no-coupon-option').addClass('hide');
			$('.tab-box-content').find('.coupon-button').text('Apply Coupon');
			$('.cpy-btn').val('Apply Coupon');
			$('.couponapp-link-option').removeClass('hide');
			$('.couponapp-code-option').addClass('hide');
			$('.custom-link').addClass('hide');
		}
		else if(style == 'style-4'){
			$(this).closest('.ctype').addClass('checked');
			$('.couponapp-email-code-option').addClass('hide');
			$('.couponapp-link-option').addClass('hide');
			$('.couponapp-email-option').addClass('hide');
			$('.couponapp-no-coupon-option').removeClass('hide');
		}
		else if(style == 'style-5'){
			$(this).closest('.ctype').addClass('checked');
			$('.couponapp-email-code-option').addClass('hide');
			$('.couponapp-link-option').addClass('hide');
			$('.couponapp-email-option').removeClass('hide');
			$('.couponapp-no-coupon-option').addClass('hide');
		}
	});

	$('.main-screen').click(function() {
		$('.couponapp-email-option').removeClass('hide');
		$('.couponapp-no-coupon-option').addClass('hide');
		$('.couponapp-code-option').addClass('hide');
	})

	$('.coupon-screen').click(function() {
		$('.couponapp-email-option').addClass('hide');
		$('.couponapp-code-option').removeClass('hide');
		$('.couponapp-no-coupon-option').addClass('hide');
		$('.cpn-cpy').removeClass('hide');
	})

	$('.announcement-screen').click(function() {
		$('.couponapp-email-option').addClass('hide');
		$('.couponapp-code-option').addClass('hide');
		$('.couponapp-no-coupon-option').removeClass('hide');
		if($('.cpy-style').is(":checked")) {
			$('#announcement_headline_clr').next('.sp-replacer').addClass('hide');
			$('#announcement_desc_color').next('.sp-replacer').addClass('hide')
		}
		else {
			$('#announcement_headline_clr').next('.sp-replacer').removeClass('hide');
			$('#announcement_desc_color').next('.sp-replacer').removeClass('hide')
		}
	});

	$('.coupon-tab[href="#popup_design"]').click(function(e) {
		e.preventDefault();
		if( $('input.coupon-type').val() == '' ) {
			validation_popup.dialog( "open" );
			current_dialog = validation_popup;
		} 
	})

	$('.link-type').change(function(){
		if($(this).val() == '2') {
			$('.custom-link').removeClass('hide');
		}
		else {
			$('.custom-link').addClass('hide');
		}
	})

	$('.consent').click(function() {
		if( $(this).is(':checked') ) {
			$('.consent-text').removeClass( 'hide' );
			$('#email-content-checkbox').removeClass( 'hide' );
		}
		else {
			$('.consent-text').addClass( 'hide' );
			$('#email-content-checkbox').addClass( 'hide' );
		}
	})

	$('.auto-close').click(function() {
		
		if( $(this).is(':checked') ) {
			$('.auto-close-text').removeClass( 'hide' );
		}
		else {
			$('.auto-close-text').addClass( 'hide' );
		}
	});


	$('#coupon_screen .coupon-headline').keyup(function() {
		$('.couponapp-code-option h4').text($(this).val());
		$('.couponapp-link-option h4').text($(this).val());
	})

	$('#coupon_screen .cpy-btn').keyup(function() {
		
		$('.couponapp-code-option .coupon-button').text($(this).val());
		$('.couponapp-link-option .coupon-button').text($(this).val());
	})

	$('#coupon_screen .coupon-desc').keyup(function() {
		$('.couponapp-code-option .coupon-description').text($(this).val())
		$('.couponapp-link-option .coupon-description').text($(this).val())
	})

	$('.main-headline').keyup(function() {
		$('.couponapp-email-option h4').text($(this).val());
		$(this).addClass('changed')
		
	})
	$('.main-email').keyup(function() {
		$('.couponapp-email-option .coupon-code-text').text($(this).val());
		
	})
	$('.main-btn-text').keyup(function() {
		$('.couponapp-email-option .coupon-button').text($(this).val());
		
	})
	$('.main-desc').keyup(function() {
		$('.couponapp-email-option .coupon-description').text($(this).val());
		$(this).addClass('changed')
		
	})
	$('.announcement-headline').keyup(function() {
		$('.couponapp-no-coupon-option h4').text($(this).val());
		$(this).addClass('changed')
	})
	$('.announcement-desc').keyup(function() {
		$('.couponapp-no-coupon-option p').text($(this).val());
		$(this).addClass('changed')
	})
	$('.announcement-btn').keyup(function() {
		
		$('.announcement-button').text($(this).val());
	})
	//Coupon generation
	

    $('.select-wp-exisitng-coupon').click( function(e) {
    	e.preventDefault();
		if($(this).hasClass('disable')) {
			location.href = $(this).find('a').attr('href')
			return;
		}
		$('.cp').removeClass('hide');
		$('.an').addClass('hide');
		
    	//$('#discount-code').val('');
    	$('.existing-coupon').removeClass('hide');
		$('.unique-coupon').addClass('hide');
		$('.coupon-type').removeClass('active-type');
    	$(this).addClass('active-type');
		$('input.coupon-type').val(1);
		style = $('.coupon-widget-style').find('.input-field-radio:checked').val() ;
		if( style == '' || style == 'style-4' || style == 'style-5' )
			$('#input-field-radio-style-1').trigger('click');
		
		$('html, body').animate({
			scrollTop: $("#couponapp-wp-coupon-codes").offset().top - 130
		}, 2000);
    	
    })

    $('.custom-coupon-code').click( function( e ) {
    	e.preventDefault();
		if($(this).hasClass('disable')) {
			location.href = $(this).find('a').attr('href')
			return;
		}
		$('.cp').removeClass('hide');
		$('.an').addClass('hide');
		
    	$('.existing-coupon').addClass('hide');
		$('.coupon-type').removeClass('active-type')
		$(this).addClass('active-type')
		$('.unique-coupon').removeClass('hide');
    	$('.discount-code-wrap').removeClass('hide');
    	$('.unique-coupon-description').addClass('hide');
		$('input.coupon-type').val(3);
		style = $('.coupon-widget-style').find('.input-field-radio:checked').val() ;
		if( style == '' || style == 'style-4' || style == 'style-5' )
			$('#input-field-radio-style-1').trigger('click');
		$('html, body').animate({
			scrollTop: $("#couponapp-wp-unique-coupon-code").offset().top - 130
		}, 2000);
    });

	$('.discount-code').change(function() {
		code =$(this).val();
		$('.couponapp-code-option .couponapp-inner-text').val(code);
		$('.couponapp-code-option .coupon-code-text').text(code);
		$('.couponapp-inner-text').val(code);
	})

	$('.ex-coupon').click(function(){
		code =$(this).data('code');
		$('.couponapp-code-option .couponapp-inner-text').val(code);
		$('.couponapp-code-option .coupon-code-text').text(code);
		$('.couponapp-inner-text').val(code);
	})
    $('.select-wp-generate-unique-coupon').click( function(e) {
    	e.preventDefault();
		if($(this).hasClass('disable')) {
			location.href = $(this).find('a').attr('href')
			return;
		}
		$('.cp').removeClass('hide');
		$('.an').addClass('hide');
		$('.discount-code-wrap').addClass('hide');
    	$('.unique-coupon-description').removeClass('hide');
    	$('.existing-coupon').addClass('hide');
		$('.unique-coupon').removeClass('hide');
		$('.coupon-type').removeClass('active-type');
    	$(this).addClass('active-type');
		$('input.coupon-type').val(2);
		
		$('.couponapp-code-option .couponapp-inner-text').val('Unique Code');
		$('.couponapp-code-option .coupon-code-text').text('Unique Code');
		$('.couponapp-inner-text').val('Unique Code');
		style = $('.coupon-widget-style').find('.input-field-radio:checked').val();
		if( style == '' || style == 'style-4' || style == 'style-5' )
			$('#input-field-radio-style-1').trigger('click');
		$('html, body').animate({
			scrollTop: $("#couponapp-wp-unique-coupon-code").offset().top - 130
		}, 2000);
    });

  
    $('.applies_to').click(function() {
    	applies_to = $(this).val();
    	
    	if(applies_to == 'collections') {
    		$('.applies-to-collections').removeClass('hide')
    		$('.applies-to-products').addClass('hide')

    	}
    	else if(applies_to == 'products') {
    		$('.applies-to-collections').addClass('hide')
    		$('.applies-to-products').removeClass('hide')
    		
    	}
    	else {
    		
    		$('.applies-to-collections').addClass('hide')
    		$('.applies-to-products').addClass('hide')
    	
    	}
    })

    $('.min-req').change(function() {
    	min_req = $(this).val();
    	if(min_req == 'subtotal') {
    		$('.discount-min-requirements').removeClass('hide')
    		$('.discount-min-qty-items').addClass('hide')
    	}
    	else if(min_req == 'qty') {
    		$('.discount-min-requirements').addClass('hide')
    		$('.discount-min-qty-items').removeClass('hide')
    	}
    	else {
    		$('.discount-min-requirements').addClass('hide')
    		$('.discount-min-qty-items').addClass('hide')
    	}
    })

    $('.usage-limit').click(function() {
    	if($(this).is(':checked')) {
    		$('.enable_usage_limits').removeClass('hide');
    	}
    	else {
    		$('.enable_usage_limits').addClass('hide');
    	}
    })

    $('.active-dates').click(function() {
    	if($(this).is(':checked')) {
    		$('.unique-coupon-code-start-dates').removeClass('hide');
    	}
    	else {
    		$('.unique-coupon-code-start-dates').addClass('hide');
    	}
    })

    $('.enable-item-limit').click(function() {
    	if($(this).is(':checked')) {
    		$('.discount-total-usage-limit').removeClass('hide');
    	}
    	else {
    		$('.discount-total-usage-limit').addClass('hide');
    	}
    })

    $('.close-popup').click(function() {
    	current_dialog.dialog( "close" );
    	
    });
    $('.discount-value').change(function() {
    	if( parseInt($(this).val()) < 1 ) {
			$(this).val(1);
		} 
    })
	$('.upgrade-timer').click(function(e) {
		// $('.txt').addClass('hide');
		// $('.up-txt').removeClass('hide');
		cx_slides();
		$('.countdown-timer-popup').removeClass('hide')
		$('.popup-overlayout-cls').css('display', 'block');
	}) 
 
	
	$('.upgrade-pro').click(function(e) {
		e.preventDefault();
		window.open(
			$(this).attr('url'),
			'_blank' // <- This is what makes it open in a new window.
		  );
	})

   
	$('.select-no-coupon-code').click(function() {
		$('.existing-coupon').addClass('hide');
		$('.unique-coupon').addClass('hide');
		$('.coupon-type').removeClass('active-type');
		$(this).addClass('active-type')
		$('input.coupon-type').val(4);
		$('.announcement-popup').removeClass('hide')
		$('a[tab="#popup_design"]').trigger('click')
		$('.cp').addClass('hide')
		$('.an').removeClass('hide')
		style = $('.coupon-widget-style').find('.input-field-radio:checked').val();
		if( style != 'style-4' || style != 'style-5' ) {
			$('.announcement-headline').val('Check out our latest collection');
			$('.couponapp-no-coupon-option h4').text('Check out our latest collection')
			$('#input-field-radio-style-4').trigger('click');

		}

	});

    $('#search-wp-coupon-codes-text').change( function() {
    	search = $(this).val();
    	
    	$('.tbl-coupons').find('tr').removeClass('hide');
    	if(search != '') {
    		$('.tbl-coupons tbody tr:not(:contains("'+search+'"))').addClass('hide');	
    	}
    }); 

    $('.widget-status').click(function() {
    	status = 0;
    	if( $(this).is(':checked') ) {
    		status = 1;
    	}
    	url = cx_data.site_url+'/wp-json/couponx/v1/update_status';
    	
    	widget_id = $(this).attr( 'widget-id' );
    	$.post( {
    		url   :url,
    		headers: { 'X-WP-Nonce': $('input[name="cx_nonce"]').val() },
	    	data : {
	    		'id'     : widget_id,
	    		'status' : status,
	    	},
	    	function( response ) {
	    		console.log( response );
	    	}
	    });
    });

    let delete_widget_dialog = $( "#couponapp-widget-delete-confirm" ).dialog({
		resizable: false,
		dialogClass: 'fixPosition',
		modal: true,
		draggable: false,
		height: 'auto',
		width: 400,
		overflow: 'auto',
		autoOpen : false,
		buttons:[
			{
				text: __("Cancel", 'coupon-x'),
				"class": 'btn btn-cancel',
				click: function () {
					$(this).dialog('close');
				}
			},
			{
				text: __("Delete Widget",'coupon-x'),
				"class": 'btn btn-red',
				click: function () {
					url = cx_data.site_url+'/wp-json/couponx/v1/delete_widget';
			    	widget_id = $('#dashboard_widget_id').val();
			    	$('#loader').show();
			    	$.post( {
			    		url   :url,
			    		headers: { 'X-WP-Nonce': $('input[name="cx_nonce"]').val() },
				    	data : {
				    		'id' : widget_id,		    		
				    	},
				    	success: function( response ) {
				    		console.log( response );
				    		$('#loader').hide();
				    		$('tr[data-widget="'+widget_id+'"').hide();
				    		$('#wp_flash_message').removeClass('hide');
				    		setTimeout(function(){ $('#wp_flash_message').addClass('hide'); }, 6000);
				    		location.reload();
				    	}
				    });
					$(this).dialog('close');
				}

			}
		]
	});
	$('.ui-dialog-buttonset').find('button').removeClass('ui-button');
    $('.delete-widget').click(function(e) {
    	e.preventDefault();
    	link = $(this).closest('tr');
    	let widget_id = $(this).attr( 'widget-id' );
    	$('#dashboard_widget_id').val(widget_id);
    	delete_widget_dialog.dialog("open");
    	current_dialog = delete_widget_dialog;
    })
    
    function check_for_couponapp_preview_pos() {
    	tabs = $( 'ul.coupon-tabs').not('.screen-tabs');
		if ( $(window).scrollTop() > 60 ){
			left = $('#adminmenuwrap').width();
			
			tabs.css('left', left+'px')
			tabs.addClass("sticky");
		} else {
			tabs.removeClass("sticky")
			tabs.addClass('no-sticky');
		}

	}
    //check_for_couponapp_preview_pos();
	$(window).scroll(function(){
		//check_for_couponapp_preview_pos();
	});

	$(window).resize(function(){
		//check_for_couponapp_preview_pos();
	});

	$('.keep-editing').click(function() {
		keep_editing = 1;
		validation_popup.dialog( "close" );
		$('a[tab="#triggers_targetting"]').trigger('click')
	})
	$('.select-coupon-btn').click(function() {
		validation_popup.dialog( "close" );
		$('a[tab="#choose_coupon"]').trigger('click')
	})

	$('.close_flash_popup').click(function() {
		$('#wp_flash_message').addClass('hide')
	});

	$('.btn-previewbtn').click(function(e) {
		e.preventDefault();
		$(this).hide();
		$('.tab-preview').addClass('mobile-preview');
		$('.mobile-preview-bg').show();
		
		$('.tab-preview').show();
		$('.coupon-preview-close').removeClass('hide');
	})
	$('.coupon-preview-close').click(function(e) {
		e.preventDefault();
		$('.btn-previewbtn').show();
		$('.tab-preview').removeClass('mobile-preview');
		$('.mobile-preview-bg').hide();
		$('.tab-preview').hide();
		$('.coupon-preview-close').addClass('hide');
	})

	$('.btn-popup-previewbtn').click(function(e) {
		e.preventDefault();
		$(this).hide();
		$('.popup-preview').addClass('mobile-preview');
		$('.mobile-preview-bg').show();
		
		$('.popup-preview').show();
		$('.popup-preview-close').removeClass('hide');
	})
	$('.popup-preview-close').click(function(e) {
		e.preventDefault();
		$('.btn-popup-previewbtn').show();
		$('.popup-preview').removeClass('mobile-preview');
		$('.mobile-preview-bg').hide();
		$('.popup-preview').hide();
		$(this).addClass('hide');
	})
	
	//Colorpickers

	$('#tab_color').spectrum({
	    preferredFormat: "hex",
	    showInput: true,
	    move: function (color) {
            $(this).val(color.toRgbString());
			clr =  color.toHexString();
			$('.tab-icon').css( 'background-color', clr );
			$('.icon-img').css( 'background-color', clr );
        },
		change : function( color ) {
			$(this).val(color.toRgbString());
			clr =  color.toHexString();
			$('.tab-icon').css( 'background-color', clr );
			$('.icon-img').css( 'background-color', clr );
		}	
	})
	$('#icon_color').spectrum({
	    preferredFormat: "hex",
	    showInput: true,
	    move: function (color) {
            $(this).val(color.toRgbString());
			clr =  color.toHexString();
			$('.preview-box').find('.tab-icon-svg').css( 'fill', clr );
        },
		change : function( color ) {
			$(this).val(color.toRgbString());
			clr =  color.toHexString();
			$('.preview-box').find('.tab-icon-svg').css( 'fill', clr );
		}	
	})
	$('#no_color').spectrum({
	    preferredFormat: "hex",
	    showInput: true,
	    move: function (color) {
            $(this).val(color.toRgbString());
			clr =  color.toHexString();
			$('.preview-box').find('.coupon-pending-message').css( 'color', clr );
        },
		change : function( color ) {
			$(this).val(color.toRgbString());
			clr =  color.toHexString();
			$('.preview-box').find('.coupon-pending-message').css( 'color', clr );
		}	
	});
	$('#no_bgcolor').spectrum({
	    preferredFormat: "hex",
	    showInput: true,
	    move: function (color) {
            $(this).val(color.toRgbString());
			clr =  color.toHexString();
			$('.preview-box').find('.coupon-pending-message').css( 'background-color', clr );
        },
		change : function( color ) {
			$(this).val(color.toRgbString());
			clr =  color.toHexString();
			$('.preview-box').find('.coupon-pending-message').css( 'background-color', clr );
		}	
	})
	$('#action_color').spectrum({
	    preferredFormat: "hex",
	    showInput: true,
	    move: function (color) {
            $(this).val(color.toRgbString());
			clr =  color.toHexString();
			$('.preview-box').find('.tab-text').css( 'color', clr );
        },
		change : function( color ) {
			$(this).val(color.toRgbString());
			clr =  color.toHexString();
			$('.preview-box').find('.tab-text').css( 'color', clr );
		}	
	})

	$('#action_bgcolor').spectrum({
	    preferredFormat: "hex",
	    showInput: true,
	    move: function (color) {
            $(this).val(color.toRgbString());
			clr =  color.toHexString();
			$('.preview-box').find('.tab-text').css( 'background-color', clr );
			$('.custom-icon-bg').remove();
			console.log($('.custom-pos:checked').val())
			if($('.custom-pos:checked').val() == 'left' || 
				($('.custom-pos:checked').val() == 'custom' && $('.custom_position:checked').val() == 'left')) {
				$('body').append('<style class="custom-icon-bg">.tab-text:after {border-right-color:'+clr+' !important;border-left-color:transparent !important}</style>' );
			}
			else if($('.custom-pos:checked').val() == 'right' ||
				($('.custom-pos:checked').val() == 'custom' && $('.custom_position:checked').val() == 'right')) {
				$('body').append('<style class="custom-icon-bg">.tab-text:after {border-left-color:'+clr+' !important;border-right-color:transparent !important}</style>' );
			}
        },
		change : function( color ) {
			$(this).val(color.toRgbString());
			clr =  color.toHexString();
			$('.preview-box').find('.tab-text').css( 'background-color', clr );
			$('.custom-icon-bg').remove();
			console.log($('.custom-pos:checked').val())
			if($('.custom-pos:checked').val() == 'left') {
				$('body').append('<style class="custom-icon-bg">.tab-text:after {border-right-color:'+clr+' !important;border-left-color:transparent !important}</style>' );
			}
			else if($('.custom-pos:checked').val() == 'right') {
				$('body').append('<style class="custom-icon-bg">.tab-text:after {border-left-color:'+clr+' !important;border-right-color:transparent !important}</style>' );
			}
		}	
	})

	function change_bg_color(color){
		clr =  color.toHexString();
		$('.couponapp-email-option').css( 'background-color', clr );
		if($('.cpn-cpy-style').is(':checked')) {
			$('.couponapp-email-code-option').css('background-color', clr);
		}
		if($('.cpy-style').is(':checked')) {
			$('.couponapp-no-coupon-option').css('background-color', clr);
		}
	}
	$('#main_bgcolor').spectrum({
	    preferredFormat: "hex",
	    showInput: true,
	    move: function (color) {
            $(this).val(color.toRgbString());
			change_bg_color(color)
        },
		change : function( color ) {
			$(this).val(color.toRgbString());
			change_bg_color(color)
			
		}	
	})

	function change_heading_color(color) {
		clr =  color.toHexString();
		$('.couponapp-email-option h4').css( 'color', clr );
		if($('.cpn-cpy-style').is(':checked')) {
			$('.couponapp-email-code-option h4').css('color', clr);
		}
		if($('.cpy-style').is(':checked')) {
			$('.couponapp-no-coupon-option h4').css('color', clr);
		}
	}
	$('#main_hcolor').spectrum({
	    preferredFormat: "hex",
	    showInput: true,
	    move: function (color) {
            $(this).val(color.toRgbString());
			change_heading_color(color)

        },
		change : function( color ) {
			$(this).val(color.toRgbString());
			change_heading_color(color)
		}	
	})
	function change_email_bg_color(color){
		clr =  color.toHexString();
		$('.couponapp-email-option .coupon-code-text,.couponapp-email-option .form-wrap').css( 'background-color', clr );
		if($('.cpn-cpy-style').is(':checked')) {
			style = 'background-color:'+ clr + '!important;'+
					'color: '+ $('#main_email_color').val() + '!important;';
			$('.couponapp-email-code-option .form-wrap, .couponapp-email-code-option .form-wrap p').attr( 'style', style );
		}
		
	}
	$('#main_email_bgcolor').spectrum({
	    preferredFormat: "hex",
	    showInput: true,
	    move: function (color) {
            $(this).val(color.toRgbString());
			change_email_bg_color(color)
        },
		change : function( color ) {
			$(this).val(color.toRgbString());
			change_email_bg_color(color)
		}	
	})

	function change_email_color(color){
		clr =  color.toHexString();
		$('.couponapp-email-option .coupon-code-text').css( 'color', clr );
		if($('.cpn-cpy-style').is(':checked')) {
			style = 'background-color:'+ $('#main_email_bgcolor').val() + '!important;'+
					'color: '+ clr + '!important;';
			$('.couponapp-email-code-option .form-wrap p').attr( 'style', style );
		}		
	}	
	$('#main_email_color').spectrum({
	    preferredFormat: "hex",
	    showInput: true,
	    move: function (color) {
            $(this).val(color.toRgbString());
			change_email_color(color)
        },
		change : function( color ) {
			$(this).val(color.toRgbString());
			change_email_color(color)
		}	
	})

	function change_email_border_color(color){
		clr =  color.toHexString();
		$('.couponapp-email-option .form-wrap').css( 'border-color', clr );
		if($('.cpn-cpy-style').is(':checked')) {
			style = 'border-color:'+ clr;
			$('.couponapp-email-code-option .form-wrap').attr( 'style', style );
		}		
	}
	$('#main_email_brdcolor').spectrum({
	    preferredFormat: "hex",
	    showInput: true,
	    move: function (color) {
            $(this).val(color.toRgbString());
			change_email_border_color(color)
        },
		change : function( color ) {
			$(this).val(color.toRgbString());
			change_email_border_color(color);
		}	
	})

	function change_btn_bg_color(color){
		clr =  color.toHexString();
		text_color = $('#main_btn_color').val();
		style = 'background-color:'+ clr + '!important;'+
				'color: '+ text_color + '!important;';
		$('.couponapp-email-option .coupon-button').attr( 'style', style );
		if($('.cpn-cpy-style').is(':checked')) {			
			$('.couponapp-email-code-option .coupon-button').attr( 'style', style );
		}		
	}
	$('#main_btn_bgcolor').spectrum({
	    preferredFormat: "hex",
	    showInput: true,
	    move: function (color) {
            $(this).val(color.toRgbString());
			change_btn_bg_color(color)
        },
		change : function( color ) {
			$(this).val(color.toRgbString());
			change_btn_bg_color(color)
		}	
	})
	function change_btn_color(color){
		clr =  color.toHexString();
		bg_color = $('#main_btn_bgcolor').val();
		style = 'background-color:'+ bg_color + '!important;'+
				'color: '+ clr + '!important;';
		$('.couponapp-email-option .coupon-button').attr( 'style', style );
		if($('.cpn-cpy-style').is(':checked')) {			
			$('.couponapp-email-code-option .coupon-button').attr( 'style', style );
		}		
	}
	$('#main_btn_color').spectrum({
	    preferredFormat: "hex",
	    showInput: true,
	    move: function (color) {
            $(this).val(color.toRgbString());
			change_btn_color(color)
        },
		change : function( color ) {
			$(this).val(color.toRgbString());
			change_btn_color(color)
		}	
	})
	function change_desc_color(color) {
		clr =  color.toHexString();
		$('.couponapp-email-option .coupon-description').css( 'color', clr );
		if($('.cpn-cpy-style').is(':checked')) {
			$('.couponapp-email-code-option .coupon-description').css('color', clr);
		}
		if($('.cpy-style').is(':checked')) {
			$('.couponapp-no-coupon-option p').css('color', clr);
		}
	}
	$('#main_desc_color').spectrum({
	    preferredFormat: "hex",
	    showInput: true,
	    move: function (color) {
            $(this).val(color.toRgbString());
			change_desc_color(color)
			
        },
		change : function( color ) {
			$(this).val(color.toRgbString());
			change_desc_color(color);
		}	
	})
	$('#coupon_bgcolor').spectrum({
	    preferredFormat: "hex",
	    showInput: true,
	    move: function (color) {
            $(this).val(color.toRgbString());
			clr =  color.toHexString();
			
			$('.couponapp-code-option').css( 'background-color', clr );
			$('.couponapp-link-option').css( 'background-color', clr );
        },
		change : function( color ) {
			$(this).val(color.toRgbString());
			clr =  color.toHexString();
			
			$('.couponapp-code-option').css( 'background-color', clr );
			$('.couponapp-link-option').css( 'background-color', clr );
		}	
	})
	$('#coupon_headline_clr').spectrum({
	    preferredFormat: "hex",
	    showInput: true,
	    move: function (color) {
            $(this).val(color.toRgbString());
			clr =  color.toHexString();
			
			$('.couponapp-code-option h4').css( 'color', clr );
			$('.couponapp-link-option h4').css( 'color', clr );
        },
		change : function( color ) {
			$(this).val(color.toRgbString());
			clr =  color.toHexString();
			
			$('.couponapp-code-option h4').css( 'color', clr );
			$('.couponapp-link-option h4').css( 'color', clr );
		}	
	})
	$('#coupon_pbgcolor').spectrum({
	    preferredFormat: "hex",
	    showInput: true,
	    move: function (color) {
            $(this).val(color.toRgbString());
			clr =  color.toHexString();
			style = 'background-color:'+ clr + ' !important;'+
					'color: '+ $('#coupon_color').val() + '!important;';
			$('.couponapp-email-code-option .form-wrap p.coupon-code-text, .couponapp-email-code-option .form-wrap').attr( 'style', style ); 

        },
		change : function( color ) {
			$(this).val(color.toRgbString());
			clr =  color.toHexString();
			style = 'background-color:'+ clr + ' !important;'+
					'color: '+ $('#coupon_color').val() + '!important;';
			$('.couponapp-email-code-option .form-wrap p.coupon-code-text, .couponapp-email-code-option .form-wrap').attr( 'style', style ); 

		}	
	})
	$('#coupon_color').spectrum({
	    preferredFormat: "hex",
	    showInput: true,
	    move: function (color) {
            $(this).val(color.toRgbString());
			clr =  color.toHexString();
			
			$('.couponapp-code-option .coupon-code-text').css( 'color', clr );
        },
		change : function( color ) {
			$(this).val(color.toRgbString());
			clr =  color.toHexString();
			
			$('.couponapp-code-option .coupon-code-text').css( 'color', clr );
		}	
	})
	$('#coupon_brdcolor').spectrum({
	    preferredFormat: "hex",
	    showInput: true,
	    move: function (color) {
            $(this).val(color.toRgbString());
			clr =  color.toHexString();
			$('.coupon-code-text').parent('.form-wrap').css( 'border-color', clr );
			$('#vector-nonfloat-bar path').attr('fill', clr)
        },
		change : function( color ) {
			$(this).val(color.toRgbString());
			clr =  color.toHexString();
			$('.coupon-code-text').parent('.form-wrap').css( 'border-color', clr );
			$('#vector-nonfloat-bar path').attr('fill', clr)
		}	
	})
	$('#cls_btn_color').spectrum({
	    preferredFormat: "hex",
	    showInput: true,
	    move: function (color) {
            $(this).val(color.toRgbString());
			clr =  color.toHexString();
			$('.close-design-popup').css( 'color', clr );
        },
		change : function( color ) {
			$(this).val(color.toRgbString());
			clr =  color.toHexString();
			$('.close-design-popup').css( 'color', clr );
		}	
	})
	$('#cpy_btn_bgcolor').spectrum({
	    preferredFormat: "hex",
	    showInput: true,
	    move: function (color) {
            $(this).val(color.toRgbString());
			clr =  color.toHexString();
			text_color = $('#cpy_btn_color').val();
			style = 'background-color:'+ clr + '!important;'+
				'color: '+ text_color + '!important;';
			$('.couponapp-code-option .coupon-button').attr( 'style', style );
			$('.couponapp-link-option .coupon-button').attr( 'style', style );
        },
		change : function( color ) {
			$(this).val(color.toRgbString());
			clr =  color.toHexString();
			text_color = $('#cpy_btn_color').val();
			style = 'background-color:'+ clr + '!important;'+
				'color: '+ text_color + '!important;';
			$('.couponapp-code-option .coupon-button').attr( 'style', style );
			$('.couponapp-link-option .coupon-button').attr( 'style', style );
		}	
	})
	$('#cpy_btn_color').spectrum({
	    preferredFormat: "hex",
	    showInput: true,
	    move: function (color) {
            $(this).val(color.toRgbString());
			clr =  color.toHexString();
			bg_color = $('#cpy_btn_bgcolor').val();
			style = 'background-color:'+ bg_color + '!important;'+
				'color: '+ clr + '!important;';
			$('.couponapp-code-option .coupon-button').attr( 'style', style );
			$('.couponapp-link-option .coupon-button').attr( 'style', style );
        },
		change : function( color ) {
			$(this).val(color.toRgbString());
			clr =  color.toHexString();
			bg_color = $('#cpy_btn_bgcolor').val();
			style = 'background-color:'+ bg_color + '!important;'+
				'color: '+ clr + '!important;';
			$('.couponapp-code-option .coupon-button').attr( 'style', style );
			$('.couponapp-link-option .coupon-button').attr( 'style', style );
		}	
	})
	$('#coupon_desc_color').spectrum({
	    preferredFormat: "hex",
	    showInput: true,
	    move: function (color) {
            $(this).val(color.toRgbString());
			clr =  color.toHexString();
			$('.couponapp-code-option .coupon-description').css( 'color', clr );
			$('.couponapp-link-option .coupon-description').css( 'color', clr );
        },
		change : function( color ) {
			$(this).val(color.toRgbString());
			clr =  color.toHexString();
			$('.couponapp-code-option .coupon-description').css( 'color', clr );
			$('.couponapp-link-option .coupon-description').css( 'color', clr );
		}	
	})

	$('#announcement_headline_clr').spectrum({
	    preferredFormat: "hex",
	    showInput: true,
	    move: function (color) {
            $(this).val(color.toRgbString());
			clr =  color.toHexString();
			
			$('.couponapp-no-coupon-option h4').css( 'color', clr );
			
        },
		change : function( color ) {
			$(this).val(color.toRgbString());
			clr =  color.toHexString();
			$('.couponapp-no-coupon-option h4').css( 'color', clr );
		}	
	})

	$('#announcement_desc_color').spectrum({
	    preferredFormat: "hex",
	    showInput: true,
	    move: function (color) {
            $(this).val(color.toRgbString());
			clr =  color.toHexString();
			$('.couponapp-no-coupon-option p').css( 'color', clr );
        },
		change : function( color ) {
			$(this).val(color.toRgbString());
			clr =  color.toHexString();
			$('.couponapp-no-coupon-option p').css( 'color', clr );
		}	
	})

	$('#announcement_bgcolor').spectrum({
	    preferredFormat: "hex",
	    showInput: true,
	    move: function (color) {
            $(this).val(color.toRgbString());
			clr =  color.toHexString();
			$('.couponapp-no-coupon-option').css( 'background-color', clr );
			
        },
		change : function( color ) {
			$(this).val(color.toRgbString());
			clr =  color.toHexString();
			$('.couponapp-no-coupon-option').css( 'background-color', clr );
			
		}	
	})
	$('#announcement_btn_bgcolor').spectrum({
	    preferredFormat: "hex",
	    showInput: true,
	    move: function (color) {
            $(this).val(color.toRgbString());
			clr =  color.toHexString();
			text_color = $('#announcement_btn_color').val();
			style = 'background-color:'+ clr + '!important;'+
				'color: '+ text_color + '!important;';
			$('.announcement-button').attr( 'style', style );
        },
		change : function( color ) {
			$(this).val(color.toRgbString());
			clr =  color.toHexString();
			text_color = $('#announcement_btn_color').val();
			style = 'background-color:'+ clr + '!important;'+
				'color: '+ text_color + '!important;';
			$('.announcement-button').attr( 'style', style );
		}	
	})

	$('#announcement_btn_color').spectrum({
	    preferredFormat: "hex",
	    showInput: true,
	    move: function (color) {
            $(this).val(color.toRgbString());
			clr =  color.toHexString();
			bg_color = $('#announcement_btn_bgcolor').val();
			style = 'background-color:'+ bg_color + '!important;'+
				'color: '+ clr + '!important;';
			$('.announcement-button').attr( 'style', style );
        },
		change : function( color ) {
			$(this).val(color.toRgbString());
			clr =  color.toHexString();
			bg_color = $('#announcement_btn_bgcolor').val();
			style = 'background-color:'+ bg_color + '!important;'+
				'color: '+ clr + '!important;';
			$('.announcement-button').attr( 'style', style );
		}	
	})
	$('#error_color').spectrum({
	    preferredFormat: "hex",
	    showInput: true
	});
	$('.couponapp-inner-text').click(function() {
		$('.select-wp-coupon-code').trigger('click')
	})

	$( '.preview-box .tab-icon').click(function() {
		$('.preview-box .tab-tooltip' ).addClass('tooltip-show');
		setTimeout(function() {
			$('.preview-box .tab-tooltip').removeClass('tooltip-show');
		}, 3000);
	});

	$('body').on('click', '.ui-widget-overlay', function() {
		console.log('called')
		current_dialog.dialog( "close" );
	})
	$('body').on('click', '.popup-overlayout-cls', function() {
		$('.first-widget-popup').addClass('hide');
		$('.popup-overlayout-cls').css('display', 'none');
		$('.countdown-timer-popup').addClass('hide');
	})



	//Help form

	$("#cx-help-form").submit(function(){
		$(".cx-help-button").attr("disabled",true);
		$(".cx-help-button").text("Sending Request...");
		formData = $(this).serialize();
		$.ajax({
			url: cx_data.url,
			data: formData,
			type: "post",
			success: function(responseText){
				$("#cx-help-form").find(".error-message").remove();
				$("#cx-help-form").find(".input-error").removeClass("input-error");
				responseArray = $.parseJSON(responseText);
				if(responseArray.error == 1) {
					$(".cx-help-button").attr("disabled",false);
					$(".cx-help-button").text("<?php esc_html_e( 'Chat', CHT_OPT ); ?>");
					for(i=0;i<responseArray.errors.length;i++) {
						$("#"+responseArray.errors[i]['key']).addClass("input-error");
						$("#"+responseArray.errors[i]['key']).after('<span class="error-message">'+responseArray.errors[i]['message']+'</span>');
					}
				} else if(responseArray.status == 1) {
					$(".cx-help-button").text('Done!');
					setTimeout(function(){
						$(".cx-help-header").remove();
						$(".cx-help-content").html("<p class='success-p'>Your message is sent successfully.</p>");
					},1000);
				} else if(responseArray.status == 0) {
					$(".folder-help-content").html("<p class='error-p'>There is some problem in sending request. Please send us mail on <a href='mailto:contact@premio.io'>contact@premio.io</a>" );
				}
			}
		});
		return false;
	});
	$(".cx-help-tooltip").click(function(e){
		e.stopPropagation();
		$(".cx-help-form").toggleClass("active");
	});
	$(".cx-help-form").click(function(e){
		e.stopPropagation();
	});
	$("body").click(function(){
		$(".cx-help-form").removeClass("active");
	});


	//Mailjet sign up
	$(document).on("click", ".updates-form button, a.form-cancel-btn", function () {
		var updateStatus = 0;
		if ($(this).hasClass("yes")) {
			updateStatus = 1;
		}
		$(".updates-form button").attr("disabled", true);
		$.ajax({
			url: cx_data.url,
			data: {
				action: "coupon_x_update_signup_status",
				status: updateStatus,
				nonce: $('.signup-nonce').val(),
				email: jQuery("#starts_testimonials_update_email").val()
			},
			type: 'post',
			cache: false,
			success: function () {
				window.location.reload();
			}
		})
	});


	$('input.cart-rule').click(function() {
		$(this).addClass('hide')
        $('div.cart-rule').removeClass('hide');  
		$('.enable-cart-rule').val(1);
	})
	$('.remove-cart-targeting').click(function() {
		$('div.cart-rule').addClass('hide'); 
		$('input.cart-rule').removeClass('hide');
		$('.enable-cart-rule').val(0);
	})
	$('input.order-rule').click(function() {
		$(this).addClass('hide')
        $('div.order-rule').removeClass('hide'); 
		$('.enable-order-rule').val(1); 
	})
	$('.remove-order-targeting').click(function() {
		$('div.order-rule').addClass('hide'); 
		$('input.order-rule').removeClass('hide');
		$('.enable-order-rule').val(0); 
	});
	$('input.page-rule').click(function() {
		
		$('div.page-rule').removeClass('hide');  
			    
		
	})

	$(document).on('click','.remove-page-targeting', function() {
		
		$('div.page-rule').addClass('hide');  
			
	})
	$('.popup-type:not(first-child)').mouseover(function(){
		$(this).find('.popup-upgrade').removeClass('hide')
	})
	.mouseleave(function(){
		$(this).find('.popup-upgrade').addClass('hide')
	});

	$('.select-layout').click(function () {
		layout_validation.dialog("close");		
		$('a[tab="#popup_design"]').trigger('click')
	})

	$('.popup-type:first-child').mouseover(function(){
		if( $(this).find('.btn-selected-style').hasClass('hide'))
			$(this).find('.btn-select-layout').removeClass('hide')
	})
	.mouseleave(function(){
		$(this).find('.btn-select-layout').addClass('hide')
	});

	$('.enable-btn').click( function() {
		if( $(this).is(':checked') ) {
			$('.btn-div').removeClass('hide');
			$('.announcement-button').parent('div').removeClass('hide');
		}
		else {
			$('.announcement-button').parent('div').addClass('hide');
			$('.btn-div').addClass('hide')
		}
	})
	$('.cpy-style').click( function() {
		if( $(this).is(':checked') ) {
			$('.an-clr').addClass('hide');
			$('.btn-div').addClass('hide');			

			$('.couponapp-no-coupon-option').css('background-color', $('#main_bgcolor').val());
			$('.couponapp-no-coupon-option h4').css('color', $('#main_hcolor').val());
			$('.couponapp-no-coupon-option p').css('color', $('#main_desc_color').val());
			text_color = $('#main_btn_color').val();
			clr = $('#main_btn_bgcolor').val();
			style = 'background-color:'+ clr + '!important;'+
					'color: '+ text_color + '!important;';
			$('.couponapp-no-coupon-option .announcement-button').attr( 'style', style );
			$('#announcement_headline_clr').next('.sp-replacer').addClass('hide');
			$('#announcement_desc_color').next('.sp-replacer').addClass('hide')
		}
		else {			
			console.log('here')
			$('.an-clr').removeClass('hide')
			if( $('.enable-btn').is(':checked')) {
				$('.btn-div').removeClass('hide');			
			}
			$('.couponapp-no-coupon-option').css('background-color', $('#announcement_bgcolor').val());
			$('.couponapp-no-coupon-option h4').css('color', $('#announcement_headline_clr').val());
			$('.couponapp-no-coupon-option p').css('color', $('#announcement_desc_color').val());
			text_color = $('#announcement_btn_color').val();
			clr = $('#announcement_btn_bgcolor').val();
			style = 'background-color:'+ clr + '!important;'+
					'color: '+ text_color + '!important;';
			$('.couponapp-no-coupon-option .announcement-button').attr( 'style', style );
			$('#announcement_headline_clr').next('.sp-replacer').removeClass('hide');
			$('#announcement_desc_color').next('.sp-replacer').removeClass('hide')
		}
	})

	$('.cpn-cpy-style').click( function() {
		if( $(this).is(':checked') ) {
			$('.cp-clr').addClass('hide');
			
			$('.couponapp-email-code-option').css('background-color', $('#main_bgcolor').val());
			$('.couponapp-email-code-option h4').css('color', $('#main_hcolor').val());
			console.log($('#main_desc_color').val())
			$('.couponapp-email-code-option .coupon-description').css('color', $('#main_desc_color').val() );
			text_color = $('#main_btn_color').val();
			clr = $('#main_btn_bgcolor').val();
			style = 'background-color:'+ clr + '!important;'+
					'color: '+ text_color + '!important;';
			$('.couponapp-email-code-option .coupon-button').attr( 'style', style );
			style = 'background-color:'+ $('#main_email_bgcolor').val() + '!important;'+
					'color: '+ $('#main_email_color').val() + '!important;';
			$('.couponapp-email-code-option .form-wrap p.coupon-code-text').attr( 'style', style );
			style = 'border-color:'+$('#main_email_brdcolor').val() +
					';background-color:'+ $('#main_email_bgcolor').val() + ' !important;';
			$('.couponapp-email-code-option .form-wrap').attr( 'style', style );
			$('#coupon_headline_clr').next('.sp-replacer').addClass('hide');
			$('#coupon_desc_color').next('.sp-replacer').addClass('hide');
		}
		else {			
			$('.cp-clr').removeClass('hide')
			$('.couponapp-email-code-option').css('background-color', $('#coupon_bgcolor').val());
			$('.couponapp-email-code-option h4').css('color', $('#coupon_headline_clr').val());
			$('.couponapp-email-code-option .coupon-description').css('color', $('#coupon_desc_color').val());
			text_color = $('#cpy_btn_color').val();
			clr = $('#cpy_btn_bgcolor').val();
			style = 'background-color:'+ clr + '!important;'+
					'color: '+ text_color + '!important;';
			$('.couponapp-email-code-option .coupon-button').attr( 'style', style );
			style = 'background-color:'+ $('#coupon_pbgcolor').val() + '!important;'+
					'color: '+ $('#coupon_color').val() + '!important;';
			$('.couponapp-email-code-option .form-wrap p.coupon-code-text').attr( 'style', style ); 
			style = 'background-color:'+ $('#coupon_pbgcolor').val() + '!important;'+
				'border-color:'+$('#coupon_brdcolor').val();
			$('.couponapp-email-code-option .form-wrap').attr( 'style', style );
			$('#coupon_headline_clr').next('.sp-replacer').removeClass('hide');
			$('#coupon_desc_color').next('.sp-replacer').removeClass('hide');
		}
	})
	$('.btn-action').change(function() {
		if( $(this).val() == '1' ){
			$('.announcement-redirect').addClass('hide')
		}
		else {
			$('.announcement-redirect').removeClass('hide')
		}
	})
	$('.slide-in-popup').click(function() {
		if( $('input.coupon-type').val() == '' ) {
			validation_popup.dialog( "open" );
			current_dialog = validation_popup;
			return;
		}
		$('.btn-selected-style').removeClass('hide')
		$('.popup-wrapper').removeClass('hide')
		$('.mobile-preview-btn').removeClass('hide')
		$('.popup-preview').removeClass('hide')
		$(this).find('.btn-select-layout').addClass('hide');
		$('#popup_type').val('Slide-in Pop Up');
	});

	$('.lightbox-popup, .floating-bar').click(function(){
		window.open(
			$(this).find('.popup-upgrade').find('a').attr('href'),
			'_blank' // <- This is what makes it open in a new window.
		  );
		
	});


	$('input.os-rule').click(function() {
		$(this).addClass('hide')
		$('div.os-rule').removeClass('hide');
	})
	$('.remove-os-targeting').click(function(){
		$('div.os-rule').addClass('hide'); 
		$('input.os-rule').removeClass('hide');
	})
	$('input.traffic-rule').click(function() {
		$(this).addClass('hide')
		$('.traffic-rule-main').removeClass('hide');
		$('.remove-traffic-rule').removeClass('hide')
	
	});
	
	$('.remove-traffic-rule').click(function() {
		$('.traffic-rule-main').addClass('hide');
		$(this).addClass('hide');
		$('input.traffic-rule').removeClass('hide')
		
	})
	$('input.date-rule').click(function() {
		
		$(this).addClass('hide')
		$('div.date-rule').removeClass('hide'); 
			
	})
	$('.remove-day-targeting').click(function(){
		$('div.date-rule').addClass('hide'); 
		$('input.date-rule').removeClass('hide');
		
	})
	$('input.day-rule').click(function() {
		$('div.day-rule').removeClass('hide');  
		$('input.day-rule').addClass('hide');
			
	})
	$(document).on('click','.remove-day-targeting', function() {
		$('input.day-rule').removeClass('hide');
		$('div.day-rule').addClass('hide');  
			
	})
	$('.email-client').find('label').click(function(){
		href = $(this).attr('url');
		window.open(
			href,
			'_blank'
		);
	})
	
	let cx_sliderIndex = 0;
	
	let slides,dots;
	let cxTimeout;
	let cx_slides = function( ind = '' ) {
		let i;
		slides = $(".mySlides_couponcode");
		dots = $(".dot_couponcode");
		$(".mySlides_couponcode").css('display', 'none');
		
		if( ind != '')
			cx_sliderIndex = ind;
		else
			cx_sliderIndex++;

		if (cx_sliderIndex> slides.length) {cx_sliderIndex = 1}  
		$(".dot_couponcode").removeClass('active-slid');
		
		$(".mySlides_couponcode:nth-child("+ cx_sliderIndex +")").css('display', 'block');
		ind = cx_sliderIndex + 1;
		$(".dot_couponcode:nth-child("+ ind +")").addClass('active-slid');
		
		cxTimeout = setTimeout(cx_slides, 5000); // Change image every 8 seconds
	}
	
	$('.next').click(function() {
		clearTimeout(cxTimeout);
		cx_sliderIndex += 1;
		if (cx_sliderIndex> slides.length) {cx_sliderIndex = 1}
		else if(cx_sliderIndex<1){cx_sliderIndex = slides.length}
		
		cx_slides(cx_sliderIndex);
	});

	$('.prev').click(function() {
		clearTimeout(cxTimeout);
		if (cx_sliderIndex == 1 ) { cx_sliderIndex = slides.length}
		else cx_sliderIndex --;
		
		cx_slides(cx_sliderIndex);
	})

	$('.dot_couponcode').click(function() {
		clearTimeout(cxTimeout);
		cx_sliderIndex = $(this).data('pos')
		
		cx_slides(cx_sliderIndex);
	})

	$('.close-timer-popup').click(function() {
		$('.countdown-timer-popup').addClass('hide')
		$('.popup-overlayout-cls').css('display', 'none');
	})
	
	
})