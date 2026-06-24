<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class FitLife_Meta_Boxes {

	public function __construct() {

		add_action(
			'add_meta_boxes',
			[
				$this,
				'register_meta_boxes',
			]
		);

		add_action(
			'save_post',
			[
				$this,
				'save_meta_boxes',
			]
		);
	}

	/*
	Register Meta Boxes
	*/

	public function register_meta_boxes() {

		add_meta_box(
			'fitlife_trainer_details',
			'Trainer Details',
			[
				$this,
				'trainer_meta_box',
			],
			'fitlife_trainer',
			'normal',
			'default'
		);

		add_meta_box(
			'fitlife_program_details',
			'Program Details',
			[
				$this,
				'program_meta_box',
			],
			'fitlife_program',
			'normal',
			'default'
		);
	}

	/*
    Trainer Meta Box
	*/

	public function trainer_meta_box( $post ) {

		wp_nonce_field(
			'fitlife_meta_nonce',
			'fitlife_meta_nonce'
		);

		$certification = get_post_meta(
			$post->ID,
			'_fitlife_certification',
			true
		);

		$experience = get_post_meta(
			$post->ID,
			'_fitlife_experience',
			true
		);

		$instagram = get_post_meta(
			$post->ID,
			'_fitlife_instagram',
			true
		);

		$youtube = get_post_meta(
			$post->ID,
			'_fitlife_youtube',
			true
		);

		$hourly_rate = get_post_meta(
			$post->ID,
			'_fitlife_hourly_rate',
			true
		);

		?>

		<p>
			<label><strong>Certification</strong></label>
			<input
				type="text"
				name="fitlife_certification"
				value="<?php echo esc_attr( $certification ); ?>"
				class="widefat"
			>
		</p>

		<p>
			<label><strong>Years of Experience</strong></label>
			<input
				type="number"
				name="fitlife_experience"
				value="<?php echo esc_attr( $experience ); ?>"
				class="widefat"
			>
		</p>

		<p>
			<label><strong>Instagram URL</strong></label>
			<input
				type="url"
				name="fitlife_instagram"
				value="<?php echo esc_attr( $instagram ); ?>"
				class="widefat"
			>
		</p>

		<p>
			<label><strong>YouTube URL</strong></label>
			<input
				type="url"
				name="fitlife_youtube"
				value="<?php echo esc_attr( $youtube ); ?>"
				class="widefat"
			>
		</p>

		<p>
			<label><strong>Hourly Rate</strong></label>
			<input
				type="number"
				name="fitlife_hourly_rate"
				value="<?php echo esc_attr( $hourly_rate ); ?>"
				class="widefat"
			>
		</p>

		<?php
	}

	/*
	Program Meta Box
	*/

	public function program_meta_box( $post ) {

		$duration = get_post_meta(
			$post->ID,
			'_fitlife_duration',
			true
		);

		$difficulty = get_post_meta(
			$post->ID,
			'_fitlife_difficulty',
			true
		);

		$equipment = get_post_meta(
			$post->ID,
			'_fitlife_equipment',
			true
		);

		$participants = get_post_meta(
			$post->ID,
			'_fitlife_max_participants',
			true
		);

		?>

		<p>
			<label><strong>Duration (Weeks)</strong></label>
			<input
				type="number"
				name="fitlife_duration"
				value="<?php echo esc_attr( $duration ); ?>"
				class="widefat"
			>
		</p>

		<p>
			<label><strong>Difficulty Level</strong></label>

			<select
				name="fitlife_difficulty"
				class="widefat"
			>

				<option value="Beginner" <?php selected( $difficulty, 'Beginner' ); ?>>
					Beginner
				</option>

				<option value="Intermediate" <?php selected( $difficulty, 'Intermediate' ); ?>>
					Intermediate
				</option>

				<option value="Advanced" <?php selected( $difficulty, 'Advanced' ); ?>>
					Advanced
				</option>

			</select>
		</p>

		<p>
			<label><strong>Equipment Required</strong></label>
			<input
				type="text"
				name="fitlife_equipment"
				value="<?php echo esc_attr( $equipment ); ?>"
				class="widefat"
			>
		</p>

		<p>
			<label><strong>Maximum Participants</strong></label>
			<input
				type="number"
				name="fitlife_max_participants"
				value="<?php echo esc_attr( $participants ); ?>"
				class="widefat"
			>
		</p>

		<?php
	}

	/*
	ave Meta Boxes
	*/

	public function save_meta_boxes(
		$post_id
	) {

		if (
			! isset(
				$_POST['fitlife_meta_nonce']
			)
		) {
			return;
		}

		if (
			! wp_verify_nonce(
				$_POST['fitlife_meta_nonce'],
				'fitlife_meta_nonce'
			)
		) {
			return;
		}

		if (
			defined( 'DOING_AUTOSAVE' )
			&& DOING_AUTOSAVE
		) {
			return;
		}

		update_post_meta(
			$post_id,
			'_fitlife_certification',
			sanitize_text_field(
				$_POST['fitlife_certification'] ?? ''
			)
		);

		update_post_meta(
			$post_id,
			'_fitlife_experience',
			absint(
				$_POST['fitlife_experience'] ?? 0
			)
		);

		update_post_meta(
			$post_id,
			'_fitlife_instagram',
			esc_url_raw(
				$_POST['fitlife_instagram'] ?? ''
			)
		);

		update_post_meta(
			$post_id,
			'_fitlife_youtube',
			esc_url_raw(
				$_POST['fitlife_youtube'] ?? ''
			)
		);

		update_post_meta(
			$post_id,
			'_fitlife_hourly_rate',
			floatval(
				$_POST['fitlife_hourly_rate'] ?? 0
			)
		);

		update_post_meta(
			$post_id,
			'_fitlife_duration',
			absint(
				$_POST['fitlife_duration'] ?? 0
			)
		);

		update_post_meta(
			$post_id,
			'_fitlife_difficulty',
			sanitize_text_field(
				$_POST['fitlife_difficulty'] ?? ''
			)
		);

		update_post_meta(
			$post_id,
			'_fitlife_equipment',
			sanitize_text_field(
				$_POST['fitlife_equipment'] ?? ''
			)
		);

		update_post_meta(
			$post_id,
			'_fitlife_max_participants',
			absint(
				$_POST['fitlife_max_participants'] ?? 0
			)
		);
	}
}