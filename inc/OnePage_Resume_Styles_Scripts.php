<?php
class OnePage_Resume_Styles_Scripts {

    function __construct() {
        add_action( 'wp_enqueue_scripts',  array( $this, 'enq_frontend_scripts' ) );
        add_action( 'admin_enqueue_scripts',  array( $this, 'enq_admin_scripts' ) );
    }


    function enq_frontend_scripts() {
        wp_enqueue_style(
			"onepage-resume-frontend-CSS",
			get_template_directory_uri() . '/static/frontend-style.css',
			[],
			"1.0",
			'all'
		);

        wp_enqueue_script( 'onepage-javascript-script',
            get_template_directory_uri() . '/static/all.js',
            []
        );

    }


    function enq_admin_scripts() {
        wp_enqueue_style(
            "onepage-resume-admin-css",
            get_template_directory_uri() . '/static/admin-style.css',
            array(),
            "1.0",
            "all"
        );
    }

}
?>
