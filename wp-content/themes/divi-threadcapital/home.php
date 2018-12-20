<?php get_header(); ?>

<div class="post-header" style="background-image: url(<?php echo get_the_post_thumbnail_url(get_the_ID(), 'large' ); ?>)">
	<div class="entry-meta">
		<h1 class="entry-title">News</h1>
	</div>
</div>

<div id="main-content">
	<div class="container post-page">
		<?php
			if ( have_posts() ) :
				while ( have_posts() ) : the_post(); ?>

				<article class="post-wrapper">
					<a href="<?php the_permalink(); ?>">
						<section class="image" style="background-image: url(<?php echo get_the_post_thumbnail_url(get_the_ID(), 'medium' ); ?>)">
							<div class="excerpt">
								<?php truncate_post(100); ?>
							</div>
						</section>
					</a>

					<h4 class="entry-title">
						<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
					</h4>
				</article>

					<?php
							endwhile;

							if ( function_exists( 'wp_pagenavi' ) )
								wp_pagenavi();
							else
								get_template_part( 'includes/navigation', 'index' );
						else :
							get_template_part( 'includes/no-results', 'index' );
						endif;
					?>
	</div> <!-- .container -->
</div> <!-- #main-content -->

<?php get_footer();
