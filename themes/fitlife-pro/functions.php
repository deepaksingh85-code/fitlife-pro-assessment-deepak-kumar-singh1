<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
Theme Setup
*/

function fitlife_theme_setup() {

	add_theme_support( 'title-tag' );

	add_theme_support( 'post-thumbnails' );
    
	add_theme_support( 'woocommerce' );
	
	add_theme_support(
		'html5',
		[
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		]
	);

	add_theme_support(
		'custom-logo',
		[
			'height'      => 100,
			'width'       => 300,
			'flex-height' => true,
			'flex-width'  => true,
		]
	);

	register_nav_menus(
		[
			'primary-menu' => 'Primary Navigation',
			'footer-menu'  => 'Footer Navigation',
		]
	);
}

add_action(
	'after_setup_theme',
	'fitlife_theme_setup'
);

/*
Sidebar Registration
*/

function fitlife_register_sidebar() {

	register_sidebar(
		[
			'name'          => 'Main Sidebar',
			'id'            => 'main-sidebar',
			'description'   => 'Main Theme Sidebar',
			'before_widget' => '<div class="widget">',
			'after_widget'  => '</div>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		]
	);
}

add_action(
	'widgets_init',
	'fitlife_register_sidebar'
);

/*
Load Walker Class
*/

require_once get_template_directory() .
	'/inc/class-fitlife-walker.php';

/*
Enqueue Assets
*/

function fitlife_enqueue_assets() {

	wp_enqueue_style(
		'fitlife-style',
		get_stylesheet_uri(),
		[],
		'1.0'
	);

	wp_enqueue_style(
		'fitlife-main',
		get_template_directory_uri() .
		'/assets/css/main.css',
		[],
		'1.0'
	);

	wp_enqueue_script(
		'fitlife-main',
		get_template_directory_uri() .
		'/assets/js/main.js',
		[],
		'1.0',
		true
	);
}

add_action(
	'wp_enqueue_scripts',
	'fitlife_enqueue_assets'
);


function fitlife_optimize_queries(
	$query
) {

	if (
		is_admin()
		|| ! $query->is_main_query()
	) {
		return;
	}

	if (
		is_post_type_archive(
			'fitlife_trainer'
		)
	) {

		$query->set(
			'posts_per_page',
			6
		);
	}

	if (
		is_post_type_archive(
			'fitlife_program'
		)
	) {

		$query->set(
			'posts_per_page',
			6
		);
	}
}

add_action(
	'pre_get_posts',
	'fitlife_optimize_queries'
);

add_filter(
	'show_admin_bar',
	'__return_false'
);