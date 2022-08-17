<?php

use Carbon_Fields\Block;
use Carbon_Fields\Field;

Block::make( __( 'OnePage Portfolio' ) )
	->add_fields( array(
		Field::make( 'text', 'section_title', __( 'Titel' ) ),
		Field::make( 'textarea', 'section_desc', __( 'Beskrivning' ) )
			->set_rows( 4 ),
		Field::make( 'color', 'section_text_colour', __( 'Text färg' ) )
			->set_palette( array( '#F4F4F4', '#464A4E', '#FFFFFF' ) ),
		Field::make( 'color', 'section_background_colour', __( 'Bakgrundsfärg' ) )
			->set_palette( array( '#F4F4F4', '#464A4E', '#FFFFFF' ) )
	) )
	->set_icon( 'editor-code' )
    ->set_mode( 'both' )
	->set_render_callback( function ( $fields, $attributes, $inner_blocks ) {
		$text_colour       = empty($fields['section_text_colour']) ? null : esc_attr( $fields['section_text_colour']);
		$background_colour = empty($fields['section_background_colour']) ? null : esc_attr( $fields['section_background_colour']);
		$title             = empty($fields['section_title']) ? null : esc_html( $fields['section_title'] );
		$desc              = empty($fields['section_desc']) ? null : esc_html( $fields['section_desc'] );
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
			?>
			<div id="swipe-container" class="block-portfolio">
				<?php
				$query = new WP_Query( array( 'post_type' => 'post', 'post_status' => 'publish', 'category_name' => 'portfolio', 'order' => 'ASC' ) );
				$count = $query->found_posts;
				if ( $count > 1 ) {
					?>
					<div class="onepage-javascript-slider" >
						<div class="swipe-info show-small-screen">
							swipe
						</div>
						<div class="container">
							<span class="show-small-screen" onclick="getNewIndex(-1)"><i class="fa-solid fa-angle-left fa-1x"></i></span>
							<span class="hide-small-screen" onclick="getNewIndex(-1)"><i class="fa-solid fa-angle-left fa-2x"></i></span>
							<div class="indicators">
								<?php
								for ( $i=0; $i < $count ; $i++ ) {
									$trigger_class = $i == 0 ? 'active' : '' ;
									?>
									<div style="color:<?php echo $text_colour; ?>" class="slider-trigger <?php echo $trigger_class; ?>" onclick="slider()"></div>
									<?php
								}
								?>
							</div>
							<span class="hide-small-screen" onclick="getNewIndex(1)"><i class="fa-solid fa-angle-right fa-2x"></i></span>
							<span class="show-small-screen" onclick="getNewIndex(1)"><i class="fa-solid fa-angle-right fa-1x"></i></span>
						</div>
					</div>
					<?php
				}
				if ( $query->have_posts() ) {
					while ( $query->have_posts() ) {
					    $query->the_post();
						$class = $query->current_post != 0 ? 'hidden' : "" ;
					    ?>
						<div class="portfolio-item <?php echo $class; ?>">
							<div class="content">
								<?php
								$image_url = get_the_post_thumbnail_url();
								if ( $image_url !== false ) {
									$image = getimagesize( $image_url );
									$image_class = $image[0] > $image[1] ? 'landscape' : 'portrait';
									?>
									<img class="<?php echo $image_class; ?>" src="<?php echo esc_attr( $image_url  ); ?>">
									<?php
								}
								?>
								<div>
									<h3 style="color:<?php echo $text_colour; ?>"><?php echo esc_html( get_the_title() ); ?></h3>
									<?php echo esc_html( the_content() ); ?>
								</div>
							</div>
						</div>
						<?php
					}
				}
				wp_reset_postdata();
				?>
			</div>
		</div>
		<script type="text/javascript">
	        (function() {
				document.addEventListener('DOMContentLoaded', () => {
				    const container = document.getElementById('swipe-container');
				    if ( container ) {
				        var touchStart = 0;
				        var touchEnd = 0;
				        container.addEventListener('touchstart', (e) => {
				              touchStart = e.touches[0].clientX;
				        }, false);

				        container.addEventListener('touchend', (e) => {
				            e.preventDefault();
				            touchEnd = e.changedTouches[0].clientX;

				            if ( Math.abs( touchStart - touchEnd ) > 25 ) {
				                let direction;
				                if ( touchEnd > touchStart ) {
				                    direction = -1;
				                } else if ( touchEnd < touchStart) {
				                    direction = 1;
				                }
				                getNewIndex(direction);
				            }
				            return;
				        }, false);
				    }
				});
	        }());
	    </script>
		<?php
	} );
?>
