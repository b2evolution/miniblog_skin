<?php
/**
 * This file implements a class derived of the generic Skin class in order to provide custom code for
 * the skin in this folder.
 *
 * This file is part of the b2evolution project - {@link http://b2evolution.net/}
 *
 * @package skins
 * @subpackage bootstrap_blog
 */
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

/**
 * Specific code for this skin.
 *
 * ATTENTION: if you make a new skin you have to change the class name below accordingly
 */
class miniblog_Skin extends Skin
{
	/**
	 * Skin version
	 * @var string
	 */
	var $version = '0.1';

	/**
	 * Do we want to use style.min.css instead of style.css ?
	 */
	var $use_min_css = 'check';  // true|false|'check' Set this to true for better optimization
	// Note: we leave this on "check" in the bootstrap_blog_skin so it's easier for beginners to just delete the .min.css file
	// But for best performance, you should set it to true.

	/**
	 * Get default name for the skin.
	 * Note: the admin can customize it.
	 */
	function get_default_name()
	{
		return 'Miniblog Skin';
	}


	/**
	 * Get default type for the skin.
	 */
	function get_default_type()
	{
		return 'normal';
	}


	/**
	 * What evoSkins API does has this skin been designed with?
	 *
	 * This determines where we get the fallback templates from (skins_fallback_v*)
	 * (allows to use new markup in new b2evolution versions)
	 */
	function get_api_version()
	{
		return 6;
	}


	/**
	 * Get supported collection kinds.
	 *
	 * This should be overloaded in skins.
	 *
	 * For each kind the answer could be:
	 * - 'yes' : this skin does support that collection kind (the result will be was is expected)
	 * - 'partial' : this skin is not a primary choice for this collection kind (but still produces an output that makes sense)
	 * - 'maybe' : this skin has not been tested with this collection kind
	 * - 'no' : this skin does not support that collection kind (the result would not be what is expected)
	 * There may be more possible answers in the future...
	 */
	public function get_supported_coll_kinds()
	{
		$supported_kinds = array(
				'main' => 'partial',
				'std' => 'yes',		// Blog
				'photo' => 'no',
				'forum' => 'no',
				'manual' => 'no',
				'group' => 'maybe',  // Tracker
				// Any kind that is not listed should be considered as "maybe" supported
			);

		return $supported_kinds;
	}


	/*
	 * What CSS framework does has this skin been designed with?
	 *
	 * This may impact default markup returned by Skin::get_template() for example
	 */
	function get_css_framework()
	{
		return 'bootstrap';
	}


