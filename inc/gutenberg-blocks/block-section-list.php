<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make( __( 'OnePage List Section' ) )
	->add_fields( array(
		Field::make( 'text', 'section_title', __( 'Titel' ) ),
		Field::make( 'textarea', 'section_desc', __( 'Beskrivning' ) )
			->set_rows( 4 ),
		Field::make( 'color', 'section_text_colour', __( 'Text färg' ) )
			->set_palette( array( '#F4F4F4', '#464A4E', '#FFFFFF' ) ),
		Field::make( 'color', 'section_background_colour', __( 'Bakgrundsfärg' ) )
			->set_palette( array( '#F4F4F4', '#464A4E', '#FFFFFF' ) ),
		Field::make( 'radio', 'section_list_style', 'List stil' )
	    ->add_options( array(
			'square' => 'Fyrkant',
        	'circle' => 'Cirkel',
        	'upper-roman' => 'Romersk',
			'lower-alpha' => 'Nummer',
	    ) ),
		Field::make( 'complex', 'section_list', 'Lista' )
               ->set_layout( 'tabbed-horizontal' )
               ->add_fields( array(
                   Field::make( 'textarea', 'list_item', __( 'Punkt' ) )
				   	->set_rows( 2 ),
               ) ),
	) )
	->set_icon( 'editor-code' )
    ->set_mode( 'both' )
	->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
		$text_colour        = empty($fields['section_text_colour']) ? '#464A4E' : esc_attr( $fields['section_text_colour']);
		$background_colour  = empty($fields['section_background_colour']) ? null : esc_attr( $fields['section_background_colour']);
		$title              = empty($fields['section_title']) ? null : esc_html( $fields['section_title'] );
		$desc               = empty($fields['section_desc']) ? null : esc_html( $fields['section_desc'] );
		$section_list_style = empty( $fields['section_list_style'] ) ? 'circle' : esc_html( $fields['section_list_style'] );
		$list_style         = "list-style-type:{$section_list_style}";
		?>
		<div class="block-container" style="color:<?php echo $text_colour; ?>;background-color:<?php echo $background_colour; ?>;">
			<?php
			if ( $title !== null )  {
				?>
				<h2 style="color:<?php echo $text_colour; ?>">
					<?php
					echo $title;
					 ?>
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
			if ( !empty( $fields['section_list'] ) ) {
				?>
				<div class="block-section-list">
					<ul  style="<?php echo $list_style; ?>">
						<?php
						foreach ( $fields['section_list'] as $list_item ) {
							?>
							<li><?php echo esc_html( $list_item['list_item'] ); ?></li>
							<?php
						}
						?>
					</ul>
				</div>
				<?php
			}
			?>
		</div>
		<?php
	} );
?>
