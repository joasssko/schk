
/*-----------------------------------------------------------------------------------
 Masonry Grid Layout with Infinite Scroll
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


  $container.infinitescroll({
      navSelector  : '#nav-below',    // selector for the paged navigation
      nextSelector : '.nav-previous a',  // selector for the NEXT link (to page 2)
      itemSelector : '.postblog',     // selector for all items you'll retrieve
      loading: {
      		msgText: 'Loading...',
      		finishedMsg: 'No more pages to load.',
      		img: ''
      }
    },

   // trigger Masonry as a callback
   function( newElements ) {
        // hide new items while they are loading
        var $newElems = jQuery( newElements ).css({ opacity: 0 });
        // ensure that images load before adding to masonry layout
        $newElems.imagesLoaded(function(){
          // show elems now they're ready
          $newElems.animate({ opacity: 1 });
          $container.masonry( 'appended', $newElems, true );
      });
    });

   });
