<?php

get_header();

?>

<div id="main-content">
  <?php while ( have_posts() ) : the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class( 'et_pb_post' ); ?>>
				<div class="post-header" style="background-image: url(<?php echo get_the_post_thumbnail_url( $post_id, 'large' ); ?>)">
					<div class="entry-meta">
						<h1 class="entry-title"><?php the_title(); ?></h1>
						<?php et_divi_post_meta(); ?>
					</div>
				</div>

				<div class="entry-content">
					<?php the_content(); ?>
				</div> <!-- .entry-content -->
			</article> <!-- .et_pb_post -->
  <?php endwhile; ?>
</div> <!-- #main-content -->

<?php get_footer(); ?>