	/**
	 * Get definitions for editable params
	 *
	 * @see Plugin::GetDefaultSettings()
	 * @param local params like 'for_editing' => true
	 * @return array
	 */
	function get_param_definitions( $params )
	{
		$r = array_merge( array(
				'section_layout_start' => array(
					'layout' => 'begin_fieldset',
					'label'  => T_('Layout Settings')
				),
					// 'layout' => array(
						// 'label' => T_('Layout'),
						// 'note' => '',
						// 'defaultvalue' => 'single_column',
						// 'options' => array(
								// 'single_column'              => T_('Single Column Large'),
								// 'single_column_normal'       => T_('Single Column'),
								// 'single_column_narrow'       => T_('Single Column Narrow'),
								// 'single_column_extra_narrow' => T_('Single Column Extra Narrow'),
							// ),
						// 'type' => 'select',
					// ),
					'max_image_height' => array(
						'label' => T_('Max image height'),
						'note' => 'px',
						'defaultvalue' => '',
						'type' => 'integer',
						'allow_empty' => true,
					),
				'section_layout_end' => array(
					'layout' => 'end_fieldset',
				),
				

				'section_color_start' => array(
					'layout' => 'begin_fieldset',
					'label'  => T_('Custom Settings')
				),
					'page_bg_color' => array(
						'label' => T_('Background color'),
						'note' => T_('E-g: #ff0000 for red'),
						'defaultvalue' => '#fff',
						'type' => 'color',
					),
					'page_text_color' => array(
						'label' => T_('Text color'),
						'note' => T_('E-g: #00ff00 for green'),
						'defaultvalue' => '#333',
						'type' => 'color',
					),
					'page_link_color' => array(
						'label' => T_('Link color'),
						'note' => T_('E-g: #00ff00 for green'),
						'defaultvalue' => '#3b434a',
						'type' => 'color',
					),
					'page_hover_link_color' => array(
						'label' => T_('Hover link color'),
						'note' => T_('E-g: #00ff00 for green'),
						'defaultvalue' => '#3b434a',
						'type' => 'color',
					),
					'bgimg_text_color' => array(
						'label' => T_('Text color on background image'),
						'note' => T_('E-g: #00ff00 for green'),
						'defaultvalue' => '#fff',
						'type' => 'color',
					),
					'bgimg_link_color' => array(
						'label' => T_('Link color on background image'),
						'note' => T_('E-g: #00ff00 for green'),
						'defaultvalue' => '#6cb2ef',
						'type' => 'color',
					),
					'bgimg_hover_link_color' => array(
						'label' => T_('Hover link color on background image'),
						'note' => T_('E-g: #00ff00 for green'),
						'defaultvalue' => '#6cb2ef',
						'type' => 'color',
					),
					'post_comments' => array(
						'label' => T_('Post Comments'),
						'note' => T_('Check to enable post comments on posts page and single pages.'),
						'defaultvalue' => 0,
						'type' => 'checkbox',
					),
					'post_tags' => array(
						'label' => T_('Post Tags'),
						'note' => T_('Check to enable post tags.'),
						'defaultvalue' => 1,
						'type' => 'checkbox',
					),
					'post_tags' => array(
						'label' => T_('Post Tags'),
						'note' => T_('Check to enable post tags.'),
						'defaultvalue' => 1,
						'type' => 'checkbox',
					),
				'section_color_end' => array(
					'layout' => 'end_fieldset',
				),
				
				
				'section_header_start' => array(
					'layout' => 'begin_fieldset',
					'label'  => T_('Header Settings')
				),
					'display_header' => array(
						'label' => T_('Display header section'),
						'note' => T_('Check to display the header section on all pages, except the single posts and single pages.'),
						'defaultvalue' => 1,
						'type' => 'checkbox',
					),
					'header_bg_file_ID' => array(
						'label' => T_('Upload logo'),
						'note' => T_('If you upload your logo here, it will be shown in navigation menu instead of collection title.'),
						'type' => 'fileselect',
						'initialize_with' => 'shared/global/sunset/sunset.jpg',
						'thumbnail_size' => 'fit-320x320',
					),
					'header_bg_color' => array(
						'label' => T_('Background color'),
						'note' => T_('Background color will be used if there is no background image.') . ' ' . T_('Default value is') . ' <code>#444444</code>.',
						'defaultvalue' => '#444444',
						'type' => 'color',
					),
					'header_text_color' => array(
						'label' => T_('Text color'),
						'note' => T_('Default value is') . ' <code>#ffffff</code>.',
						'defaultvalue' => '#ffffff',
						'type' => 'color',
					),
					'header_links_color' => array(
						'label' => T_('Links color'),
						'note' => T_('Default value is') . ' <code>#e8e8e8</code>.',
						'defaultvalue' => '#e8e8e8',
						'type' => 'color',
					),
				'section_header_end' => array(
					'layout' => 'end_fieldset',
				),
				
				
				'section_nav_start' => array(
					'layout' => 'begin_fieldset',
					'label'  => T_('Menu Settings')
				),
					'nav_bg_color' => array(
						'label' => T_('Background color'),
						'note' => T_('Set the background color of menu section.') . T_('Default color is') . ' <code>#333333</code>.',
						'defaultvalue' => '#333333',
						'type' => 'color',
					),
					'nav_text_color' => array(
						'label' => T_('Text color'),
						'note' => T_('Set the text color of menu section.') . T_('Default color is') . ' <code>#eeeeee</code>.',
						'defaultvalue' => '#eeeeee',
						'type' => 'color',
					),
					'nav_link_color' => array(
						'label' => T_('Menu links color'),
						'note' => T_('Set the color of menu links.') . T_('Default color is') . ' <code>#eeeeee</code>.',
						'defaultvalue' => '#fefefe',
						'type' => 'color',
					),
					'nav_logo_file_ID' => array(
						'label' => T_('Upload logo'),
						'note' => T_('If you upload your logo here, it will be shown in navigation menu instead of collection title.'),
						'type' => 'fileselect',
						'initialize_with' => 'shared/global/sunset/sunset.jpg',
						'thumbnail_size' => 'fit-320x320',
					),
				'section_nav_end' => array(
					'layout' => 'end_fieldset',
				),
				
				
				'section_posts_start' => array(
					'layout' => 'begin_fieldset',
					'label'  => T_('Posts Page Settings')
				),
					'cover_image_height' => array(
						'label' => T_('Cover image height'),
						'note' => 'px (' . T_('input numbers only') . ').' . T_('Set height for cover images shown on posts page.') . T_( 'Default value is') . ' <code>200</code>.',
						'defaultvalue' => '200',
						'type' => 'integer',
						'size' => '7',
						// 'allow_empty' => true,
					),
					'cover_pos_posts' => array(
						'label' => T_('Cover image position'),
						'note' => T_('Select the position of the cover image that will be shown on single page.'),
						'defaultvalue' => 'cover_center',
						'options' => array(
								'cover_top'       => T_('Top'),
								'cover_center'    => T_('Center'),
								'cover_bottom'    => T_('Bottom'),
							),
						'type' => 'select',
					),
				   'cover_link_posts' => array(
					  'label'    => T_('Cover image link'),
					  'note'     => ' (' . T_('Decide whether you want the cover image to link to the post or to the image') . ')',
					  'type'     => 'radio',
					  'options'  => array(
						 array( 'link_to_post', T_('Link to post') ),
						 array( 'link_to_image', T_('Link to image') ),
					  ),
					  'defaultvalue' => 'link_to_post',
				   ),
				'section_posts_end' => array(
					'layout' => 'end_fieldset',
				),
				
				
				'section_single_start' => array(
					'layout' => 'begin_fieldset',
					'label'  => T_('Single Page Settings')
				),
					'cover_pos_single' => array(
						'label' => T_('Cover image position'),
						'note' => T_('Select the position of the cover image that will be shown on single page.'),
						'defaultvalue' => 'cover_center',
						'options' => array(
								'cover_top'       => T_('Top'),
								'cover_center'    => T_('Center'),
								'cover_bottom'    => T_('Bottom'),
							),
						'type' => 'select',
					),
				'section_single_end' => array(
					'layout' => 'end_fieldset',
				),
				
				
				'section_footer_start' => array(
					'layout' => 'begin_fieldset',
					'label'  => T_('Footer Settings')
				),
					'footer_background_color' => array(
						'label' => T_('Background color'),
						'note' => T_('E-g: #00ff00 for green'),
						'defaultvalue' => '#333',
						'type' => 'color',
					),
					'footer_text_color' => array(
						'label' => T_('Text color'),
						'note' => T_('E-g: #00ff00 for green'),
						'defaultvalue' => '#fff',
						'type' => 'color',
					),
					'footer_link_color' => array(
						'label' => T_('Links color'),
						'note' => T_('E-g: #00ff00 for green'),
						'defaultvalue' => '#e8e8e8',
						'type' => 'color',
					),
				'section_footer_end' => array(
					'layout' => 'end_fieldset',
				),


				'section_colorbox_start' => array(
					'layout' => 'begin_fieldset',
					'label'  => T_('Colorbox Image Zoom')
				),
					'colorbox' => array(
						'label' => T_('Colorbox Image Zoom'),
						'note' => T_('Check to enable javascript zooming on images (using the colorbox script)'),
						'defaultvalue' => 1,
						'type' => 'checkbox',
					),
					'colorbox_vote_post' => array(
						'label' => T_('Voting on Post Images'),
						'note' => T_('Check this to enable AJAX voting buttons in the colorbox zoom view'),
						'defaultvalue' => 1,
						'type' => 'checkbox',
					),
					'colorbox_vote_post_numbers' => array(
						'label' => T_('Display Votes'),
						'note' => T_('Check to display number of likes and dislikes'),
						'defaultvalue' => 1,
						'type' => 'checkbox',
					),
					'colorbox_vote_comment' => array(
						'label' => T_('Voting on Comment Images'),
						'note' => T_('Check this to enable AJAX voting buttons in the colorbox zoom view'),
						'defaultvalue' => 1,
						'type' => 'checkbox',
					),
					'colorbox_vote_comment_numbers' => array(
						'label' => T_('Display Votes'),
						'note' => T_('Check to display number of likes and dislikes'),
						'defaultvalue' => 1,
						'type' => 'checkbox',
					),
					'colorbox_vote_user' => array(
						'label' => T_('Voting on User Images'),
						'note' => T_('Check this to enable AJAX voting buttons in the colorbox zoom view'),
						'defaultvalue' => 1,
						'type' => 'checkbox',
					),
					'colorbox_vote_user_numbers' => array(
						'label' => T_('Display Votes'),
						'note' => T_('Check to display number of likes and dislikes'),
						'defaultvalue' => 1,
						'type' => 'checkbox',
					),
				'section_colorbox_end' => array(
					'layout' => 'end_fieldset',
				),


				'section_username_start' => array(
					'layout' => 'begin_fieldset',
					'label'  => T_('Username options')
				),
					'gender_colored' => array(
						'label' => T_('Display gender'),
						'note' => T_('Use colored usernames to differentiate men & women.'),
						'defaultvalue' => 0,
						'type' => 'checkbox',
					),
					'bubbletip' => array(
						'label' => T_('Username bubble tips'),
						'note' => T_('Check to enable bubble tips on usernames'),
						'defaultvalue' => 0,
						'type' => 'checkbox',
					),
					'autocomplete_usernames' => array(
						'label' => T_('Autocomplete usernames'),
						'note' => T_('Check to enable auto-completion of usernames entered after a "@" sign in the comment forms'),
						'defaultvalue' => 1,
						'type' => 'checkbox',
					),
				'section_username_end' => array(
					'layout' => 'end_fieldset',
				),


				'section_access_start' => array(
					'layout' => 'begin_fieldset',
					'label'  => T_('When access is denied or requires login...')
				),
					'access_login_containers' => array(
						'label' => T_('Display on login screen'),
						'note' => '',
						'type' => 'checklist',
						'options' => array(
							array( 'header',   sprintf( T_('"%s" container'), NT_('Header') ),    1 ),
							array( 'page_top', sprintf( T_('"%s" container'), NT_('Page Top') ),  1 ),
							array( 'menu',     sprintf( T_('"%s" container'), NT_('Menu') ),      0 ),
							array( 'footer',   sprintf( T_('"%s" container'), NT_('Footer') ),    1 ) ),
						),
				'section_access_end' => array(
					'layout' => 'end_fieldset',
				),

			), parent::get_param_definitions( $params ) );

		return $r;
	}


