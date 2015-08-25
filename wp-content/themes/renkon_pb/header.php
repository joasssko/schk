<?php
/**
 * The theme Header.
 *
 * @package Renkon 
 * @since Renkon 1.0
 */
?><!DOCTYPE html>
<html  id="doc" class="no-js" <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>" />
<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
<title><?php wp_title( '|', true, 'right' ); ?></title>
<link rel="profile" href="http://gmpg.org/xfn/11" />
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
<?php $options = get_option('renkon_theme_options'); ?>
<?php if( $options['custom_favicon'] != '' ) : ?>
<link rel="shortcut icon" type="image/ico" href="<?php echo $options['custom_favicon']; ?>" />
<?php endif  ?>
<?php if( $options['custom_apple_icon'] != '' ) : ?>
<link rel="apple-touch-icon" href="<?php echo $options['custom_apple_icon']; ?>" />
<?php endif  ?>
<script type="text/javascript">
	var doc = document.getElementById('doc');
	doc.removeAttribute('class', 'no-js');
	doc.setAttribute('class', 'js');
</script>
      
<?php // Loads HTML5 JavaScript file to add support for HTML5 elements in older IE versions. ?>
<!--[if lt IE 9]>
<script src="<?php echo get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo get_template_directory_uri(); ?>/css/ie.css" />
<![endif]-->
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?> id="menu">



<header id="site-header" role="banner">
	<nav class="off-canvas-nav">
    	<a href="<?php echo get_bloginfo('url')?>"><img src="http://www.schkolnick.com/schkolnick.png" width="300"  height="100" alt=""/></a>
		<span class="sidebar-item pull-right">
        	<span class="" id="openfiltro">Filter Content</span>
            <span class="" id="cerrarfiltro">Close Filter</span>
		</span>
	</nav><!-- end .off-canvas-navigation -->
</header><!-- end #site-header -->

<div id="filtro">
    <div class="bscontainer">
        <div class="row">
        	<div class="clear separator"></div>
            <?php /* <div class="col-md-3 col-lg-3">
                <h3>&nbsp;</h3>
                
            </div> */?>

            
            <div class="col-md-3 col-lg-3" id="disciplina">
      
  <li><a href="http://www.schkolnick.com">Home</a></li>
  <li><a href="http://www.schkolnick.com/production/">Production</a></li>
  <li><a href="http://www.schkolnick.com/reels/">Reel</a></li>
  <li><a href="http://www.schkolnick.com/portfolios/">Portfolios</a></li>
    <li><a href="http://www.schkolnick.com/newsletter/">Newsletter</a></li>
  <li><a href="http://www.schkolnick.com/contact/">Contact</a></li>

              <h33>Discipline</h33>
              <?php $dc = get_terms('disciplina' , array('hide_empty' => false))?>
                <?php foreach($dc as $dd):?>
              <li><button id="dc-<?php echo $dd->term_taxonomy_id?>" class="btn btn-link btn-sm"><?php echo $dd->name?></button></li>
                <?php endforeach;?>
            </div>
            
            <div class="col-md-3 col-lg-3" id="artistas">
              <h33>Artists</h33>
             <?php $at = get_terms('artistas' , array('hide_empty' => false))?>
                <?php foreach($at as $aa):?>
                    <?php $pp = get_field('disciplina' , 'artistas_'.$aa->term_taxonomy_id)?>
              <li><button id="at-<?php echo $aa->term_taxonomy_id?>" class="pp-<?php echo $pp?> btn btn-link btn-sm"><?php echo $aa->name?></button></li>
                <?php endforeach;?>
            </div>
            
            <div class="col-md-3 col-lg-3" id="tipo">
                <h33>Category</h33>
                <?php $tp = get_terms('tipo' , array('hide_empty' => false))?>
                <?php foreach($tp as $tt):?>
                    <li><button id="tp-<?php echo $tt->term_taxonomy_id?>" class="btn btn-link btn-sm"><?php echo $tt->name?></button></li>
                <?php endforeach;?>
            </div>
            <div class="clear separator"></div>
        </div>
    </div>
</div>

