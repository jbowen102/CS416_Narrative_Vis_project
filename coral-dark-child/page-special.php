<?php
/**
 * Custom template saved off coral-dark/page.php 2026-07-12.
 * Template Name: Special Page
 *
 * Created for use with D3 visualization project.
 *
 */

get_header(); ?>

	<div id="primary" class="content-area egrid <?php coral_dark_column_class('content'); ?>">
		<main id="main" class="site-main" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

				        <div class="entry-content special-page-content">

                                        <header class="entry-header">
                                                <?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
                                        </header><!-- .entry-header -->

				                <!-- custom HTML starts here -->











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

<?php get_sidebar(); ?>
<?php get_footer(); ?>
