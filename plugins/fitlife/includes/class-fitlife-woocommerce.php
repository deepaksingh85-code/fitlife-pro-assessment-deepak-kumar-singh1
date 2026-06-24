<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class FitLife_WooCommerce {

	public function __construct() {

		
    
		add_filter(
			'product_type_selector',
			[
				$this,
				'add_product_type',
			]
		);

		

		add_action(
			'woocommerce_product_options_general_product_data',
			[
				$this,
				'product_fields',
			]
		);

		add_action(
			'woocommerce_process_product_meta',
			[
				$this,
				'save_product_fields',
			]
		);

		add_action(
			'woocommerce_single_product_summary',
			[
				$this,
				'display_product_fields',
			],
			25
		);

		

		add_action(
			'woocommerce_after_order_notes',
			[
				$this,
				'fitness_goal_field',
			]
		);

		add_action(
			'woocommerce_checkout_update_order_meta',
			[
				$this,
				'save_fitness_goal',
			]
		);

		add_action(
			'woocommerce_admin_order_data_after_billing_address',
			[
				$this,
				'display_fitness_goal_admin',
			]
		);

		

		add_action(
			'woocommerce_review_order_before_payment',
			[
				$this,
				'checkout_upsell_product',
			]
		);

		

		add_action(
			'woocommerce_email_order_meta',
			[
				$this,
				'email_fitness_goal',
			],
			10,
			3
		);

        add_action(
	'init',
	[
		$this,
		'my_programs_endpoint',
	]
);

add_filter(
	'woocommerce_account_menu_items',
	[
		$this,
		'add_my_programs_tab',
	]
);

add_action(
	'woocommerce_account_my-programs_endpoint',
	[
		$this,
		'my_programs_content',
	]
);

	}

	public function add_product_type( $types ) {

		$types['fitness_bundle'] =
			'Fitness Bundle';

		return $types;
	}

	public function product_fields() {

		echo '<div class="options_group">';

		woocommerce_wp_text_input(
			[
				'id'    => '_calorie_count',
				'label' => 'Calorie Count',
			]
		);

		woocommerce_wp_text_input(
			[
				'id'    => '_protein_per_serving',
				'label' => 'Protein Per Serving',
			]
		);

		woocommerce_wp_textarea_input(
			[
				'id'    => '_allergen_info',
				'label' => 'Allergen Info',
			]
		);

		echo '</div>';
	}

	public function save_product_fields(
		$product_id
	) {

		update_post_meta(
			$product_id,
			'_calorie_count',
			sanitize_text_field(
				$_POST['_calorie_count'] ?? ''
			)
		);

		update_post_meta(
			$product_id,
			'_protein_per_serving',
			sanitize_text_field(
				$_POST['_protein_per_serving'] ?? ''
			)
		);

		update_post_meta(
			$product_id,
			'_allergen_info',
			sanitize_textarea_field(
				$_POST['_allergen_info'] ?? ''
			)
		);
	}

	public function display_product_fields() {

		global $product;

		echo '<div class="fitlife-product-info">';

		echo '<p><strong>Calorie Count:</strong> '
			. esc_html(
				get_post_meta(
					$product->get_id(),
					'_calorie_count',
					true
				)
			)
			. '</p>';

		echo '<p><strong>Protein Per Serving:</strong> '
			. esc_html(
				get_post_meta(
					$product->get_id(),
					'_protein_per_serving',
					true
				)
			)
			. 'g</p>';

		echo '<p><strong>Allergen Info:</strong> '
			. esc_html(
				get_post_meta(
					$product->get_id(),
					'_allergen_info',
					true
				)
			)
			. '</p>';

		echo '</div>';
	}

	public function fitness_goal_field(
		$checkout
	) {

		echo '<h3>Fitness Information</h3>';

		woocommerce_form_field(
			'fitness_goal',
			[
				'type'     => 'select',
				'label'    => 'Fitness Goal',
				'required' => true,
				'class'    => [
					'form-row-wide',
				],
				'options'  => [
					''             => 'Select Goal',
					'weight_loss'  => 'Weight Loss',
					'muscle_gain'  => 'Muscle Gain',
					'endurance'    => 'Endurance',
					'flexibility'  => 'Flexibility',
				],
			],
			$checkout->get_value(
				'fitness_goal'
			)
		);
	}

	public function save_fitness_goal(
		$order_id
	) {

		if (
			isset(
				$_POST['fitness_goal']
			)
		) {

			update_post_meta(
				$order_id,
				'_fitness_goal',
				sanitize_text_field(
					$_POST['fitness_goal']
				)
			);
		}
	}

	public function display_fitness_goal_admin(
		$order
	) {

		$goal = get_post_meta(
			$order->get_id(),
			'_fitness_goal',
			true
		);

		if ( $goal ) {

			echo '<p><strong>Fitness Goal:</strong> '
				. esc_html(
					ucwords(
						str_replace(
							'_',
							' ',
							$goal
						)
					)
				)
				. '</p>';
		}
	}

	public function checkout_upsell_product() {

		echo '<div class="fitlife-upsell">';

		echo '<h3>Recommended Product</h3>';

		echo '<p>Add a Yoga Mat to improve your fitness journey.</p>';

		echo '</div>';
	}
public function my_programs_endpoint() {

	add_rewrite_endpoint(
		'my-programs',
		EP_ROOT | EP_PAGES
	);
}

public function add_my_programs_tab(
	$items
) {

	$items['my-programs'] =
		'My Programs';

	return $items;
}
public function my_programs_content() {

	echo '<h2>My Programs</h2>';

	$orders = wc_get_orders(
		[
			'customer_id' =>
				get_current_user_id(),
			'status' =>
				'completed',
		]
	);

	if ( empty( $orders ) ) {

		echo '<p>No programs purchased yet.</p>';

		return;
	}

	echo '<ul>';

	foreach (
		$orders as $order
	) {

		foreach (
			$order->get_items()
			as $item
		) {

			echo '<li>'
				. esc_html(
					$item->get_name()
				)
				. '</li>';
		}
	}

	echo '</ul>';
}
	public function email_fitness_goal(
		$order,
		$sent_to_admin,
		$plain_text
	) {

		$goal = get_post_meta(
			$order->get_id(),
			'_fitness_goal',
			true
		);

		if ( ! $goal ) {
			return;
		}

		echo '<h2>Fitness Goal</h2>';

		echo '<p>'
			. esc_html(
				ucwords(
					str_replace(
						'_',
						' ',
						$goal
					)
				)
			)
			. '</p>';

		echo '<p>Stay consistent and keep pushing toward your goals.</p>';
	}
}
