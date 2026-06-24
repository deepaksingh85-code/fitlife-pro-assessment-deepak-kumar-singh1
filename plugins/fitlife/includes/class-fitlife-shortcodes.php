<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class FitLife_Shortcodes {

	public function __construct() {

		add_shortcode(
			'fitlife_trainers',
			[
				$this,
				'trainers_shortcode',
			]
		);

		add_shortcode(
			'fitlife_programs',
			[
				$this,
				'programs_shortcode',
			]
		);
		add_action(
	'save_post_fitlife_trainer',
	[
		$this,
		'clear_trainers_cache',
	]
);

add_action(
	'save_post_fitlife_program',
	[
		$this,
		'clear_programs_cache',
	]
);
	}

	/*
	|--------------------------------------------------------------------------
	| Trainers Shortcode
	|--------------------------------------------------------------------------
	*/

	public function trainers_shortcode(
		$atts
	) {

		ob_start();

		$query = get_transient(
	'fitlife_trainers_cache'
);

if ( false === $query ) {

	$query = new WP_Query(
		[
			'post_type'      => 'fitlife_trainer',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
		]
	);

	set_transient(
		'fitlife_trainers_cache',
		$query,
		12 * HOUR_IN_SECONDS
	);
}

		if ( $query->have_posts() ) {

			echo '<div class="fitlife-grid">';

			while (
				$query->have_posts()
			) {

				$query->the_post();

				?>

			<div class="fitlife-card">

	<?php
	if ( has_post_thumbnail() ) {
		the_post_thumbnail(
	'medium',
	[
		'loading' => 'lazy',
	]
);
	}
	?>

	<h3><?php the_title(); ?></h3>

	<p>
		<strong>Certification:</strong>
		<?php echo esc_html( get_post_meta( get_the_ID(), '_fitlife_certification', true ) ); ?>
	</p>

	<p>
		<strong>Experience:</strong>
		<?php echo esc_html( get_post_meta( get_the_ID(), '_fitlife_experience', true ) ); ?>
		Years
	</p>

	<p>
		<strong>Hourly Rate:</strong>
		₹<?php echo esc_html( get_post_meta( get_the_ID(), '_fitlife_hourly_rate', true ) ); ?>
	</p>

	<?php
	$instagram = get_post_meta(
		get_the_ID(),
		'_fitlife_instagram',
		true
	);

	if ( ! empty( $instagram ) ) :
	?>
		<p>
			<a href="<?php echo esc_url( $instagram ); ?>" target="_blank">
				Instagram Profile
			</a>
		</p>
	<?php endif; ?>

	<?php
	$youtube = get_post_meta(
		get_the_ID(),
		'_fitlife_youtube',
		true
	);

	if ( ! empty( $youtube ) ) :
	?>
		<p>
			<a href="<?php echo esc_url( $youtube ); ?>" target="_blank">
				YouTube Channel
			</a>
		</p>
	<?php endif; ?>

</div>

				<?php
			}

			echo '</div>';

		} else {

			echo '<p>No trainers found.</p>';
		}

		wp_reset_postdata();

		return ob_get_clean();
	}

	/*
	|--------------------------------------------------------------------------
	| Programs Shortcode
	|--------------------------------------------------------------------------
	*/

	public function programs_shortcode(
		$atts
	) {

		$atts = shortcode_atts(
			[
				'type' => '',
			],
			$atts
		);

		$args = [
			'post_type'      => 'fitlife_program',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
		];

		if (
			! empty(
				$atts['type']
			)
		) {

			$args['tax_query'] = [
				[
					'taxonomy' => 'program_type',
					'field'    => 'slug',
					'terms'    => $atts['type'],
				],
			];
		}

		ob_start();

		$query = get_transient(
	'fitlife_programs_cache'
);

if ( false === $query ) {

	$query = new WP_Query(
		$args
	);

	set_transient(
		'fitlife_programs_cache',
		$query,
		12 * HOUR_IN_SECONDS
	);
}
		if ( $query->have_posts() ) {

			echo '<div class="fitlife-grid">';

			while (
				$query->have_posts()
			) {

				$query->the_post();

				?>

				<div class="fitlife-card">

					<h3>
						<?php the_title(); ?>
					</h3>

					<p>
						Duration:
						<?php
						echo esc_html(
							get_post_meta(
								get_the_ID(),
								'_fitlife_duration',
								true
							)
						);
						?>
						Weeks
					</p>

				</div>

				<?php
			}

			echo '</div>';

		} else {

			echo '<p>No programs found.</p>';
		}

		wp_reset_postdata();

		return ob_get_clean();
	}


public function clear_trainers_cache() {

	delete_transient(
		'fitlife_trainers_cache'
	);
}

public function clear_programs_cache() {

	delete_transient(
		'fitlife_programs_cache'
	);
}}