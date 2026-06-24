<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class FitLife_Blocks {

	public function __construct() {

		add_action(
			'init',
			[
				$this,
				'register_blocks',
			]
		);
	}

	/*
	Register Blocks
	*/

	public function register_blocks() {

		register_block_type(
			FITLIFE_PLUGIN_PATH . 'blocks/program-highlight'
		);

		register_block_type(
			FITLIFE_PLUGIN_PATH . 'blocks/trainer-spotlight',
			[
				'render_callback' => [
					$this,
					'render_trainer_spotlight',
				],
			]
		);
	}

	/*
	Dynamic Trainer Spotlight Block
	*/

	public function render_trainer_spotlight(
		$attributes
	) {

		$trainer_id =
			$attributes['trainerId']
			?? 0;

		if ( ! $trainer_id ) {
			return '';
		}

		$image =
			get_the_post_thumbnail(
				$trainer_id,
				'medium'
			);

		$name =
			get_the_title(
				$trainer_id
			);

		$speciality =
			get_post_meta(
				$trainer_id,
				'_fitlife_certification',
				true
			);

		$experience =
			get_post_meta(
				$trainer_id,
				'_fitlife_experience',
				true
			);

		ob_start();
		?>

```
	<div class="trainer-spotlight-card">

		<?php echo $image; ?>

		<h3>
			<?php echo esc_html( $name ); ?>
		</h3>

		<p>
			<strong>Certification:</strong>
			<?php echo esc_html( $speciality ); ?>
		</p>

		<p>
			<strong>Experience:</strong>
			<?php echo esc_html( $experience ); ?>
			Years
		</p>

		<a
			href="#"
			class="button"
		>
			Book Now
		</a>

	</div>

	<?php

	return ob_get_clean();
}

}
