		<h2 class="section-title">Our Partners</h2>
		<div class="container partners">
			<?php
			// Outputting the slideshow
				$partnerArg = array(
					'post_type' => 'partner'
				);
				$partner = new WP_Query($partnerArg);
			?>
			<div class="partners-slide">
				<?php
					while($partner->have_posts()) :
						$partner->the_post();
				?>
					<div class="partner">
						<?php the_post_thumbnail( 'logo-slide' ); ?>
					</div>
			<?php
				endwhile; //end of partners while loop
			wp_reset_postdata();
			?>
		</div><!-- .container -->