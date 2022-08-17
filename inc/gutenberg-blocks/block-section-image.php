<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make( __( 'OnePage Image/Icon Section' ) )
	->add_fields( array(
		Field::make( 'text', 'section_title', __( 'Titel' ) ),
		Field::make( 'textarea', 'section_desc', __( 'Beskrivning' ) )
			->set_rows( 4 ),
		Field::make( 'color', 'section_text_colour', __( 'Text färg' ) )
			->set_palette( array( '#F4F4F4', '#464A4E', '#FFFFFF' ) ),
		Field::make( 'color', 'section_background_colour', __( 'Bakgrundsfärg' ) )
			->set_palette( array( '#F4F4F4', '#464A4E', '#FFFFFF' ) ),
		Field::make( 'complex', 'section_images', 'Bilder/Ikoner' )
               ->set_layout( 'tabbed-horizontal' )
               ->add_fields( array(
                   Field::make( 'text', 'skill', __( 'Label' ) ),
				   Field::make( 'text', 'url', __( 'URL' ) )
				   		->set_help_text( 'Wraps the item in the URL' ),
                   Field::make( 'image', 'image', __( 'Bild/Ikon' ) )
				   		->set_value_type( 'url' )
						->set_help_text( 'Accepts .png, .jpg, .svg files' ),
               ) ),
		Field::make( 'text', 'section_image_height', __( 'Bild/Ikon - höjd i pixlar' ) )
			->set_help_text( 'Width is set according to the aspect ratio of the image' ),
	) )
	->set_icon( 'editor-code' )
    ->set_mode( 'both' )
	->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
		$text_colour       = empty($fields['section_text_colour']) ? '#464A4E' : esc_attr( $fields['section_text_colour']);
		$background_colour = empty($fields['section_background_colour']) ? null : esc_attr( $fields['section_background_colour']);
		$title             = empty($fields['section_title']) ? null : esc_html( $fields['section_title'] );
		$desc              = empty($fields['section_desc']) ? null : esc_html( $fields['section_desc'] );
		$images            = empty($fields['section_images']) ? null : $fields['section_images'];
		$height            = empty($fields['section_image_height']) ? '60' : $fields['section_image_height'];
		?>
		<div class="block-container" style="color:<?php echo $text_colour; ?>;background-color:<?php echo $background_colour; ?>;">
			<?php
			if ( $title !== null )  {
				?>
				<h2 style="color:<?php echo $text_colour; ?>">
					<?php echo $title; ?>
				</h2>
				<?php
			}
			if ( $desc !== null ) {
				?>
				<p>
					<?php echo $desc; ?>
				</p>
				<?php
			}
			if ( $images != null ) {
				?>
					<div class="images">
						<?php
						foreach ( $images as $image ) {
							if ( !empty( $image['url'] ) || !empty( $image['skill'] ) || !empty( $image['image'] ) ) {
								$opening_tag = empty($image['url'] ) ? '<div class="image">' : '<a class="image" href="' . $image['url'] . '" target="_blank">';
								$closing_tag = empty($image['url'] ) ? '</div>' : '</a>';
								echo $opening_tag;
									if ( !empty($image['image']) ) {
										echo process_block_image( $image['image'], $height, $text_colour );
									}
									if ( !empty($image['skill'])  ) {
										?>
										<h5 style="color:<?php echo $text_colour; ?>">
											<?php echo esc_html($image['skill']) ?>
										</h5>
										<?php
									}
								echo $closing_tag;
							}
						}
						?>
					</div>
				<?php
			}
			?>
		</div>
		<?php
	} );
?>