	/**
	 * Get ready for displaying the skin.
	 *
	 * This may register some CSS or JS...
	 */
	function display_init()
	{
		global $Messages, $disp, $debug;

		// Request some common features that the parent function (Skin::display_init()) knows how to provide:
		parent::display_init( array(
				'jquery',                  // Load jQuery
				'font_awesome',            // Load Font Awesome (and use its icons as a priority over the Bootstrap glyphicons)
				'bootstrap',               // Load Bootstrap (without 'bootstrap_theme_css')
				'bootstrap_evo_css',       // Load the b2evo_base styles for Bootstrap (instead of the old b2evo_base styles)
				'bootstrap_messages',      // Initialize $Messages Class to use Bootstrap styles
				'style_css',               // Load the style.css file of the current skin
				'colorbox',                // Load Colorbox (a lightweight Lightbox alternative + customizations for b2evo)
				'bootstrap_init_tooltips', // Inline JS to init Bootstrap tooltips (E.g. on comment form for allowed file extensions)
				'disp_auto',               // Automatically include additional CSS and/or JS required by certain disps (replace with 'disp_off' to disable this)
			) );
		
		add_headline( '<link href="https://fonts.googleapis.com/css?family=PT+Sans:400,400i,700" rel="stylesheet">' );

		// Skin specific initializations:
		global $media_url, $media_path;

		// Add custom CSS:
		$custom_css = '';

		if( $color = $this->get_setting( 'page_bg_color' ) )
		{ // Custom page background color:
			$custom_css .= '#skin_wrapper { background-color: '.$color." }\n";
			$custom_css .= '.pagination li.active a, .pagination li.active span, .evo_panel__login .panel-heading, .evo_panel__lostpass .panel-heading, .evo_panel__register .panel-heading, .evo_panel__activation .panel-heading, div.compact_search_form .input-group-btn input, .results .panel-heading, .results .panel-footer, .main_disp_mediaidx h2, .detail_msgform main h2, .main_disp_sitemap h2, .fieldset_wrapper .panel-heading, .results .panel-heading a:hover, .main_disp_profile > h2, .main_disp_avatar > h2, .main_disp_pwdchange > h2, .main_disp_userprefs > h2, .main_disp_subs > h2, .main_disp_comments > h2, .evo_comment .panel-heading, .evo_comment .panel-heading a, .evo_comment .panel-heading .panel-title a, .disp_single .panel-heading, .disp_page .panel-heading, .main_disp_arcdir > h2, .main_disp_catdir > h2, .main_disp_tags > h2, .main_disp_search > h2, .main_disp_search .search_submit, .search_result_score, .disp_help main > h2 { color: '.$color." }\n";
		}
		if( $color = $this->get_setting( 'page_text_color' ) )
		{ // Custom page text color:
			$custom_css .= '#skin_wrapper { color: '.$color." }\n";
		}
		if( $color = $this->get_setting( 'page_link_color' ) )
		{ // Custom page link color:
			$custom_css .= 'a { color: '.$color." }\n";
			$custom_css .= '.evo_panel__login .panel-heading, .evo_panel__lostpass .panel-heading, .evo_panel__register .panel-heading, .evo_panel__activation .panel-heading, div.compact_search_form .input-group-btn input, div.compact_search_form .input-group-btn input:hover, .results .panel-heading, .results .panel-footer, .main_disp_mediaidx h2, .detail_msgform main h2, .main_disp_sitemap h2, .fieldset_wrapper .panel-heading, .main_disp_profile > h2, .main_disp_avatar > h2, .main_disp_pwdchange > h2, .main_disp_userprefs > h2, .main_disp_subs > h2, .main_disp_comments > h2, .evo_comment .panel-heading, .disp_single .panel-heading, .disp_page .panel-heading, .main_disp_arcdir > h2, .main_disp_catdir > h2, .main_disp_tags > h2, .main_disp_search > h2, .main_disp_search .search_submit, .search_result_score, .disp_help main > h2 { background-color: '.$color." }\n";
			$custom_css .= '#login_form input:focus:invalid:focus, #login_form select:focus:invalid:focus, #login_form textarea:focus:invalid:focus, .form-control:focus, .controls input.form-control.form_text_input:focus, div.compact_search_form .input-group-btn input, .main_disp_search .search_submit { border-color: '.$color." }\n";
			$custom_css .= '.pagination li:not(.active) a, .pagination li:not(.active) span { color: '.$color." !important }\n";
			$custom_css .= '.pagination li.active a, .pagination li.active span { background-color: '.$color.' !important; border-color: '.$color." }\n";
			if( $this->get_setting( 'gender_colored' ) !== 1 )
			{ // If gender option is not enabled, choose custom link color. Otherwise, chose gender link colors:
				$custom_css .= 'h4.panel-title a { color: '.$color." }\n";
			}
		}
		if( $color = $this->get_setting( 'page_hover_link_color' ) )
		{ // Custom page link color on hover:
			$custom_css .= 'a:hover { color: '.$color." }\n";
		}
		if( $color = $this->get_setting( 'bgimg_text_color' ) )
		{	// Custom text color on background image:
			$custom_css .= '.evo_hasbgimg { color: '.$color." }\n";
		}
		if( $color = $this->get_setting( 'bgimg_link_color' ) )
		{	// Custom link color on background image:
			$custom_css .= '.evo_hasbgimg a { color: '.$color." }\n";
		}
		if( $color = $this->get_setting( 'bgimg_hover_link_color' ) )
		{	// Custom link hover color on background image:
			$custom_css .= '.evo_hasbgimg a:hover { color: '.$color." }\n";
		}
		
		
		if( ! in_array( $disp, array( 'single', 'page') ) ) {
			// Display Logo only if it is set through customization option
			$FileCache = & get_FileCache();
			$header_bg_file = NULL;
			if( $header_bg_file_ID = $this->get_setting( 'header_bg_file_ID' ) )
			{
				$header_bg_file = & $FileCache->get_by_ID( $header_bg_file_ID, false, false );
			}
			if( ! empty( $header_bg_file ) && $header_bg_file->exists() )
			{
				$custom_css .= '.evo_container__header { background-image: url(' . $header_bg_file->get_url() . ") }\n";
			} else
			{
				$custom_css .= '.evo_container__header { background-color: ' . $this->get_setting( 'header_bg_color' ) . " }\n";
			}
			// Custom "header" section text color
			if( $color = $this->get_setting( 'header_text_color' ) )
			{
				$custom_css .= '.evo_container__header { color: '.$color." }\n";
			}
			// Custom "header" section links color
			if( $color = $this->get_setting( 'header_links_color' ) )
			{
				$custom_css .= '.evo_container__header a:not([class*="ufld_"]) { color: '.$color." }\n";
			}
		}
		
		
		if( $color = $this->get_setting( 'nav_bg_color' ) )
		{ // Custom current tab text color:
			$custom_css .= '.navbar { background-color: '.$color." }\n";
		}
		if( $color = $this->get_setting( 'nav_text_color' ) )
		{ // Custom current tab text color:
			$custom_css .= '.navbar { color: '.$color." }\n";
		}
		if( $color = $this->get_setting( 'nav_link_color' ) )
		{ // Custom current tab text color:
			$custom_css .= '.navbar ul.nav li a, .navbar-header a { color: '.$color." }\n";
			$custom_css .= '.navbar-toggle span { background-color: '.$color." }\n";
		}
		
		
		if( in_array( $disp, array( 'single', 'page') ) )
		{
			$custom_css .= "#special-cover-image_bg_pos { background-position: 50% 50%; }\n";
		}
		
		if( $height = $this->get_setting( 'cover_image_height' ) )
		{
			$custom_css .= '.posts-cover-image, .no-cover-image-container { height: ' . $height . "px }\n";
		}
		

		// Limit images by max height:
		$max_image_height = intval( $this->get_setting( 'max_image_height' ) );
		if( $max_image_height > 0 )
		{
			$custom_css .= '.evo_image_block img { max-height: '.$max_image_height.'px; width: auto; }'." }\n";
		}
		
		if( $color = $this->get_setting( 'footer_background_color' ) )
		{ // Custom footer background color:
			$custom_css .= '.skin-footer-single, .evo_container__footer a.btn.btn-default { background-color: '.$color." }\n";
		}
		if( $color = $this->get_setting( 'footer_text_color' ) )
		{ // Custom footer text color:
			$custom_css .= '.skin-footer-single, .skin-footer-content, .skin-footer-content .evo_widget { color: '.$color." }\n";
		}
		if( $color = $this->get_setting( 'footer_link_color' ) )
		{ // Custom footer text color:
			$custom_css .= '.skin-footer-single a:not([class*="ufld_"]), .skin-footer-content a:not([class*="ufld_"]), .skin-footer-content .evo_widget a:not([class*="ufld_"]) { color: '.$color." }\n";
		}

		if( ! empty( $custom_css ) )
		{	// Function for custom_css:
			$custom_css = '<style type="text/css">
<!--
'.$custom_css.'
-->
		</style>';
			add_headline( $custom_css );
		}
	}


	/**
	 * Check if we can display a widget container
	 *
	 * @param string Widget container key: 'header', 'page_top', 'menu', 'sidebar', 'sidebar2', 'footer'
	 * @return boolean TRUE to display
	 */
	function is_visible_container( $container_key )
	{
		global $Blog;

		if( $Blog->has_access() )
		{	// If current user has an access to this collection then don't restrict containers:
			return true;
		}

		// Get what containers are available for this skin when access is denied or requires login:
		$access = $this->get_setting( 'access_login_containers' );

		return ( ! empty( $access ) && ! empty( $access[ $container_key ] ) );
	}
}
?>