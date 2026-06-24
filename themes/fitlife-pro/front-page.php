<?php get_header(); ?>

<section class="hero-section">
<div class="container">

	<div class="hero-grid">

		<div class="hero-content">

			<h1>
				Transform Your Body,
				Transform Your Life
			</h1>

			<p>
				Expert trainers, personalized fitness
				programs, and proven results to help
				you achieve your goals.
			</p>

			<a
				href="#"
				class="btn-primary"
			>
				Get Started
			</a>

		</div>

		<div class="hero-image">

			<img
				src="https://images.pexels.com/photos/1552242/pexels-photo-1552242.jpeg"
				alt="Fitness Training" loading="lazy"
			>

		</div>

	</div>

</div>
```

</section>

<section class="trainers-section">

```
<div class="container">

	<div class="section-heading">

		<h2>Meet Our Expert Trainers</h2>

		<p>
			Certified fitness professionals dedicated
			to helping you achieve your goals.
		</p>

	</div>

	<div class="trainers-grid">

		<?php

		$query = new WP_Query(
			[
				'post_type'      => 'fitlife_trainer',
				'post_status'    => 'publish',
				'posts_per_page' => 3,
			]
		);

		if ( $query->have_posts() ) :

			while ( $query->have_posts() ) :

				$query->the_post();

				?>

				<div class="trainer-card">

					<?php
					if ( has_post_thumbnail() ) {
						the_post_thumbnail(
							'medium'
						);
					}
					?>

					<h3>
						<?php the_title(); ?>
					</h3>

					<p>
						<strong>Certification:</strong>
						<?php
						echo esc_html(
							get_post_meta(
								get_the_ID(),
								'_fitlife_certification',
								true
							)
						);
						?>
					</p>

					<p>
						<strong>Hourly Rate:</strong>
						₹<?php
						echo esc_html(
							get_post_meta(
								get_the_ID(),
								'_fitlife_hourly_rate',
								true
							)
						);
						?>
					</p>

				</div>

				<?php

			endwhile;

			wp_reset_postdata();

		else :

			?>

			<p>No Trainers Found.</p>

			<?php

		endif;

		?>

	</div>

</div>
```

</section>

<?php get_footer(); ?>
