<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class FitLife_Admin_Columns {

	public function __construct() {

		add_filter(
			'manage_fitlife_trainer_posts_columns',
			[
				$this,
				'trainer_columns',
			]
		);

		add_filter(
			'manage_fitlife_program_posts_columns',
			[
				$this,
				'program_columns',
			]
		);
	}

	public function trainer_columns(
		$columns
	) {

		$columns['specialty'] =
			'Specialty';

		return $columns;
	}

	public function program_columns(
		$columns
	) {

		$columns['program_type'] =
			'Program Type';

		return $columns;
	}
}