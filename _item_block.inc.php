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
		'feature_block'              => false,
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
		
		// By default, this skin does not display comments, unless chosen in the b-o of the skin
		'display_comments_bool'      => false,
		
		// Control the layout depending on existance of cover image in post
		'post_before'                => '',
		'post_after'                 => '',
	), $params );
	
/**
 * Prepare boolean value depending on the result set by the user
 * We use this to enable/disable comments in the back-office of the skin
 */
if( $Skin->get_setting('post_comments') )
{
	$params['display_comments_bool'] = true;
}

/**
 * What goes before post, depending on disp and number of cover images in the post
 */
if( in_array( $disp, array( 'single', 'page') ) && $Item->get_number_of_images( $image_position = 'cover' ) > 0 )
{
	$params['post_before'] = '<div class="row">';
}
if( in_array( $disp, array( 'single', 'page') ) && $Item->get_number_of_images( $image_position = 'cover' ) < 1 )
{
	$params['post_before'] = '<div class="row"><div class="container">';
	$params['post_after']  = '</div>';
}

/**
 * Select cover image background position for disp=single and disp=page
 */
$cover_pos_single = 'cover_center';
if( $Skin->get_setting( 'cover_pos_single' ) == 'cover_top' )
{
	$cover_pos_single = 'cover_top';
} elseif( $Skin->get_setting( 'cover_pos_single' ) == 'cover_bottom' )
{
	$cover_pos_single = 'cover_bottom';
}

/**
 * Select cover image background position for disp=posts
 */
$cover_pos_posts = 'cover_center';
if( $Skin->get_setting( 'cover_pos_posts' ) == 'cover_top' )
{
	$cover_pos_posts = 'cover_top';
} elseif( $Skin->get_setting( 'cover_pos_posts' ) == 'cover_bottom' )
{
	$cover_pos_posts = 'cover_bottom';
}

/**
 * Select cover image background position for disp=posts
 */
$cover_link_posts = '<a href="' . $Item->get_permanent_url() . '">';
if( $Skin->get_setting( 'cover_link_posts' ) == 'link_to_image' )
{
	$cover_link_posts = '<a href="' . $Item->get_cover_image_url() . '" rel="lightbox[p' . $Item->ID . ']" id="link_' . $Item->ID . '" class="cboxElement">';
}


echo $params['post_before'] . '<div class="evo_content_block">'; // Beginning of post display
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
				echo $cover_link_posts . '<figure class="posts-cover-image ' . $cover_pos_posts . '" style="background-image:url(' . $Item->get_cover_image_url() . ');"></figure></a>';
				
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
		 * Display cover images on disp single left of the content - special miniblog layout
		 */
		if( $disp == 'single' || $disp == 'page' )
		{
			// If there is AT LEAST ONE cover image
			if( $Item->get_number_of_images( $image_position = 'cover' ) > 0 ) {
				echo '<div class="col-md-6 special-cover-image-wrapper">';
						
					echo '
					<a href="' . $Item->get_cover_image_url() . '" rel="lightbox[p' . $Item->ID . ']" id="link_' . $Item->ID . '" class="cboxElement">
						<figure id="special-cover-image_bg_pos" class="' . $cover_pos_single . '" style="background-image:url(' . $Item->get_cover_image_url() . ');"></figure>
					</a>';
				
				echo '<div class="clearfix"></div></div>';
				
				echo '<div class="col-md-6 col-md-offset-6" id="single-post-content-wrapper">';
				
			// If there are NO cover images in this post, place post content centered of the page
			} else {
				echo '<div class="single-no-cover-img-wrapper">';
			}
			
			
			// ------------------------- MESSAGES GENERATED FROM ACTIONS -------------------------
			messages( array(
					'block_start' => '<div class="action_messages">',
					'block_end'   => '</div>',
				) );
			// --------------------------------- END OF MESSAGES ---------------------------------
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
	if( $disp == 'single' || $disp == 'page' )
	{
		// ------------------------- "Item Single" CONTAINER EMBEDDED HERE --------------------------
		// Display container contents:
		skin_container( /* TRANS: Widget container name */ NT_('Item Single'), array(
			'widget_context' => 'item',	// Signal that we are displaying within an Item
			// The following (optional) params will be used as defaults for widgets included in this container:
			'container_display_if_empty' => false, // If no widget, don't display container at all
			'container_start' => '<div class="evo_container $wico_class$">',
			'container_end'   => '</div>',
			// This will enclose each widget in a block:
			'block_start' => '<div class="evo_widget $wi_class$">',
			'block_end' => '</div>',
			// This will enclose the title of each widget:
			'block_title_start' => '<h3>',
			'block_title_end' => '</h3>',
			// Template params for "Item Tags" widget
			'widget_item_tags_before'    => '<div class="post_tags">',
			'widget_item_tags_separator' => '',
			'widget_item_tags_before_list'    => '',
			'widget_item_tags_after'     => '</div>',
			// Params for skin file "_item_content.inc.php"
			'widget_item_content_params' => array (
				'image_limit'              => 1000,
				'gallery_image_limit'      => 5,
				
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

		<?php
		if( ! $Item->is_intro() && $disp != 'single' && $disp != 'page' ) // Do NOT apply tags, commentcomments and feedback on intro posts AND on disp=single
		{ // List all tags attached to this post:
			echo '<footer>';
				if( $Skin->get_setting( 'post_tags' ) ) {
				$Item->tags( array(
						'before'    => '<nav class="small post_tags">',
						'after'     => '</nav>',
						'separator' => ' ',
					) );
				}
		?>

		<?php
			if( $params['display_comments_bool'] ) {
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
		
			echo '</footer>';
		}
		?>
	
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
				'disp_comments'          => $params['display_comments_bool'],
				'disp_comment_form'      => $params['display_comments_bool'],
				'disp_trackbacks'        => $params['display_comments_bool'],
				'disp_trackback_url'     => $params['display_comments_bool'],
				'disp_pingbacks'         => $params['display_comments_bool'],
				'disp_meta_comments'     => false,
				'disp_section_title'     => $params['display_comments_bool'],
				'disp_meta_comment_info' => $params['display_comments_bool'],
				'disp_rating_summary'    => $params['display_comments_bool'],
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
	if( evo_version_compare( $app_version, '6.7' ) >= 0 && $params['display_comments_bool'] )
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

<?php echo '</div>' . $params['post_after']; // End of post display ?>
