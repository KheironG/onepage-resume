<?php
use Carbon_Fields\Container;
use Carbon_Fields\Field;
use Carbon_Fields\Block;
use SVG\SVG;
use enshrined\svgSanitize\Sanitizer;

class OnePage_Resume_Carbon_Fields {

    public function __construct() {
		add_action( 'after_setup_theme',  array( $this, 'load_carbon_fields' ) );
        add_action( 'carbon_fields_register_fields', array( $this, 'register_carbon_fields' ) );
        if ( is_admin() ) {
            add_filter( 'upload_mimes',  array( $this, 'allow_svg_icon_upload' ) );
            add_filter( 'wp_handle_upload_prefilter', array( $this, 'sanitize_svg' ) );
        }
	}

    function sanitize_svg( $file ) {
        if ( $file['type'] === 'image/svg+xml' || $file['type'] === 'application/svg+xml' ) {
            $sanitizer = new Sanitizer();
            $sanitizer->minify(true);
            $SVG = file_get_contents( $file['tmp_name'] );
            $cleanSVG = $sanitizer->sanitize($SVG);
            if ( $cleanSVG === false ) {
                $file['error'] = "SVG sanitation failed.";
            } else {
                file_put_contents( $file['tmp_name'], $cleanSVG );
            }
        }
        return $file;
    }


    function load_carbon_fields() {
        require_once( get_template_directory() . '/vendor/autoload.php' );
        \Carbon_Fields\Carbon_Fields::boot();
    }


    function allow_svg_icon_upload ( $mime_types = array() ) {
        $mime_types['svg'] = 'image/svg+xml';
        return $mime_types;
    }

    function register_carbon_fields() {

        Container::make( 'term_meta', __( 'Size Properties' ) )
            ->where( 'term_taxonomy', '=', 'gallery_sizes' )
            ->add_fields( array(
                 Field::make( 'text', 'width' )->set_required( true )->set_width( 50 )->set_help_text( 'in cm' ),
                 Field::make( 'text', 'height' )->set_required( true )->set_width( 50 )->set_help_text( 'in cm' ),
                 Field::make( 'text', 'aspect_ratio' )->set_width( 50 ),
                 Field::make( 'text', 'low_quality' )->set_required( true )->set_width( 50 )->set_help_text( 'required DPI' ),
                 Field::make( 'text', 'medium_quality' )->set_required( true )->set_width( 50 )->set_help_text( 'required DPI' ),
                 Field::make( 'text', 'high_quality' )->set_required( true )->set_width( 50 )->set_help_text( 'required DPI' ),
            ) );

        Container::make( 'post_meta', __( 'Portolio Dev Icons' ) )
            ->where( 'post_type', '=', 'post' )
            ->set_context( 'side' )
            ->add_fields( array(
                Field::make( 'complex', 'section_images', 'Icons' )
                       ->set_layout( 'tabbed-horizontal' )
                       ->add_fields( array(
                           Field::make( 'image', 'icon', __( 'Icon' ) )
        				   		->set_value_type( 'url' )
                       ) ),
        		Field::make( 'text', 'section_icon_height', __( 'Icon height' ) )
        			->set_help_text( 'Width is set according to the aspect ratio of the image' )#
            ) );

        function process_block_image( $src, $height, $colour ) {
            $path = pathinfo( $src );
            if ( $path['extension'] === 'svg' ) {
                $image = SVG::fromFile( $src );
                $doc = $image->getDocument();
                $doc->setAttribute('height', $height);
                $doc->setStyle('fill', $colour);
                echo $image;
            } else {
                ?>
                <img src="<?php echo esc_attr($src); ?>" style="height:<?php echo $height ?>px;width:auto;" alt="">
                <?php
            }
        }

        //Gutenberg Blocks
        require_once( get_template_directory() . '/inc/gutenberg-blocks/block-header.php' );
        require_once( get_template_directory() . '/inc/gutenberg-blocks/block-section-image.php' );
        require_once( get_template_directory() . '/inc/gutenberg-blocks/block-section-list.php' );
        require_once( get_template_directory() . '/inc/gutenberg-blocks/block-portfolio.php' );
        require_once( get_template_directory() . '/inc/gutenberg-blocks/block-contact.php' );

    }

}
?>
