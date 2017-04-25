<?php
/**
 * This is the BODY footer include template.
 *
 * For a quick explanation of b2evo 2.0 skins, please start here:
 * {@link http://b2evolution.net/man/skin-development-primer}
 *
 * This is meant to be included in a page template.
 *
 * @package evoskins
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );
?>

</div>

<footer class="container-fluid skin-footer-single">
<div class="row">

	<!-- =================================== START OF FOOTER =================================== -->
	<div class="container skin-footer-content">

		<div class="evo_container evo_container__footer">
		<?php
			// Display container and contents:
			skin_container( NT_("Footer"), array(
					// The following params will be used as defaults for widgets included in this container:
					'block_start'       => '<div class="evo_widget $wi_class$">',
					'block_end'         => '</div>',
					// Search
					'search_input_before'  => '<div class="input-group">',
					'search_input_after'   => '',
					'search_submit_before' => '<span class="input-group-btn">',
					'search_submit_after'  => '</span></div>',
				) );
			// Note: Double quotes have been used around "Footer" only for test purposes.
		?>
		</div>

		<div class="clearfix"></div>
		<p class="center">
			<?php
				// Display footer text (text can be edited in Blog Settings):
				$Blog->footer_text( array(
						'before' => '',
						'after'  => ' &bull; ',
					) );
			?>

			<?php
				// Display a link to contact the owner of this blog (if owner accepts messages):
				$Blog->contact_link( array(
						'before' => '',
						'after'  => ' &bull; ',
						'text'   => T_('Contact'),
						'title'  => T_('Send a message to the owner of this blog...'),
					) );
				// Display a link to help page:
				$Blog->help_link( array(
						'before'      => ' ',
						'after'       => ' ',
						'text'        => T_('Help'),
					) );
			?>

			<?php
				// Display additional credits:
				// If you can add your own credits without removing the defaults, you'll be very cool :))
				// Please leave this at the bottom of the page to make sure your blog gets listed on b2evolution.net
				credits( array(
						'list_start'  => '&bull;',
						'list_end'    => ' ',
						'separator'   => '&bull;',
						'item_start'  => ' ',
						'item_end'    => ' ',
					) );
			?>
		</p>

		<?php
			// Please help us promote b2evolution and leave this logo on your blog:
			powered_by( array(
					'block_start' => '<div class="powered_by">',
					'block_end'   => '</div>',
					// Check /rsc/img/ for other possible images -- Don't forget to change or remove width & height too
					'img_url'     => '$rsc$img/powered-by-b2evolution-120t.gif',
					'img_width'   => 120,
					'img_height'  => 32,
				) );
		?>
		
	</div><!-- .col -->
	
</div><!-- .row -->
</footer><!-- .skin-footer-single -->

</div><!-- .container -->

<script>
/**
 * The idea of disp=single is to have fixed image on the left of the content
 * and relative (scrollable) content on the right.
 * 
 * Cover image wrapper gets "position: fixed" when reached --> sticky cover image.
 */
var fixedTop = $('.special-cover-image-wrapper').offset().top;
$(window).scroll(function() {
    var currentScroll = $(window).scrollTop();
    if (currentScroll >= fixedTop) {
        $('.special-cover-image-wrapper').addClass('fixed');
    } else {
        $('.special-cover-image-wrapper').removeClass('fixed');
    }
});

/**
 * On disp=single, clone cover image div height as min-height CSS attribute for content div.
 * This is important because we want to set footer ALWAYS BELOW the main content.
 * Giving min-height to the content allows us to leave blank space below the content if content height < cover image height.
 */
//var cover_img_height = $("#special-cover-image_bg_pos").height();
//document.getElementById('single-post-content-wrapper').setAttribute("style","min-height:" + cover_img_height + "px");

$('#special-cover-image_bg_pos').css("height", $(window).height());
$('#single-post-content-wrapper').css("min-height", $('#special-cover-image_bg_pos').height());
</script>

<?php 
if( in_array( $disp, array( 'single', 'page') ) )
{
	?>
	<script>
		$(window).resize(function() {
			
			if ($(window).width() < 992 ) {
				$('#single-post-content-wrapper').css("min-height", '0');
			} else {
				$('#special-cover-image_bg_pos').height($(window).height());
				$('#single-post-content-wrapper').css("min-height", $('#special-cover-image_bg_pos').height());
			}
			
		});
		$(window).trigger('resize');
		
		
		
		$(document).ready(function ($) {
			$(window).load(function () {
				setTimeout(function(){
					$('#preloader').fadeOut('slow', function () {
					});
				},50); // set the time here
			});  
		});
	</script>
	<?php
}
?>

<?php
// ---------------------------- SITE FOOTER INCLUDED HERE ----------------------------
// If site footers are enabled, they will be included here:
siteskin_include( '_site_body_footer.inc.php' );
// ------------------------------- END OF SITE FOOTER --------------------------------
?>