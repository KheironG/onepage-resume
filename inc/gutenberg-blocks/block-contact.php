<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make( __( 'Onepage Contact' ) )
	->add_fields( array(
		Field::make( 'text', 'section_title', __( 'Titel' ) ),
		Field::make( 'textarea', 'section_desc', __( 'Beskrivning' ) )
			->set_rows( 4 )
	) )
	->set_icon( 'editor-code' )
    ->set_mode( 'both' )
	->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
		$title = empty($fields['section_title']) ? null : esc_html( $fields['section_title'] );
		$desc  = empty($fields['section_desc']) ? null : esc_html( $fields['section_desc'] );
		?>
		<div class="block-background-pattern">
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
			?>
			<form id="contact">
				<div>
					<label for="name"><?php echo __( 'Namn' ) ?></label>
					<input id="name" type="text" name="name" value="">
				</div>
				<div>
					<label for="email"><?php echo __( 'Epost' ) ?></label>
					<input id="email" type="email" name="email" value="" required>
					<span class="hidden error-message">Var god ange e-post</span>
				</div>
				<div>
					<label for="subject"><?php echo __( 'Ämne' ) ?></label>
					<input id="subject" type="text" name="subject" value="">
				</div>
				<div>
					<label for="message"><?php echo __( 'Meddelande' ) ?></label>
					<textarea id="message" name="message" required></textarea>
					<span class="hidden error-message">Var god skriv ett meddelande</span>
				</div>
				<span class="hidden error-message">Var god försök igen</span>
				<button id="button" type="button" onclick="contactForm()">
					<?php echo __( 'Skicka' ) ?>
				</button>
				<div id="loader" class="lds-roller hidden"><div></div><div></div><div></div><div></div><div></div><div></div><div></div><div></div></div>
			</form>
		</div>
		<?php
	} );
?>
