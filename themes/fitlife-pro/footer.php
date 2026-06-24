</main>

<footer class="site-footer">

	<div class="container">

		<?php

		wp_nav_menu(
			[
				'theme_location' => 'footer-menu',
				'container'      => false,
				'menu_class'     => 'footer-menu',
			]
		);

		?>

		<p class="copyright">
			© <?php echo esc_html( date( 'Y' ) ); ?>
			FitLife Pro
		</p>

	</div>

</footer>

<?php wp_footer(); ?>

</body>

</html>