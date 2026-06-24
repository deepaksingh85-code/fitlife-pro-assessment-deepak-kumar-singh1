<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class FitLife_CPT {

	public function __construct() {

		add_action(
			'init',
			[
				$this,
				'register_post_types',
			]
		);

		add_action(
			'init',
			[
				$this,
				'register_taxonomies',
			]
		);
	}

	public function register_post_types() {

		register_post_type(
			'fitlife_trainer',
			[
				'labels' => [
					'name'          => 'Trainers',
					'singular_name' => 'Trainer',
				],
				'public'       => true,
				'show_in_rest' => true,
				'menu_icon'    => 'dashicons-groups',
				'supports'     => [
					'title',
					'editor',
					'thumbnail',
				],
				'has_archive'  => true,
			]
		);

		register_post_type(
			'fitlife_program',
			[
				'labels' => [
					'name'          => 'Programs',
					'singular_name' => 'Program',
				],
				'public'       => true,
				'show_in_rest' => true,
				'menu_icon'    => 'dashicons-heart',
				'supports'     => [
					'title',
					'editor',
					'thumbnail',
				],
				'has_archive'  => true,
			]
		);
	}

	public function register_taxonomies() {

		register_taxonomy(
			'specialty',
			'fitlife_trainer',
			[
				'label'        => 'Specialties',
				'public'       => true,
				'hierarchical' => true,
				'show_in_rest' => true,
			]
		);

		register_taxonomy(
			'program_type',
			'fitlife_program',
			[
				'label'        => 'Program Types',
				'public'       => true,
				'hierarchical' => true,
				'show_in_rest' => true,
			]
		);
	}
}