<script type="text/javascript">
jQuery(document).ready(function($) {
	
	var $container = jQuery('#site-content');
	//abre y cierra el filtro
	$('#openfiltro').click(function(event) {
		$('#filtro').slideDown('slow');
		$('#openfiltro').css('display' , 'none');
		$('#cerrarfiltro').css('display' , 'block');
	});
	$('#cerrarfiltro').click(function(event) {
		$('#filtro').slideUp('slow');
		$('#openfiltro').css('display' , 'block');
		$('#cerrarfiltro').css('display' , 'none');
	});
	
	//Filtro de Disciplinas
	<?php foreach($dc as $ds):?>
	$('#disciplina li #dc-<?php echo $ds->term_taxonomy_id?>').click(function(event) {
			
		$('article.nomostrar').removeClass('nomostrar')
		
		$('#artistas li button').attr('disabled' , false);
		$('#tipo li button').attr('disabled' , false);
		
		$('#artistas li button').not('.pp-<?php echo $ds->term_taxonomy_id?>').attr('disabled', 'disabled');
		
		//$container.masonry('remove' , 'article');
		 
		$.ajax({
			type: "GET",
			url: "wp-admin/admin-ajax.php",
			dataType: 'html',
			data: ({ action: 'cargaPortfolio' , disciplina : '<?php echo $ds->name?>' }),
			success: function(data){
				//console.log(data);
				$('#site-content').html(data);
				//$container.masonry({masonry: { columnWidth: $container.width() / 3 }});
				$container.imagesLoaded(function(){ 
					$container.masonry('reloadItems');
					$container.masonry('reload');
					$container.masonry({masonry: { columnWidth: $container.width()  }});
				});
			},
			error: function(data)  
				{  
					console.log("No se pudo los filtros");
					return false;
				}  
	
		}); 
		
		//*$('article').hasClass('nomostrar').removeClass('nomostrar')
		
		//B$('article:not(.pd-<?php echo $ds->term_taxonomy_id?>)').addClass('nomostrar');
		//console.log($container.width())
		//B$container.masonry({masonry: { columnWidth: $container.width()  }});
		
	});
	<?php endforeach;?>
		
	$('#artistas li').click(function(event) {
		//$(this).children('button').prop('disabled', false)
		//$('#artistas li button:not(:disabled)').prop('disabled' , true)
	});
		
	<?php foreach($at as $aa):?>
	$('#artistas li #at-<?php echo $aa->term_taxonomy_id?>').click(function(event) {
		
		$('article.nomostrar').removeClass('nomostrar')
		$('#tipo li button').attr('disabled' , false);
		$('#artistas li button').not('#at-<?php echo $aa->term_taxonomy_id?>').attr('disabled', 'disabled');
		
		$.ajax({
			type: "GET",
			url: "wp-admin/admin-ajax.php",
			dataType: 'html',
			data: ({ action: 'cargaPortfolio' , artista : '<?php echo $aa->name?>' }),
			success: function(data){
				//console.log(data);
				$('#site-content').html(data);
				//$container.masonry({masonry: { columnWidth: $container.width() / 3 }});
				$container.imagesLoaded(function(){ 
					$container.masonry('reloadItems');
					$container.masonry('reload');
					$container.masonry({masonry: { columnWidth: $container.width()  }});
				});
			},
			error: function(data)  
				{  
					console.log("No se pudo los filtros");
					return false;
				}  
	
			}); 
			
			//B$('article:not(.at-<?php echo $aa->term_taxonomy_id?>)').addClass('nomostrar')
			//console.log($container.width())
			//B$container.masonry({masonry: { columnWidth: $container.width()  }});
		});

		<?php endforeach; ?>
		
		<?php foreach($tp as $tt):?>

		$('#tipo li #tp-<?php echo $tt->term_taxonomy_id?>').click(function(event) {
			$('article.nomostrar').removeClass('nomostrar')
			$('#tipo li button').not('#tp-<?php echo $tt->term_taxonomy_id?>').attr('disabled', 'disabled')
			$('article:not(.td-<?php echo $tt->term_taxonomy_id?>)').addClass('nomostrar')
			//console.log($container.width())
			$container.masonry({masonry: { columnWidth: $container.width() / 3 }});
		});

		<?php endforeach; ?>
		
	});




</script>

	<a class="mask-right" href="#menu"></a>

	<div class="column-wrap">

	<div class="container">

		<?php $header_image = get_header_image();
			if ( ! empty( $header_image ) and is_front_page()) : ?>
			<div id="header-image" style="background-image: url(<?php echo esc_url( $header_image ); ?>); " >
				<div class="header-outer">
					<div class="header-inner">
						<?php if( $options['header-slogan'] ) : ?>
							<p class="header-slogan"><?php echo stripslashes($options['header-slogan']); ?></p>
						<?php endif; ?>
						<?php if( $options['header-subtitle'] ) : ?>
							<p class="header-subtitle"><?php echo stripslashes($options['header-subtitle']); ?></p>
						<?php endif; ?>
						<?php if( $options['header-slogan'] ) : ?>
							<a href="#content-wrap" class="header-btn"><?php _e( 'Show Content', 'renkon' ); ?></a>
						<?php endif; ?>
					</div><!-- end .header-inner -->
				</div><!-- end .header-outer -->
			</div><!-- end .header-image -->
		<?php endif; ?>

		<div id="content-wrap">
	