<?php
 /**
  * Handles Carbon fields and blocks
  *
  */
 require_once( get_template_directory() . '/inc/OnePage_Resume_Carbon_Fields.php' );
 new OnePage_Resume_Carbon_Fields();


/**
 * Registers styles and scripts
 *
 */
require_once( get_template_directory() . '/inc/OnePage_Resume_Styles_Scripts.php' );
new OnePage_Resume_Styles_Scripts();


/**
 * Ajax handler and callback
 *
 */
require_once( get_template_directory() . '/inc/OnePage_Resume_Ajax.php' );
new OnePage_Resume_Ajax();

add_theme_support( 'post-thumbnails' );
?>
