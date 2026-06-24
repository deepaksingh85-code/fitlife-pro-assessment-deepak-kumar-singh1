<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class FitLife_Walker_Menu extends Walker_Nav_Menu {

	public function start_el(
		&$output,
		$item,
		$depth = 0,
		$args = null,
		$id = 0
	) {

		$classes = empty(
			$item->classes
		)
			? []
			: (array) $item->classes;

		$active =
			in_array(
				'current-menu-item',
				$classes,
				true
			)
			? 'active'
			: '';

		$output .=
			'<li class="' .
			esc_attr( $active ) .
			'">';

		$output .=
			'<a href="' .
			esc_url( $item->url ) .
			'" aria-label="' .
			esc_attr( $item->title ) .
			'">';

		$output .=
			esc_html(
				$item->title
			);

		if (
			in_array(
				'menu-item-has-children',
				$classes,
				true
			)
		) {

			$output .=
				' <span class="dropdown-arrow">▼</span>';
		}

		$output .= '</a>';
	}
}