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

				<script src='https://d3js.org/d3.v5.min.js'></script>
				<!-- <style> circle {fill: royalblue; stroke: black;} </style> -->
				<!-- <img src="<?php echo esc_url( content_url( '/uploads/2026/07/stk_mockup-300x300.png.webp' ) ); ?>" alt="Narrative visualization image" style="max-width:100%; height:auto; margin:1rem 0;" /> -->

				<p>Swallow-tailed Kite migration routes</p>

                <div id="viz-wrapper">

					<input id="week-slider" type="range" min="31" max="43" value="31">
					<span id="week-label">Week 31</span>
					</br>
					<svg width="1200" height="1200">

					</svg>

					<script>
						window.addEventListener("load", init);

						let margin = 70;
						let selectedWeek = 31;
						d3.select("#week-label").text(`Week ${selectedWeek}`);

						let stk_data;
						let chartLayer;
						const svg = d3.select("svg");

						async function init() {
							stk_data = await d3.csv("/data/CS416_NVis_project/swallow_tailed_kite_compl_20260726_zf_clean_agg_weekly.csv", d3.autoType);

							const plot_height = 1000;
							const plot_width = 1000;

							const x = d3.scaleLinear()
								.domain([-109, -50])        // expanded longitude range by 1 degree West to un-crowd axis
								.range([0, plot_width]);

							const y = d3.scaleLinear()
								.domain([-16, 40])          // expanded latitude range by 1 degree South to un-crowd axis
								.range([plot_height, 0]);

							chartLayer = svg.append("g")
								.attr("transform", "translate(" + margin + "," + margin + ")");

							// set up axes
							chartLayer.append("g")
									.call(d3.axisLeft(y));
							chartLayer.append("g")
									.attr("transform", "translate(0," + plot_height + ")")
									.call(d3.axisBottom(x));

							d3.select("#week-slider")
							.on("input", function () { selectedWeek = +this.value;
														d3.select("#week-label").text(`Week ${selectedWeek}`);
														updateChart(x, y);
														}
								);
								// "this" refers to whatever DOM element triggered the event.
								// "this.value" is the value of the slider (as str, so convert to number w/ +).

							updateChart(x, y);

						}

						function updateChart(x, y) {
							const weekData = stk_data.filter(d => Number(d.week) === selectedWeek);

							const circles = chartLayer.selectAll("circle")
								.data(weekData, d => d.cell);

							circles.exit()
								.transition()
								.duration(300)
								.style("opacity", 0)
								.remove();

							const enterCircles = circles.enter()
								.append("circle")
								.attr("cx", d => x(d.cell_ctr_lon))
								.attr("cy", d => y(d.cell_ctr_lat))
								.attr("r", 4)
								.style("opacity", 0)
								.attr("stroke", "black")
								.attr("fill", "white");

							enterCircles.merge(circles)
								.attr("cx", d => x(d.cell_ctr_lon))
								.attr("cy", d => y(d.cell_ctr_lat))
								.attr("r", 4)
								.transition()
								.duration(300)
								.style("opacity", 1)
								.attr("fill", d => d.det_freq > 0 ? "royalblue" : "white")
								.attr("stroke", "black");
						}



					</script>

				</div> <!-- viz-wrapper -->

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
