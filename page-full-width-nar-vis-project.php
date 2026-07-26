<?php
/**
 * Template Name: Narrative Vis Project
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

							<p>Swallow-tailed Kite migration routes</p>

							<img src="<?php echo esc_url( content_url( '/uploads/2026/07/stk_mockup-300x300.png.webp' ) ); ?>" alt="Narrative visualization image" style="max-width:100%; height:auto; margin:1rem 0;" />
							</br>

							<script src='https://d3js.org/d3.v5.min.js'></script>

							<svg width="400" height="400">

							</svg>

							<script>

								// In WordPress template JS, use window load event instead of <body onload="init()">
								window.addEventListener('load', init);

								async function init() {

									const plot_height = 200;
									const plot_width = 200;
									const margin = 50;

									const mpg_data = await d3.csv("https://flunky.github.io/cars2017.csv", d3.autoType);
									// const data = await d3.csv("/data/CS416_NVis_project/synthetic_migration_data.csv", d3.autoType);

									const x = d3.scaleLog()
										.domain([10, 150])
										.range([0, plot_width])
										.base(10);

									const y = d3.scaleLog()
										.domain([10, 150])
										.range([plot_height, 0])
										.base(10);

									d3.select("svg").append("g")
										.attr("transform", "translate(" + margin + "," + margin + ")")
										.selectAll("circle")
										.data(mpg_data)
										.enter()
										.append("circle")
										.attr("fill", "royalblue")
										.attr("stroke", "silver")
										.transition().duration(2000)
										.attr("cx", function (d) { return x(d.AverageCityMPG); })
										.transition().duration(2000)
										.attr("cy", function (d) { return y(d.AverageHighwayMPG); })
										.attr("r", function (d, i) { return 2 + d.EngineCylinders; });

									// set up axes
									d3.select("svg")
										.append("g")
										.attr("transform", "translate(" + margin + "," + margin + ")")
										.call(d3.axisLeft(y)
													.tickValues([10, 20, 50, 100])
													.tickFormat(d3.format("~s")));

									d3.select("svg")
										.append("g")
										.attr("transform", "translate(" + margin + "," + (plot_height + margin) + ")")
										.call(d3.axisBottom(x)
													.tickValues([10, 20, 50, 100])
													.tickFormat(d3.format("~s")));
								}


							</script>

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
