// JavaScript Document
var fadetime = 1000;
var pausetime = 5000;
var slidetimeout = false;

jQuery(function($) {
	DD_belatedPNG.fix('#logo img');
	DD_belatedPNG.fix('#footerlogo img');

	//CLEAR ON FOCUS
	jQuery('.clearOnFocus').each(function() {
		if (jQuery(this).siblings('input[name="' + jQuery(this).attr('name') + '-default"]').length == 0) { jQuery(this).before('<input type="hidden" name="' + jQuery(this).attr('name') + '-default" value="' + jQuery(this).val() + '" />'); }
		if (jQuery(this).val() != jQuery(this).siblings('input[name="' + jQuery(this).attr('name') + '-default"]').val()) { jQuery(this).addClass('hascontent'); }
	});
	jQuery('.clearOnFocus').focus(function() { if (jQuery(this).val() == jQuery(this).siblings('input[name="' + jQuery(this).attr('name') + '-default"]').val()) { jQuery(this).val(''); } jQuery(this).addClass('hasfocus'); jQuery(this).addClass('hascontent'); });
	jQuery('.clearOnFocus').blur(function()  { if (jQuery(this).val() == '') { jQuery(this).val(jQuery(this).siblings('input[name="' + jQuery(this).attr('name') + '-default"]').val()); jQuery(this).removeClass('hascontent'); } jQuery(this).removeClass('hasfocus'); });
	//END CLEAR ON FOCUS

	jQuery('table.columns').each(function() {
		jQuery(this).find("tr:first").addClass('first_tr');
		jQuery(this).find("tr:last").addClass('last_tr');

		jQuery(this).find("tr").each(function() { jQuery(this).find("td:first").addClass('first'); });
		jQuery(this).find("tr").each(function() { jQuery(this).find("td:last").addClass('last'); });

		var colcount = jQuery(this).find("tr:has(td):first td").length;
		jQuery(this).addClass("cols_" + colcount);
	});

	if (jQuery('#slideshow').length > 0) {
		slidetimeout = setTimeout('nextSlide()', pausetime);
	}
});

function nextSlide() {
	var currslide = parseInt(jQuery('#slideshow .slide.current').attr('id').replace('slide', ''));
	var nextslide = currslide + 1;

	if (jQuery('#slideshow .slide').eq(nextslide).length == 0) {
		nextslide = 0;
	}

	jQuery('#slideshow .slide').eq(nextslide).show();
	jQuery('#slideshow .slide.current').fadeOut(fadetime, function() { jQuery(this).removeClass('current'); jQuery('#slideshow .slide').eq(nextslide).addClass('current'); });

	jQuery('#slideshow .bullet').removeClass('current');
	jQuery('#slideshow .bullet').eq(nextslide).addClass('current');

	slidetimeout = setTimeout('nextSlide()', pausetime);
}
jQuery(document).ready(function() {

// scroll topic


	 jQuery(function() {
	 	if (jQuery('.topinfoAZ').length > 0) {
	    jQuery('a[href*="#"].scroll:not([href="#"])').click(function(event) {
	        var target = jQuery(this.hash);
	        if (target.length) {
	        	 	event.preventDefault();
	          jQuery('html, body').animate({
	            scrollTop: target.offset().top
	          }, 1000);
	        }
	    });
	  	 }
	  });

	  	//Accordion

	function close_accordion_section() {
        jQuery('.accordion .accordion-section-title').removeClass('active');
        jQuery('.accordion .accordion-section-content').slideUp(300).removeClass('open');
    }

    jQuery('.accordion-section-title').click(function(e) {
        // Grab current anchor value
        var currentAttrValue = jQuery(this).attr('href');

        if(jQuery(e.target).is('.active')) {
            close_accordion_section();
        }else {
            close_accordion_section();

            // Add active class to section title
            jQuery(this).addClass('active');
            // Open up the hidden content panel
            jQuery('.accordion ' + currentAttrValue).slideDown(300).addClass('open');
        }

        e.preventDefault();
    });

});
