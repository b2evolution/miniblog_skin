<?php
/**
 * This is the template that displays the item block: title, author, content (sub-template), tags, comments (sub-template)
 *
 * This file is not meant to be called directly.
 * It is meant to be called by an include in the main.page.php template (or other templates)
 *
 * b2evolution - {@link http://b2evolution.net/}
 * Released under GNU GPL License - {@link http://b2evolution.net/about/gnu-gpl-license}
 * @copyright (c)2003-2016 by Francois Planque - {@link http://fplanque.com/}
 *
 * @package evoskins
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

global $Item, $Skin, $app_version;

global $File;

// Default params:
$params = array_merge( array(
		'feature_block'              => false,			// fp>yura: what is this for??
		// Classes for the <article> tag:
		'item_class'                 => 'evo_post evo_content_block',
		'item_type_class'            => 'evo_post__ptyp_',
		'item_status_class'          => 'evo_post__',
		'item_style'                 => '',
		// Controlling the title:
		'disp_title'                 => true,
		'item_title_line_before'     => '<div class="evo_post_title">',	// Note: we use an extra class because it facilitates styling
			'item_title_before'          => '<h2>',	
			'item_title_after'           => '</h2>',
			'item_title_single_before'   => '<h1>',	// This replaces the above in case of disp=single or disp=page
			'item_title_single_after'    => '</h1>',
		'item_title_line_after'      => '</div>',
		// Controlling the content:
		'content_mode'               => 'auto',		// excerpt|full|normal|auto -- auto will auto select depending on $disp-detail
		'image_class'                => 'img-responsive',
		'image_size'                 => 'fit-1280x720',
		'author_link_text'           => 'auto',
	), $params );
	
/**
 * Prepare boolean value depending on the result set by the user
 * We use this to enable/disable comments in the back-office of the skin
 */
$display_comments_bool = false;
if( $Skin->get_setting('post_comments') )
{
	$display_comments_bool = true;
}
/**
 * What goes before post, depending on disp and number of cover images in the post
 */
$post_before = '';
$post_after  = '';
if( $disp ==  'single' && $Item->get_number_of_images( $image_position = 'cover' ) > 0 )
{
	$post_before = '</div></div></div><div class="container-fluid"><div class="row">';
	$post_after  = '';
} if( $disp ==  'single' && $Item->get_number_of_images( $image_position = 'cover' ) < 1 )
{
	$post_before = '<div class="row">';
	$post_after  = '</div>';
}

echo $post_before . '<div class="evo_content_block">'; // Beginning of post display
?>

