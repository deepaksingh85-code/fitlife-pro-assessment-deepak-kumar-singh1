<!DOCTYPE html>
<html <?php language_attributes(); ?>>

<head>

	<meta charset="<?php bloginfo( 'charset' ); ?>">

	<meta
		name="viewport"
		content="width=device-width, initial-scale=1.0"
	>

	<?php wp_head(); ?>

</head>

<body <?php body_class(); ?>>

<?php wp_body_open(); ?>

<a
	class="skip-link"
	href="#main-content"
>
	Skip to Content
</a>

<header class="site-header">

	<div class="container">

		<div class="header-wrapper">

			<div class="site-logo">

				<?php

				if ( has_custom_logo() ) {

					the_custom_logo();

				} else {

					?>

					<a
						href="<?php echo esc_url( home_url( '/' ) ); ?>"
					>
						<?php bloginfo( 'name' ); ?>
					</a>

					<?php
				}
				?>

			</div>

			<nav
				class="main-navigation"
				aria-label="Primary Navigation"
			>

				<?php

				wp_nav_menu(
					[
						'theme_location' => 'primary-menu',
						'container'      => false,
						'menu_class'     => 'nav-menu',
						'walker'         => new FitLife_Walker_Menu(),
					]
				);

				?>

			</nav>

		</div>

	</div>

</header>

<main id="main-content">