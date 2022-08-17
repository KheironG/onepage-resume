<?php
class OnePage_Resume_Ajax
{

    function __construct()
    {
        add_action( 'wp_enqueue_scripts',  array( $this, 'onepage_resume_ajax' ) );
        add_action( 'wp_ajax_onepage_resume_ajax',  array( $this, 'onepage_resume_ajax_cb' ) );
        add_action( 'wp_ajax_nopriv_onepage_resume_ajax',  array( $this, 'onepage_resume_ajax_cb' ) );
    }

    function onepage_resume_ajax( ) {
        wp_enqueue_script( 'onepage-resume-ajax',
            get_template_directory_uri() . '/static/all.js',
            []
        );
        wp_localize_script( 'onepage-resume-ajax',
            'onepage_ajax',
            array(
                'ajax_url'         => admin_url( 'admin-ajax.php' ),
                'nonce'            => wp_create_nonce('onepage-ajax-nonce'),
        ));
    }

    function onepage_resume_ajax_cb() {

        $data    = trim( file_get_contents("php://input") );
        $decoded = json_decode( $data, true );
        $nonce   = $decoded['nonce'];
        $error   = '';

        if ( ! wp_verify_nonce( $nonce, 'onepage-ajax-nonce' ) ) {
            $error = 'general';
            echo json_encode( $error );
            exit;
        }

        $name    = sanitize_text_field( $decoded['name'] );
        $email   = sanitize_email( $decoded['email'] );
        $subject = sanitize_text_field( $decoded['subject'] );
        $message = sanitize_textarea_field( $decoded['message'] );

        if ( empty( $email ) || !is_email( $email ) ) {
            $error = 'email';
            echo json_encode( $error );
            exit;
        }

        if ( empty( $message ) || ctype_space( $message ) ) {
            $error = 'message';
            echo json_encode( $error );
            exit;
        }

        $to = get_bloginfo('admin_email');
        $headers[] = 'From: '. $name .' <'.$email.'>';
        $headers[] = 'Content-Type: text/html; charset=UTF-8';
        $headers[] = 'Reply-To: '.$name.' <'.$email.'>';

        $send_email = wp_mail( $to, $subject, $message, $headers );

        if ( $send_email === false ) {
            $error = 'general';
            echo json_encode( $error );
            exit;
        }

        echo json_encode($send_email);
        exit;

    }

}

?>