<article id="<?php $Item->anchor_id() ?>" class="<?php $Item->div_classes( $params ) ?>" lang="<?php $Item->lang() ?>"<?php
	echo empty( $params['item_style'] ) ? '' : ' style="'.format_to_output( $params['item_style'], 'htmlattr' ).'"' ?>>
	
	<?php
		/**
		 * Display cover images on disp posts left of the content - miniblog layout
		 */
		if( $disp == 'posts' && !$Item->is_intro() )
		{ // Display cover images that are linked to this post:
			echo '<div class="col-lg-5 col-md-4 posts-cover-image-block">';
			// If there is AT LEAST ONE cover image
			if( $Item->get_number_of_images( $image_position = 'cover' ) > 0 ) {
				$Item->images( array(
					'before_images'            => '<div class="evo_post_images">',
					'before_image'             => '<div class="evo_post_images"><figure class="evo_image_block">',
					'before_image_legend'      => '<figcaption class="evo_image_legend">',
					'after_image_legend'       => '</figcaption>',
					'after_image'              => '</figure></div>',
					'after_images'             => '</div>',
					'image_class'              => 'img-responsive',
					'image_size'               => 'fit-1280x720',
					'image_limit'              =>  1,
					'image_link_to'            => 'original', // Can be 'original', 'single' or empty

					// We DO NOT want to display galleries here, only one cover image
					'gallery_image_limit'      => 0,
					'gallery_colls'            => 0,

					// We want ONLY cover image to display here
					'restrict_to_image_position' => 'cover',
				) );
				
			// If there are NO cover images in this post, create special div block as a substitute to preserve miniblog layout
			} else {
				echo '<div class="no-cover-image-container"><i class="fa fa-picture-o" aria-hidden="true"></i></div>';
			}
			echo '<div class="clearfix"></div></div>';
			
			echo '<div class="col-lg-7 col-md-8 posts-content-block">';
		}
	?>
	
	<?php
		/**
		 * Display cover images on disp posts left of the content - special miniblog layout
		 */
		if( $disp == 'single' || $disp == 'page' )
		{
			// If there is AT LEAST ONE cover image
			if( $Item->get_number_of_images( $image_position = 'cover' ) > 0 ) {
				echo '<div class="col-md-6 special-cover-image-wrapper">';
				
				// Add cover image depending on the selected back-office option
				if( $Skin->get_setting( 'cover_image_layout' ) == 'default' ||
					$Skin->get_setting( 'cover_image_layout' ) == 'expand_pos' ) {
					$Item->images( array(
						'before_images'            => '<div class="evo_post_images">',
						'before_image'             => '<div class="evo_post_images"><figure class="evo_image_block special-cover-image">',
						'before_image_legend'      => '<figcaption class="evo_image_legend">',
						'after_image_legend'       => '</figcaption>',
						'after_image'              => '</figure></div>',
						'after_images'             => '</div>',
						'image_class'              => 'img-responsive',
						'image_size'               => 'fit-1280x720',
						'image_limit'              =>  1,
						'image_link_to'            => 'original', // Can be 'original', 'single' or empty

						// We DO NOT want to display galleries here, only one cover image
						'gallery_image_limit'      => 0,
						'gallery_colls'            => 0,

						// We want ONLY cover image to display here
						'restrict_to_image_position' => 'cover',
					) );
					
				} else {
					
					/*
						OVO RADI, SAMO MORAS DA POKUPIS POST ID I LINK ID DA STAVIS NA ODGOVARAJUCE MESTO U <a> !!!!!!!
						*/
					echo '
					<a href="' . $Item->get_cover_image_url() . '" rel="lightbox[p' . $Item->ID . ']" class="cboxElement">
						<figure id="special-cover-image_bg_pos" style="background-image:url(' . $Item->get_cover_image_url() . ');"></figure>
					</a>';
				}
				
				echo '<div class="clearfix"></div></div>';
				
				echo '<div class="col-md-6 col-md-offset-6" id="single-post-content-wrapper">';
				
			// If there are NO cover images in this post, place post content centered of the page
			} else {
				echo '<div class="col-lg-12">';
			}
		}
	?>
	
	<header>
	<?php
		$Item->locale_temp_switch(); // Temporarily switch to post locale (useful for multilingual blogs)

		// ------- Title -------
		if( $params['disp_title'] )
		{
			echo $params['item_title_line_before'];

			if( $disp == 'single' || $disp == 'page' )
			{
				$title_before = $params['item_title_single_before'];
				$title_after = $params['item_title_single_after'];
			}
			else
			{
				$title_before = $params['item_title_before'];
				$title_after = $params['item_title_after'];
			}

			// POST TITLE:
			$Item->title( array(
					'before'    => $title_before,
					'after'     => $title_after,
					'link_type' => '#'
				) );

			// EDIT LINK:
			//if( $Item->is_intro() )
			//{ // Display edit link only for intro posts, because for all other posts the link is displayed on the info line.
				$Item->edit_link( array(
							'before' => '<div class="'.button_class( 'group' ).'">',
							'after'  => '</div>',
							'text'   => $Item->is_intro() ? get_icon( 'edit' ).' '.T_('Edit Intro') : '#',
							'class'  => button_class( 'text' ),
						) );
			//}

			echo $params['item_title_line_after'];
		}
	?>
	</header>

	<?php
	if( $disp == 'single' )
	{
		?>
		<div class="evo_container evo_container__item_single">		
		<?php
		// ------------------------- "Item Single" CONTAINER EMBEDDED HERE --------------------------
		// Display container contents:
		skin_container( /* TRANS: Widget container name */ NT_('Item Single'), array(
			'widget_context' => 'item',	// Signal that we are displaying within an Item
			// The following (optional) params will be used as defaults for widgets included in this container:
			// This will enclose each widget in a block:
			'block_start' => '<div class="$wi_class$">',
			'block_end' => '</div>',
			// This will enclose the title of each widget:
			'block_title_start' => '<h3>',
			'block_title_end' => '</h3>',
			// Template params for "Item Tags" widget
			'widget_item_tags_before'    => '<div class="post_tags">',
			'widget_item_tags_separator' => '',
			'widget_item_tags_after'     => '</div>',
			// Params for skin file "_item_content.inc.php"
			'widget_item_content_params' => array (
				'image_limit'              => 0,
				'gallery_image_limit'      => 0,
				
			),
			// Template params for "Item Attachments" widget:
			'widget_item_attachments_params' => array(
					'limit_attach'       => 1000,
					'before'             => '<div class="evo_post_attachments"><h3>'.T_('Attachments').':</h3><ul class="evo_files">',
					'after'              => '</ul></div>',
					'before_attach'      => '<li class="evo_file">',
					'after_attach'       => '</li>',
					'before_attach_size' => ' <span class="evo_file_size">(',
					'after_attach_size'  => ')</span>',
				),
		) );
		// ----------------------------- END OF "Item Single" CONTAINER -----------------------------
		?>
		</div>
		<?php
	}
	else
	{
	// this will create a <section>
		// ---------------------- POST CONTENT INCLUDED HERE ----------------------
		skin_include( '_item_content.inc.php', array(
			'content_mode' => 'excerpt',
		) );
		// Note: You can customize the default item content by copying the generic
		// /skins/_item_content.inc.php file into the current skin folder.
		// -------------------------- END OF POST CONTENT -------------------------
	// this will end a </section>
	}
	?>

	<footer>

		<?php
			if( ! $Item->is_intro() && $disp != 'single' && $disp != 'page' ) // Do NOT apply tags, comments and feedback on intro posts AND on disp=single
			{ // List all tags attached to this post:
				if( $Skin->get_setting( 'post_tags' ) ) {
				$Item->tags( array(
						'before'    => '<nav class="small post_tags">',
						'after'     => '</nav>',
						'separator' => ' ',
					) );
				}
		?>

		<?php
			if( $display_comments_bool == true ) {
			echo '<nav class="post_comments_link">';
			// Link to comments, trackbacks, etc.:
			$Item->feedback_link( array(
							'type' => 'comments',
							'link_before' => '',
							'link_after' => '',
							'link_text_zero' => '#',
							'link_text_one' => '#',
							'link_text_more' => '#',
							'link_title' => '#',
							// fp> WARNING: creates problem on home page: 'link_class' => 'btn btn-default btn-sm',
							// But why do we even have a comment link on the home page ? (only when logged in)
						) );

			// Link to comments, trackbacks, etc.:
			$Item->feedback_link( array(
							'type' => 'trackbacks',
							'link_before' => ' &bull; ',
							'link_after' => '',
							'link_text_zero' => '#',
							'link_text_one' => '#',
							'link_text_more' => '#',
							'link_title' => '#',
						) );
			echo '</nav>';
			}
		?>
		
		<?php } ?>
	</footer>
	
	<?php
	if( $disp == 'posts' ) {
	echo '
	</div><!-- ./col-lg-8 -->
	<div class="clearfix"></div>';
	}
	?>

	<?php
		// ------------------ FEEDBACK (COMMENTS/TRACKBACKS) INCLUDED HERE ------------------
		skin_include( '_item_feedback.inc.php', array_merge( array(
				'before_section_title' => '<div class="clearfix"></div><h3 class="evo_comment__list_title">',
				'after_section_title'  => '</h3>',
				'disp_comments'          => $display_comments_bool,
				'disp_comment_form'      => $display_comments_bool,
				'disp_trackbacks'        => $display_comments_bool,
				'disp_trackback_url'     => $display_comments_bool,
				'disp_pingbacks'         => $display_comments_bool,
				'disp_meta_comments'     => false,
				'disp_section_title'     => $display_comments_bool,
				'disp_meta_comment_info' => $display_comments_bool,
				'disp_rating_summary'    => $display_comments_bool,
			), $params ) );
		// Note: You can customize the default item feedback by copying the generic
		// /skins/_item_feedback.inc.php file into the current skin folder.
		// ---------------------- END OF FEEDBACK (COMMENTS/TRACKBACKS) ---------------------
	?>

	<?php
	if( evo_version_compare( $app_version, '6.7' ) >= 0 )
	{	// We are running at least b2evo 6.7, so we can include this file:
		// ------------------ WORKFLOW PROPERTIES INCLUDED HERE ------------------
		skin_include( '_item_workflow.inc.php' );
		// ---------------------- END OF WORKFLOW PROPERTIES ---------------------
	}
	?>

	<?php
	if( evo_version_compare( $app_version, '6.7' ) >= 0 && $display_comments_bool == true )
	{	// We are running at least b2evo 6.7, so we can include this file:
		// ------------------ META COMMENTS INCLUDED HERE ------------------
		skin_include( '_item_meta_comments.inc.php', array(
				'comment_start'         => '<article class="evo_comment evo_comment__meta panel panel-default">',
				'comment_end'           => '</article>',
			) );
		// ---------------------- END OF META COMMENTS ---------------------
	}
	?>

	<?php
		locale_restore_previous();	// Restore previous locale (Blog locale)
	?>
</article>

<?php echo '</div>' . $post_after; // End of post display ?>
