/*-----------------------------------------------------------------------------------
 Masonry Grid Layout (no Infinite Scroll)
-----------------------------------------------------------------------------------*/

  jQuery(document).ready(function() {

    var $container = jQuery('#site-content');

    $container.imagesLoaded(function(){
      $container.masonry({
        itemSelector: '.postblog',
       resizable: false, // disable normal resizing
       // set columnWidth to a percentage of container width
       masonry: { columnWidth: $container.width() / 12 }
      });
    });

    // update columnWidth on window resize
    jQuery(window).resize(function(){
	    $container.masonry({
	    // update columnWidth to a percentage of container width
	    masonry: { columnWidth: $container.width() / 12 }
	   });
	});

  });