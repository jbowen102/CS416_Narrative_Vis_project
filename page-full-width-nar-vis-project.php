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

				<!-- <img src="<?php echo esc_url( content_url( '/uploads/2026/07/stk_mockup-300x300.png.webp' ) ); ?>" alt="Narrative visualization image" style="max-width:100%; height:auto; margin:1rem 0;" /> -->

				<script src='https://d3js.org/d3.v5.min.js'></script>

				<style> circle {fill: royalblue; stroke: black;} </style>

				<svg width="1200" height="1200">

				</svg>

				<script>

					// In WordPress template JS, use window load event instead of <body onload="init()">
					window.addEventListener('load', init);

					async function init() {

						const plot_height = 1000;
						const plot_width = 1000;
						const margin = 70;

						// const mpg_data = await d3.csv("https://flunky.github.io/cars2017.csv", d3.autoType);
						// const stk_data = await d3.csv("/data/CS416_NVis_project/synthetic_migration_data.csv", d3.autoType);
						const stk_data = await d3.csv("/data/CS416_NVis_project/swallow_tailed_kite_20260725_clean.csv", d3.autoType);

						const x = d3.scaleLinear()
							.domain([-108, -50])
							.range([0, plot_width]);

						const y = d3.scaleLinear()
							.domain([-15, 40])
							.range([plot_height, 0]);

						d3.select("svg").append("g")
							.attr("transform", "translate(" + margin + "," + margin + ")")
							.selectAll("circle")
							.data(stk_data)
							.enter()
							.append("circle")
							.attr("stroke", "silver")
							// .transition().duration(4000)
							.attr("cx", function (d) { return x(d.longitude); })
							// .transition().duration(4000)
							.attr("cy", function (d) { return y(d.latitude); })
							.attr("r", 4);
							// .attr("r", function (d, i) { return 2 + d.EngineCylinders; })

						// set up axes
						d3.select("svg")
							.append("g")
							.attr("transform", "translate(" + margin + "," + margin + ")")
							.call(d3.axisLeft(y));
										// .tickValues([10, 20, 50, 100])
										// .tickFormat(d3.format("~s")));

						d3.select("svg")
							.append("g")
							.attr("transform", "translate(" + margin + "," + (plot_height + margin) + ")")
							.call(d3.axisBottom(x));
										// .tickValues([10, 20, 50, 100])
										// .tickFormat(d3.format("~s")));
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
