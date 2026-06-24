<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class FitLife_REST_API {

	public function __construct() {

		add_action(
			'rest_api_init',
			[
				$this,
				'register_routes',
			]
		);
	}

	/*
	|--------------------------------------------------------------------------
	| Register Routes
	|--------------------------------------------------------------------------
	*/

	public function register_routes() {

		register_rest_route(
			'fitlife/v1',
			'/trainers',
			[
				'methods'  => WP_REST_Server::READABLE,
				'callback' => [
					$this,
					'get_trainers',
				],
				'permission_callback' => '__return_true',
			]
		);

		register_rest_route(
			'fitlife/v1',
			'/programs',
			[
				'methods'  => WP_REST_Server::READABLE,
				'callback' => [
					$this,
					'get_programs',
				],
				'permission_callback' => '__return_true',
			]
		);

		register_rest_route(
			'fitlife/v1',
			'/programs',
			[
				'methods'  => WP_REST_Server::CREATABLE,
				'callback' => [
					$this,
					'create_program',
				],
				'permission_callback' => [
					$this,
					'can_create_program',
				],
			]
		);
	}

	/*
	|--------------------------------------------------------------------------
	| Permissions
	|--------------------------------------------------------------------------
	*/

	public function can_create_program() {

		return current_user_can(
			'edit_posts'
		);
	}

	/*
	|--------------------------------------------------------------------------
	| GET Trainers
	|--------------------------------------------------------------------------
	*/

	public function get_trainers(
		$request
	) {

		$specialty =
			$request->get_param(
				'specialty'
			);

		$args = [
			'post_type'      => 'fitlife_trainer',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
		];

		if ( ! empty( $specialty ) ) {

			$args['tax_query'] = [
				[
					'taxonomy' => 'specialty',
					'field'    => 'slug',
					'terms'    => $specialty,
				],
			];
		}

		$query = new WP_Query(
			$args
		);

		$data = [];

		while (
			$query->have_posts()
		) {

			$query->the_post();

			$data[] = [
				'id'            => get_the_ID(),
				'title'         => get_the_title(),
				'content'       => get_the_content(),
				'certification' => get_post_meta(
					get_the_ID(),
					'_fitlife_certification',
					true
				),
				'experience'    => get_post_meta(
					get_the_ID(),
					'_fitlife_experience',
					true
				),
				'instagram'     => get_post_meta(
					get_the_ID(),
					'_fitlife_instagram',
					true
				),
				'youtube'       => get_post_meta(
					get_the_ID(),
					'_fitlife_youtube',
					true
				),
				'hourly_rate'   => get_post_meta(
					get_the_ID(),
					'_fitlife_hourly_rate',
					true
				),
			];
		}

		wp_reset_postdata();

		return rest_ensure_response(
			$data
		);
	}

	/*
	|--------------------------------------------------------------------------
	| GET Programs
	|--------------------------------------------------------------------------
	*/

	public function get_programs(
		$request
	) {

		$type = $request->get_param(
			'type'
		);

		$difficulty =
			$request->get_param(
				'difficulty'
			);

		$args = [
			'post_type'      => 'fitlife_program',
			'post_status'    => 'publish',
			'posts_per_page' => -1,
		];

		if ( ! empty( $type ) ) {

			$args['tax_query'][] = [
				'taxonomy' => 'program_type',
				'field'    => 'slug',
				'terms'    => $type,
			];
		}

		if ( ! empty( $difficulty ) ) {

			$args['meta_query'][] = [
				'key'   => '_fitlife_difficulty',
				'value' => $difficulty,
			];
		}

		$query = new WP_Query(
			$args
		);

		$data = [];

		while (
			$query->have_posts()
		) {

			$query->the_post();

			$data[] = [
				'id'           => get_the_ID(),
				'title'        => get_the_title(),
				'content'      => get_the_content(),
				'duration'     => get_post_meta(
					get_the_ID(),
					'_fitlife_duration',
					true
				),
				'difficulty'   => get_post_meta(
					get_the_ID(),
					'_fitlife_difficulty',
					true
				),
				'equipment'    => get_post_meta(
					get_the_ID(),
					'_fitlife_equipment',
					true
				),
				'participants' => get_post_meta(
					get_the_ID(),
					'_fitlife_max_participants',
					true
				),
			];
		}

		wp_reset_postdata();

		return rest_ensure_response(
			$data
		);
	}

	/*
	|--------------------------------------------------------------------------
	| POST Program
	|--------------------------------------------------------------------------
	*/

	public function create_program(
		$request
	) {

		$title = sanitize_text_field(
			$request->get_param(
				'title'
			)
		);

		if ( empty( $title ) ) {

			return new WP_Error(
				'missing_title',
				'Program title is required.',
				[
					'status' => 400,
				]
			);
		}

		$post_id = wp_insert_post(
			[
				'post_title'  => $title,
				'post_type'   => 'fitlife_program',
				'post_status' => 'publish',
			]
		);

		return rest_ensure_response(
			[
				'success' => true,
				'post_id' => $post_id,
				'message' => 'Program created successfully.',
			]
		);
	}
}