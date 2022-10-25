(function ($) {
	'use strict';

$(function () {


$( "#panel a" ).on( 'click', function(e){
	e.preventDefault();
		
	$('#panel').find('a.active').removeClass("active");
		$(this).addClass("active");
		$('#wpzoom-theme-css').remove();

		var href = $(this).attr('href');
		var link_stylesheet = '<link rel="stylesheet" id="wpzoom-theme-css" class=type="text/css" href="' + href + '">';

		$('head').append( link_stylesheet );
		
		//console.log( link_stylesheet );
		//return false;
   });  

});


})(jQuery);

jQuery(document).ready(function(){
	jQuery(".wpzoom-style-picker").fadeIn();

	jQuery(".wpzoom-style-picker .close-button").on("click", function(e){
		jQuery(".wpzoom-style-picker").toggleClass("closed");
		e.preventDefault();
	});

	jQuery("label.style-option").each(function(){
		var $inputid = "#" + jQuery(this).attr( 'data-input' );
		var $input = jQuery( $inputid );
		var $selector = $input.attr("data-selector");

		jQuery(this).parent().find( 'label' ).each(function(){
			var $val = jQuery(this).attr( 'data-value' );
			if( jQuery($selector).hasClass( $val ) ) {
				$input.val( $val );
				jQuery(this).parent().find('label.active').removeClass("active");
				jQuery(this).addClass("active");
			}
		});
	});

	jQuery('label[id^="wpzoom-style-picker-"]').on( "click" , function(e){
		var $inputid = "#" + jQuery(this).attr( 'data-input' );
		var $input = jQuery( $inputid );

		var $val = jQuery(this).attr( 'data-value' );
		var $selector = $input.attr("data-selector");

		$oldval = jQuery( $inputid ).val()
		$input.val( $val );

		if( $input.attr("data-css") ){
			$css = $input.attr("data-css");
			var $options = {};
			$options[$css] = $val;
			jQuery( $selector ).animate( $options );
		} else {
			jQuery( $selector ).removeClass( $oldval );
			jQuery( $selector ).addClass( $val );
		}

		jQuery(this).parent().find('label.active').removeClass("active");
		jQuery(this).addClass("active");
	});

	jQuery('select[name^="wpzoom-style-picker-"]').each( function(e){
		jQuery(this).data("old", jQuery(this).val() );
	});

	jQuery('[name^="wpzoom-style-picker-"]').on( "change" , function(e){
		jQuery(this).data("new", jQuery(this).val());

		var $selector = jQuery(this).attr("data-selector");
		var $val = jQuery(this).val();
		var $oldval = jQuery(this).data("old");

		if( jQuery(this).attr("data-css") ){
			jQuery( $selector ).css( jQuery(this).attr("data-css") , $val );
		} else {
			jQuery( $selector ).removeClass( $oldval );
			jQuery( $selector ).addClass( $val );
		}

		console.log( $oldval + " || " + $val );

		jQuery(this).data("old", $val );
	})
});