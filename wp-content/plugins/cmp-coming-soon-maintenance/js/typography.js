jQuery(document).ready(function($){

	headingVariant = jQuery('.cmp-coming-soon-maintenance .headings-google-font-variant').val();
	contentVariant = jQuery('.cmp-coming-soon-maintenance .content-google-font-variant').val();

	fontVariant = function( variant ) {
		switch(variant) {
		    case '100':
		        return 'Thin 100';
		        break;
		    case '100italic':
		        return 'Thin 100 Italic';
		        break;
		    case '200':
		        return 'Extra-light 200';
		        break;
		    case '200italic':
		        return 'Extra-light 200 Italic';
		        break;
		    case '300':
		        return 'Light 300';
		        break;
		    case '300italic':
		        return 'Light 300 Italic';
		        break;
		    case '400':
		        return 'Regular 400';
		        break;
		    case '400italic':
		        return 'Regular 400 Italic';
		        break;
		    case '500':
		        return 'Medium 500';
		        break;
		    case '500italic':
		        return 'Meidum 500 Italic';
		        break;
		    case '600':
		        return 'Semi-Bold 600';
		        break;
		    case '600italic':
		        return 'Semi-Bold 600 Italic';
		        break;
		    case '700':
		        return 'Bold 700';
		        break;
		    case '700italic':
		        return 'Bold 700 Italic';
		        break;
		    case '800':
		        return 'Extra-Bold 800';
		        break;
		    case '800italic':
		        return 'Extra-Bold Italic';
		        break;
		    case '900':
		        return 'Black 900';
		        break;
		    case '900italic':
		        return 'Black 900 Italic';
		        break;
		    case 'regular':
		        return 'Regular 400';
		        break;
		    case 'italic':
		        return 'Regular 400 Italic';
		        break;
		    default:
		        break;
		}
	}

	var heading_font = fonts.google.filter(function (element) { 
	    return element.id === jQuery('.cmp-coming-soon-maintenance .headings-google-font option:selected').val();
	});

	var content_font = fonts.google.filter(function (element) { 
	    return element.id === jQuery('.cmp-coming-soon-maintenance .content-google-font option:selected').val();
	});

	if (heading_font.length) {
		var heading_font_variant = jQuery.map( heading_font[0].variants, function(obj) {
			return { id: obj, text: fontVariant(obj) };
		});
	}

	if (content_font.length) {
		var content_font_variant = jQuery.map( content_font[0].variants, function(obj) {
			return { id: obj, text: fontVariant(obj) };
		});
	}



	// ini select2 
	$HeadingFont = jQuery( '.cmp-coming-soon-maintenance .headings-google-font' ).select2({
		data: fonts.google,
		width: '100%',
	});

	// ini select2 
	$contentFont = jQuery( '.cmp-coming-soon-maintenance .content-google-font' ).select2({
		data: fonts.google,
		width: '100%',
	});

	// ini select2 
	$HeadingFontVariant = jQuery('.cmp-coming-soon-maintenance .headings-google-font-variant').select2({
		data: heading_font_variant,
	})

	// ini select2 
	$contentFontVariant = jQuery('.cmp-coming-soon-maintenance .content-google-font-variant').select2({
		data: content_font_variant,
	})


	// change preview fonts on select2 selection
	$HeadingFont.on('select2:select', function(e){
		// get current variant value
		var selected = $HeadingFontVariant.select2('data');

		var heading_font_variant = jQuery.map( e.params.data.variants, function(obj) {
			return { id: obj, text: fontVariant(obj) };
		});

		// empty select variant
		$HeadingFontVariant.empty();
		// populate select with new variants
		$HeadingFontVariant.select2({
			data: heading_font_variant
		});

		// set same variant as before selection if variant is in array, else set regular
		if ( selected[0].id ) {

			if ( jQuery.inArray(selected[0].id, e.params.data.variants ) == '-1' ) {
				jQuery('#heading-example, #niteoCS-text-logo').css('font-weight', '400' ).css('font-style', 'normal' );
			} else {
				$HeadingFontVariant.val(selected[0].id).trigger('change.select2');
			}
		}

		// load fonts and set css
		WebFont.load({
		  google: {
		    families: [ e.params.data.text+':100,200,300,400,500,600,700,900,100italic,300italic,400italic,500italic,600italic,700italic,900italic' ]
		  },
		  active: function() {
		  	jQuery('#heading-example, #niteoCS-text-logo').css('font-family', e.params.data.text );
		  },
		});
	});


	$HeadingFontVariant.on('select2:select', function(e){

		headingVariant = e.params.data.id;

		if ( jQuery.isNumeric(headingVariant) ) {
			jQuery('#heading-example, #niteoCS-text-logo').css('font-weight', headingVariant ).css('font-style', 'normal' );

		} else if ( headingVariant == 'regular' ) {
			jQuery('#heading-example, #niteoCS-text-logo').css('font-weight', '400' ).css('font-style', 'normal' );

		} else  if ( headingVariant == 'italic' ) {
			jQuery('#heading-example, #niteoCS-text-logo').css('font-style', 'italic' ).css('font-weight', '400' );

		} else {
			fontweight = parseInt(headingVariant, 10);
			jQuery('#heading-example, #niteoCS-text-logo').css('font-weight', fontweight ).css('font-style', 'italic' );
		}
		
	});


	// change content preview fonts on font select
	$contentFont.on('select2:select', function(e){
		// get current variant value
		var selected = $contentFontVariant.select2('data');

		var content_font_variant = jQuery.map( e.params.data.variants, function(obj) {
			return { id: obj, text: fontVariant(obj) };
		});

		// empty select variant
		$contentFontVariant.empty();
		// populate select with new variants
		$contentFontVariant.select2({
			data: content_font_variant
		});

		// set same variant as before selection if variant is in array, else set regular
		if ( selected[0].id ) {

			if ( jQuery.inArray(selected[0].id, e.params.data.variants ) == '-1' ) {
				jQuery('#content-example').css('font-weight', '400' ).css('font-style', 'normal' );
			} else {
				$contentFontVariant.val(selected[0].id).trigger('change.select2');
			}
		}

		// load fonts and set css
		WebFont.load({
		  google: {
		    families: [ e.params.data.text+':100,200,300,400,500,600,700,900,100italic,300italic,400italic,500italic,600italic,700italic,900italic' ]
		  },
		  active: function() {
		  	jQuery('#content-example').css('font-family', e.params.data.text );
		  },
		});
	});

	$contentFontVariant.on('select2:select', function(e){

		contentVariant = e.params.data.id;

		if ( jQuery.isNumeric(contentVariant) ) {
			jQuery('#content-example').css('font-weight', contentVariant ).css('font-style', 'normal' );

		} else if ( contentVariant == 'regular' ) {
			jQuery('#content-example').css('font-weight', '400' ).css('font-style', 'normal' );

		} else  if ( contentVariant == 'italic' ) {
			jQuery('#content-example').css('font-style', 'italic' ).css('font-weight', '400' );

		} else {
			fontweight = parseInt(contentVariant, 10);
			jQuery('#content-example').css('font-weight', fontweight ).css('font-style', 'italic' );
		}
		
	});

	jQuery('.cmp-coming-soon-maintenance .font-selector input[type=range]').on('input', function () {
		var type = jQuery(this).data('type');
		var css = jQuery(this).data('css');
		var value = jQuery(this).val();

		// change label value
		jQuery(this).parent().find('span').html(value);

		// add px if css requires it
		value = (css == 'line-height') ? value : value+'px';

		// change example css
		if ( type == 'heading' ) {
			jQuery('#heading-example').css(css, value);

		} else {
			jQuery('#content-example').css(css, value);
		}
	});

	if ( heading_font.length && content_font.length ) {
		// change fonts families upon a load 
		WebFont.load({
		  google: {
		    families: [ heading_font[0]['id']+':100,200,300,400,500,600,700,900,100italic,300italic,400italic,500italic,600italic,700italic,900italic', content_font[0]['id']+':100,200,300,400,500,600,700,900,100italic,300italic,400italic,500italic,600italic,700italic,900italic' ]
		  },
		  active: function() {

			if ( jQuery.isNumeric(headingVariant) ) {
				jQuery('#heading-example').css('font-weight', headingVariant ).css('font-style', 'normal' );

			} else if ( headingVariant == 'regular' ) {
				jQuery('#heading-example').css('font-weight', '400' ).css('font-style', 'normal' );

			} else  if ( headingVariant == 'italic' ) {
				jQuery('#heading-example').css('font-style', 'italic' ).css('font-weight', '400' );

			} else {
				fontweight = parseInt(headingVariant, 10);
				jQuery('#heading-example').css('font-weight', fontweight ).css('font-style', 'italic' );
			}

			if ( jQuery.isNumeric(contentVariant) ) {
				jQuery('#content-example').css('font-weight', contentVariant ).css('font-style', 'normal' );

			} else if ( contentVariant == 'regular' ) {
				jQuery('#content-example').css('font-weight', '400' ).css('font-style', 'normal' );

			} else  if ( contentVariant == 'italic' ) {
				jQuery('#content-example').css('font-style', 'italic' ).css('font-weight', '400' );

			} else {
				fontweight = parseInt(contentVariant, 10);
				jQuery('#content-example').css('font-weight', fontweight ).css('font-style', 'italic' );
			}

		  	jQuery('#heading-example, #niteoCS-text-logo').css('font-family', heading_font[0]['id'] );
		  	jQuery('#content-example').css('font-family', content_font[0]['id'] );
		  },
		});
	}

});

