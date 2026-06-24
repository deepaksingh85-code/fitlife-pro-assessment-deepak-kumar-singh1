<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class FitLife_Settings {

	public function __construct() {

		add_action(
			'admin_menu',
			[
				$this,
				'add_settings_page',
			]
		);

		add_action(
			'admin_init',
			[
				$this,
				'register_settings',
			]
		);
	}

	public function add_settings_page() {

		add_options_page(
			'FitLife Settings',
			'FitLife Settings',
			'manage_options',
			'fitlife-settings',
			[
				$this,
				'render_settings_page',
			]
		);
	}

	public function register_settings() {

		register_setting(
			'fitlife_settings_group',
			'fitlife_brand_color'
		);

		register_setting(
			'fitlife_settings_group',
			'fitlife_contact_email'
		);

		register_setting(
			'fitlife_settings_group',
			'fitlife_programs_per_page'
		);

		register_setting(
			'fitlife_settings_group',
			'fitlife_enable_reviews'
		);
	}

	public function render_settings_page() {

		?>

		<div class="wrap">

			<h1>FitLife Settings</h1>

			<form
				method="post"
				action="options.php"
			>

				<?php
				settings_fields(
					'fitlife_settings_group'
				);
				?>

				<table class="form-table">

					<tr>
						<th>
							Brand Color
						</th>

						<td>

							<input
								type="color"
								name="fitlife_brand_color"
								value="<?php echo esc_attr(
									get_option(
										'fitlife_brand_color',
										'#005fcc'
									)
								); ?>"
							>

						</td>
					</tr>

					<tr>
						<th>
							Contact Email
						</th>

						<td>

							<input
								type="email"
								name="fitlife_contact_email"
								value="<?php echo esc_attr(
									get_option(
										'fitlife_contact_email'
									)
								); ?>"
							>

						</td>
					</tr>

					<tr>
						<th>
							Programs Per Page
						</th>

						<td>

							<input
								type="number"
								name="fitlife_programs_per_page"
								value="<?php echo esc_attr(
									get_option(
										'fitlife_programs_per_page',
										6
									)
								); ?>"
							>

						</td>
					</tr>

					<tr>
						<th>
							Enable Reviews
						</th>

						<td>

							<input
								type="checkbox"
								name="fitlife_enable_reviews"
								value="1"
								<?php checked(
									get_option(
										'fitlife_enable_reviews'
									),
									1
								); ?>
							>

						</td>
					</tr>

				</table>

				<?php submit_button(); ?>

			</form>

		</div>

		<?php
	}
}