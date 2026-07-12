<?php
/**
 * Template Name: Full Width Custom
 * Custom template saved off coral-dark/page-full-width.php 2026-07-12.
 *
 * Created for use with D3 visualization project.
 *
 */

get_header(); ?>

	<div id="primary" class="content-area grid-100 tablet-grid-100 mobile-grid-100">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

                                <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

                                        <header class="entry-header">
                                                <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                                        </header><!-- .entry-header -->

				        <div class="entry-content special-page-content">

				                <!-- custom HTML starts here -->




						<p>some words here</p>








						<!-- custom HTML ends here -->

				        </div><!-- .entry-content -->

				</article><!-- #post-<?php the_ID(); ?> -->

				<?php
					// If comments are open or we have at least one comment, load up the comment template
					if ( comments_open() || get_comments_number() ) :
						comments_template();
					endif;
				?>

			<?php endwhile; // end of the loop. ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php get_footer(); ?>
