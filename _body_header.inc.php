<?php
/**
* This is the BODY header include template.
*
* For a quick explanation of b2evo 2.0 skins, please start here:
* {@link http://b2evolution.net/man/skin-development-primer}
*
* This is meant to be included in a page template.
*
* @package evoskins
*/
if( !defined('EVO_MAIN_INIT') ) die( 'Please, do not access this page directly.' );

// ---------------------------- SITE HEADER INCLUDED HERE ----------------------------
// If site headers are enabled, they will be included here:
siteskin_include( '_site_body_header.inc.php' );
// ------------------------------- END OF SITE HEADER --------------------------------

?>
<header class="container-fluid">

<div class="row">
<nav class="navbar">
  <div class="container">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
		<?php
		// Display Logo only if it is set through customization option
		global $baseurl;
		$FileCache = & get_FileCache();
		$logo_File = NULL;
		if( $logo_File_ID = $Skin->get_setting( 'nav_logo_file_ID' ) )
		{
			$logo_File = & $FileCache->get_by_ID( $logo_File_ID, false, false );
		}
		if( ! empty( $logo_File ) && $logo_File->exists() )
		{ // If it exists in media folder ?>
			<div class="navbar-brand navbar-logo">
				<h1>
					<a href="<?php echo $baseurl; ?>"><img class="miniblog_skin_logo" src="<?php echo $logo_File->get_url(); ?>" /></a>
				</h1>
			</div>
		<?php } else {
			skin_widget( array(
				// CODE for the widget:
				'widget'              => 'coll_title',
				// Optional display params
				'block_start'         => '<div class="navbar-brand">',
				'block_end'           => '</div>',
			) );
		}
		?>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right">
		<?php
			// ------------------------- "Menu" CONTAINER EMBEDDED HERE --------------------------
			// Display container and contents:
			// Note: this container is designed to be a single <ul> list
			skin_container( NT_('Menu'), array(
					// The following params will be used as defaults for widgets included in this container:
					'block_start'         => '',
					'block_end'           => '',
					'block_display_title' => false,
					'list_start'          => '',
					'list_end'            => '',
					'item_start'          => '<li class="evo_widget $wi_class$">',
					'item_end'            => '</li>',
					'item_selected_start' => '<li class="active evo_widget $wi_class$">',
					'item_selected_end'   => '</li>',
					'item_title_before'   => '',
					'item_title_after'    => '',
				) );
			// ----------------------------- END OF "Menu" CONTAINER -----------------------------
		?>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

</div>
</header><!-- .row -->
