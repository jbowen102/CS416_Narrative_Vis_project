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

                    <input id="week-slider" type="range" min="27" max="48" value="27">
					<span id="week-label">Week 27</span>

                    <div id="species-pick">
                        <label style="margin-right:12px;"><input type="checkbox" id="chk-stk" checked> Swallow-tailed Kite</label>
                        <label><input type="checkbox" id="chk-bwh" checked> Broad-winged Hawk</label>
                    </div>
                    </br>
                    <svg width="1200" height="1200">

					</svg>

                    <script>
						window.addEventListener("load", init);
						
                        let margin = 70;
                        let selectedWeek = 27;
                        d3.select("#week-label").text(`Week ${selectedWeek}`);
						
                        let data_stk;
                        let data_bwh;
                        let chartLayer;
                        let layerSTK;
                        let layerBWH;
                        const svg = d3.select("svg");
						
                        async function init() {
							data_stk = await d3.csv("/data/CS416_NVis_project/swallow_tailed_kite_compl_exp_range_20260729_zf_clean_agg_weekly.csv", d3.autoType);
                            data_bwh = await d3.csv("/data/CS416_NVis_project/broad_winged_hawk_compl_exp_range_20260729_zf_clean_agg_weekly.csv", d3.autoType);

                            const plot_height = 1000;
                            const plot_width = 1000;

                            const x = d3.scaleLinear()
                                .domain([-109, -50])
                                .range([0, plot_width]);
                                // expanded longitude range by 1 degree West to un-crowd axis
                                
                                const y = d3.scaleLinear()
                                .domain([-16, 40])
                                .range([plot_height, 0]);// expanded latitude range by 1 degree South to un-crowd axis

                            chartLayer = svg.append("g")
                                .attr("transform", "translate(" + margin + "," + margin + ")");

                            // separate groups per species so both can be shown simultaneously
                            layerSTK = chartLayer.append("g").attr("class", "layer-stk");
                            layerBWH = chartLayer.append("g").attr("class", "layer-bwh");

                            // set up axes
                            chartLayer.append("g")
                                    .call(d3.axisLeft(y));
                            chartLayer.append("g")
                                    .attr("transform", "translate(0," + plot_height + ")")
                                    .call(d3.axisBottom(x));

                            d3.select("#week-slider")
                            .on("input", function () { selectedWeek = +this.value;
                                                        d3.select("#week-label").text(`Week ${selectedWeek}`);
                                                        updateChart2(x, y);
                                                        }
                                );

                            // update when species selection changes
                            d3.selectAll("#chk-stk, #chk-bwh").on("change", function() {
                                updateChart2(x, y);
                            });

                            updateChart2(x, y);

                        }

                        function updateChart(x, y) {
                            // assemble weekData from selected species
                            const stkChecked = d3.select("#chk-stk").property("checked");
                            const bwhChecked = d3.select("#chk-bwh").property("checked");

                            let weekData = [];
                            if (stkChecked && data_stk) {
                                weekData = weekData.concat(
                                    data_stk.filter(d => Number(d.week) === selectedWeek)
                                        .map(d => Object.assign({}, d, { species: 'stk' }))
                                );
                            }
                            if (bwhChecked && data_bwh) {
                                weekData = weekData.concat(
                                    data_bwh.filter(d => Number(d.week) === selectedWeek)
                                        .map(d => Object.assign({}, d, { species: 'bwh' }))
                                );
                            }

                            const circles = chartLayer.selectAll("circle")
                                .data(weekData, d => d.species + "-" + d.cell);

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
                                .attr("stroke", "gainsboro")
								.attr("stroke-opacity", 0.3)
                                .attr("fill", "none");

                            enterCircles.merge(circles)
                                .attr("cx", d => x(d.cell_ctr_lon))
                                .attr("cy", d => y(d.cell_ctr_lat))
                                .attr("r", 4)
                                .transition()
                                .duration(300)
                                .style("opacity", 1)
                                .attr("fill", d => d.det_freq > 0 ? (d.species === 'stk' ? "royalblue" : "orange") : "none")
                                .attr("stroke", "gainsboro")
								.attr("stroke-opacity", 0.3);

                        }

                        // Render each species in its own layer so both are visible
                        function updateChart2(x, y) {
                            const stkChecked = d3.select("#chk-stk").property("checked");
                            const bwhChecked = d3.select("#chk-bwh").property("checked");

                            const stkWeek = stkChecked && data_stk ? data_stk.filter(d => Number(d.week) === selectedWeek) : [];
                            const bwhWeek = bwhChecked && data_bwh ? data_bwh.filter(d => Number(d.week) === selectedWeek) : [];

                            // STK
                            const stkSel = layerSTK.selectAll("circle").data(stkWeek, d => d.cell);
                            stkSel.exit().transition().duration(300).style("opacity", 0).remove();
                            const stkEnter = stkSel.enter().append("circle")
                                .attr("cx", d => x(d.cell_ctr_lon))
                                .attr("cy", d => y(d.cell_ctr_lat))
                                .attr("r", 4)
                                .style("opacity", 0)
                                .attr("stroke", "gainsboro")
								.attr("stroke-opacity", 0.3);
                            stkEnter.merge(stkSel)
                                .attr("cx", d => x(d.cell_ctr_lon))
                                .attr("cy", d => y(d.cell_ctr_lat))
                                .transition().duration(300)
                                .style("opacity", 1)
                                .attr("fill", d => d.det_freq > 0 ? "royalblue" : "none");

                            // BWH
                            const bwhSel = layerBWH.selectAll("circle").data(bwhWeek, d => d.cell);
                            bwhSel.exit().transition().duration(300).style("opacity", 0).remove();
                            const bwhEnter = bwhSel.enter().append("circle")
                                .attr("cx", d => x(d.cell_ctr_lon))
                                .attr("cy", d => y(d.cell_ctr_lat))
                                .attr("r", 4)
                                .style("opacity", 0)
                                .attr("stroke", "gainsboro")
								.attr("stroke-opacity", 0.3);
                            bwhEnter.merge(bwhSel)
                                .attr("cx", d => x(d.cell_ctr_lon))
                                .attr("cy", d => y(d.cell_ctr_lat))
                                .transition().duration(300)
                                .style("opacity", 1)
								.attr("stroke-opacity", 0.3)
                                .attr("fill", d => d.det_freq > 0 ? "orange" : "none");
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
