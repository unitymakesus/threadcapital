<?php if ( 'on' == et_get_option( 'divi_back_to_top', 'false' ) ) : ?>

	<span class="et_pb_scroll_top et-pb-icon"></span>

<?php endif;

if ( ! is_page_template( 'page-template-blank.php' ) ) : ?>

			<div class="footer-arc"></div>
			<footer id="main-footer">
				<?php get_sidebar( 'footer' ); ?>


		<?php
			if ( has_nav_menu( 'footer-menu' ) ) : ?>

				<div id="et-footer-nav">
					<div class="container">
						<?php
							wp_nav_menu( array(
								'theme_location' => 'footer-menu',
								'depth'          => '1',
								'menu_class'     => 'bottom-nav',
								'container'      => '',
								'fallback_cb'    => '',
							) );
						?>
					</div>
				</div> <!-- #et-footer-nav -->

			<?php endif; ?>

				<div id="footer-bottom">
					<div class="container clearfix">
						<div class="left">
							&copy;<?php echo current_time('Y'); ?> Thread Capital, a subsidiary of the <a href="https://www.ncruralcenter.org/" target="_blank" rel="noopener">NC Rural Center</a>
						</div>
						<div class="center">
							<a href="https://www.unitymakes.us/" target="_blank" rel="noopener" class="unity-link">
								<?php echo file_get_contents(get_stylesheet_directory() . '/images/made-with-unity.svg'); ?>
							</a>
						</div>
						<div class="right">
							<a href="/privacy-policy/">Privacy Policy</a>
						</div>
					</div>	<!-- .container -->
				</div>
			</footer> <!-- #main-footer -->
		</div> <!-- #et-main-area -->

<?php endif; // ! is_page_template( 'page-template-blank.php' ) ?>

	</div> <!-- #page-container -->

	<?php wp_footer(); ?>
</body>
</html>
