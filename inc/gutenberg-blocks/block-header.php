<?php
use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make( __( 'Onepage Header' ) )
	->add_fields( array(
		Field::make( 'text', 'header_title', __( 'Yrkestitel' ) ),
		Field::make( 'text', 'header_name', __( 'Namn' ) ),
		Field::make( 'image', 'header_portrait', __( 'Porträtt' ) )
			->set_value_type( 'url' )
	) )
	->set_icon( 'editor-code' )
    ->set_mode( 'both' )
	->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
		$name = empty($fields['header_name']) ? null : esc_html( $fields['header_name'] );
		$title = empty($fields['header_title']) ? null : esc_html( $fields['header_title'] );
		$portrait = empty($fields['header_portrait']) ? null : esc_attr( $fields['header_portrait'] );
		?>
		<header>
			<div class="content">
				<div>
					<h1 class="name">
						<?php echo $name; ?>
					</h1>
					<h1 class="title">
						<?php echo $title; ?>
					</h1>
				</div>
				<img src="<?php echo $portrait; ?>">
			</div>
		</header>
		<?php
	} );
?>
