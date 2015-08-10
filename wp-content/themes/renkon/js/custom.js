
/*-----------------------------------------------------------------------------------
 Off Canvas Sidebar
-----------------------------------------------------------------------------------*/

var showSidebar = function() {
	jQuery('body').removeClass("active-nav").toggleClass("active-sidebar");				
	jQuery('.sidebar-button').toggleClass("active-button");
}

var showMenu = function() {
	jQuery('body').removeClass("active-sidebar").toggleClass("active-nav");
	jQuery('.sidebar-button').removeClass("active-button");
}

// add/remove classes everytime the window resize event fires
jQuery(window).resize(function(){
	var off_canvas_nav_display = jQuery('.off-canvas-nav').css('display');
	var menu_button_display = jQuery('.menu-button').css('display');
	if (off_canvas_nav_display === 'block') {			
		jQuery("body").removeClass("big-screen").addClass("small-screen");				
	} 
	if (off_canvas_nav_display === 'none') {
		jQuery("body").removeClass("active-sidebar active-nav small-screen")
			.addClass("big-screen");			
	}

});	

jQuery(document).ready(function(jQuery) {
		
		// Toggle for sidebar
		jQuery('.sidebar-button').click(function(e) {
			e.preventDefault();
			showSidebar();
			jQuery('html, body').animate({ scrollTop: 0 }, 0);						
		});

	// Toggle for nav mask right
		jQuery('.mask-right').click(function(e) {
			e.preventDefault();
			showSidebar();
			jQuery('html, body').animate({ scrollTop: 0 }, 0 );
		});
});

/*--------------------------------------------------------------------------------------------
  Show/Hide for Share Buttons
----------------------------------------------------------------------------------------------*/

jQuery(document).ready(function(){
    jQuery('.share-links-wrap').hide();
    jQuery('.share-btn').click(function () {
       jQuery(this).next('.share-links-wrap').fadeToggle('fast');
    });
});

/*---------------------------------------------------------------------------------------------
  Scalable/responsive Videos (more info see: fitvidsjs.com) 
----------------------------------------------------------------------------------------------*/
jQuery(document).ready(function(){
	jQuery('.container').fitVids();
});

/*---------------------------------------------------------------------------------------------
  Scalable Header Slogan Text (more info see: fittextjs.com)
----------------------------------------------------------------------------------------------*/
jQuery(document).ready(function(){
	jQuery(".header-slogan").fitText(1.2, { minFontSize: '24px', maxFontSize: '90px' })
});

/*--------------------------------------------------------------------------------------------
  Smooth Scroll for Header Image Button
----------------------------------------------------------------------------------------------*/

jQuery(document).ready(function(){
jQuery('.header-btn').click(function(){
    jQuery('html, body').animate({
        scrollTop: jQuery( jQuery(this).attr('href') ).offset().top
    }, 500);
    return false;
});
});

/*--------------------------------------------------------------------------------------------
  Sticky Footer
----------------------------------------------------------------------------------------------*/
jQuery(window).bind("load", function() {
	var footer = jQuery(".colophon");
	var pos = footer.position();
	var height = jQuery(window).height();

	height = height - pos.top;
	height = height - footer.height();
    if (height > 0) {
	  footer.css({'margin-top' : height+'px'});
  }
});