<?php
/**
 * The main template file.
 *
 * @package Renkon 
 * @since Renkon 1.0
 */

get_header(); ?>

<script type="text/javascript">

var notIn = '<?php foreach($posts as $p):echo $p->ID.',';endforeach?>';
var paGed = 2;
var $container = jQuery('#site-content');

jQuery(document).ready(function($) {
	jQuery('#loadmore').click(function(event) {
		event.preventDefault();
		$('#site-content').fadeTo('slow', 0.1, function() {
			$.ajax({
				type: "GET",
				url: "wp-admin/admin-ajax.php",
				dataType: 'html',
				data: ({ action: 'cargaPlus' , notin : notIn , paged : paGed }),
				success: function(data){
					$('#site-content').append(data);
					$('#site-content').masonry('destroy');
					$(window).trigger('resize');
					//$('#site-content').css('max-width' , 1199.9);
					paGed = paGed + 1;
					console.log(paGed);
				},
				error: function(data)  
					{  
						console.log("No se pudo los filtros");
						return false;
					}  
		
			});
			
			/* $('#site-content').masonry({ 
				columnWidth: $container.width() ,
				itemSelector : '.post'
			}); */
			//$('#site-content').masonry();
					
					/* $('#site-content').masonry('reloadItems');
					$('#site-content').masonry('reload');
					$('#site-content').masonry({masonry: { columnWidth: $container.width()  }}); */
			//$('#site-content').css('max-width' , 1199.9)
			$('#site-content').fadeTo('slow', 1)
		});
	});
});
</script>

		<?php if ( have_posts() ) : ?>

		<div id="site-content">

			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>
		
		</div><!-- end #site-content -->
        <div class="clear"></div>
        <div id="nav-below">
        	<div class="loadmore" ><a href="#" id="loadmore">Cargar Más</a></div>
        </div>
		
		<?php /* Display navigation to next/previous pages when applicable, also check if WP pagenavi plugin is activated */ ?>
		<?php /* if(function_exists('wp_pagenavi')) : wp_pagenavi(); else: ?>
			<?php renkon_content_nav( 'nav-below' ); ?>
		<?php endif;  */ ?>

		<?php endif; ?>

		</div><!-- end .content-wrap -->
		
		<?php get_template_part( 'colophon' ); ?>

	</div><!-- end .container -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>