<?php
/**
 * Single Safari Template
 *
 * @package B.O-Safari-theme
 */

get_header();

while ( have_posts() ) :
	the_post();

	$safari_id   = get_the_ID();
	$destination = get_post_meta( $safari_id, '_safari_destination', true ) ?: 'Serengeti & Masai Mara';
	$duration    = get_post_meta( $safari_id, '_safari_duration', true ) ?: '8 Days / 7 Nights';
	$price       = get_post_meta( $safari_id, '_safari_price', true ) ?: '4,250';
	$rating      = get_post_meta( $safari_id, '_safari_rating', true ) ?: '4.98';
	$reviews_cnt = get_post_meta( $safari_id, '_safari_reviews', true ) ?: '142';
	$hero_img    = get_the_post_thumbnail_url( $safari_id, 'safari-hero' ) ?: 'https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&w=1920&q=80';
	?>

	<!-- Safari Single Hero -->
	<section class="single-safari-hero relative py-24 bg-safari-green text-white overflow-hidden">
		<div class="absolute inset-0 z-0">
			<img src="<?php echo esc_url( $hero_img ); ?>" alt="<?php the_title_attribute(); ?>" class="w-full h-full object-cover opacity-40">
			<div class="absolute inset-0 bg-gradient-to-t from-safari-green via-safari-green/60 to-transparent"></div>
		</div>

		<div class="site-container relative z-10 max-w-5xl">
			<?php bo_safari_render_breadcrumbs(); ?>

			<div class="flex flex-wrap items-center gap-3 mt-4 mb-2">
				<span class="badge-gold"><?php echo esc_html( $destination ); ?></span>
				<span class="text-sand/80 text-xs font-semibold">&bull; <?php echo esc_html( $duration ); ?></span>
			</div>

			<h1 class="text-3xl md:text-5xl lg:text-6xl font-serif font-bold text-white mb-6 leading-tight">
				<?php the_title(); ?>
			</h1>

			<div class="flex flex-wrap items-center justify-between gap-6 pt-6 border-t border-white/20">
				<div class="flex items-center gap-4">
					<?php bo_safari_render_star_rating( $rating ); ?>
					<span class="text-xs text-sand font-semibold">(<?php echo esc_html( $reviews_cnt ); ?> <?php esc_html_e( 'guest reviews', 'bo-safari-theme' ); ?>)</span>
				</div>

				<div class="flex items-center gap-4">
					<div class="text-right">
						<span class="text-xs text-sand/70 block uppercase"><?php esc_html_e( 'From', 'bo-safari-theme' ); ?></span>
						<span class="text-2xl font-serif font-bold text-champagne">$<?php echo esc_html( $price ); ?> <span class="text-xs font-sans text-sand font-normal">/ pers</span></span>
					</div>
					<a href="#" class="btn-primary py-3 px-6 text-xs" data-open-enquiry-modal="true" data-safari-title="<?php echo esc_attr( get_the_title() ); ?>">
						<?php esc_html_e( 'Request Itinerary', 'bo-safari-theme' ); ?>
					</a>
				</div>
			</div>
		</div>
	</section>

	<!-- Quick Facts Strip -->
	<section class="quick-facts-bar bg-white border-b border-sand py-6">
		<div class="site-container">
			<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 text-center text-xs">
				<div class="fact-item border-r border-sand/60 last:border-none">
					<span class="block text-charcoal/60 uppercase font-semibold"><?php esc_html_e( 'Duration', 'bo-safari-theme' ); ?></span>
					<span class="font-bold text-safari-green text-sm"><?php echo esc_html( $duration ); ?></span>
				</div>
				<div class="fact-item border-r border-sand/60 last:border-none">
					<span class="block text-charcoal/60 uppercase font-semibold"><?php esc_html_e( 'Tour Type', 'bo-safari-theme' ); ?></span>
					<span class="font-bold text-safari-green text-sm">Private Luxury</span>
				</div>
				<div class="fact-item border-r border-sand/60 last:border-none">
					<span class="block text-charcoal/60 uppercase font-semibold"><?php esc_html_e( 'Transport', 'bo-safari-theme' ); ?></span>
					<span class="font-bold text-safari-green text-sm">Fly-In & 4x4 Cruiser</span>
				</div>
				<div class="fact-item border-r border-sand/60 last:border-none">
					<span class="block text-charcoal/60 uppercase font-semibold"><?php esc_html_e( 'Lodging', 'bo-safari-theme' ); ?></span>
					<span class="font-bold text-safari-green text-sm">5-Star Tented Camps</span>
				</div>
				<div class="fact-item border-r border-sand/60 last:border-none">
					<span class="block text-charcoal/60 uppercase font-semibold"><?php esc_html_e( 'Best Season', 'bo-safari-theme' ); ?></span>
					<span class="font-bold text-safari-green text-sm">Year-Round</span>
				</div>
				<div class="fact-item">
					<span class="block text-charcoal/60 uppercase font-semibold"><?php esc_html_e( 'Pacing', 'bo-safari-theme' ); ?></span>
					<span class="font-bold text-safari-green text-sm">Leisurely & Exclusive</span>
				</div>
			</div>
		</div>
	</section>

	<div class="site-container py-16">
		<div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

			<!-- Main Content -->
			<div class="lg:col-span-2 space-y-12">

				<!-- Overview -->
				<section class="safari-overview bg-white p-8 rounded-2xl border border-sand">
					<h2 class="text-2xl font-serif font-bold text-safari-green mb-4"><?php esc_html_e( 'Journey Overview', 'bo-safari-theme' ); ?></h2>
					<div class="prose max-w-none text-charcoal/80 text-sm leading-relaxed">
						<?php the_content(); ?>
					</div>
				</section>

				<!-- Expandable Day-by-Day Itinerary -->
				<section class="safari-itinerary">
					<h2 class="text-2xl font-serif font-bold text-safari-green mb-6"><?php esc_html_e( 'Day-by-Day Itinerary', 'bo-safari-theme' ); ?></h2>

					<div class="itinerary-accordion accordion-group" data-single="false">
						<?php for ( $i = 1; $i <= 7; $i++ ) : ?>
							<div class="itinerary-item <?php echo $i === 1 ? 'is-active' : ''; ?>">
								<div class="itinerary-header">
									<div class="itinerary-title-group">
										<span class="itinerary-day-badge"><?php esc_html_e( 'Day', 'bo-safari-theme' ); ?> <?php echo esc_html( $i ); ?></span>
										<h3 class="font-serif font-bold text-safari-green text-base">
											<?php
											$days = array(
												1 => 'Arrival in Nairobi & Private Transfer to Sanctuary',
												2 => 'Fly to Masai Mara & Golden Hour Sunset Drive',
												3 => 'Full Day Big Cat Safari & Bush Champagne Lunch',
												4 => 'Hot Air Balloon Safari & Mara River Crossing Tracking',
												5 => 'Fly to Serengeti & Ngorongoro Caldera Descent',
												6 => 'Rhino Conservation Search & Sunset Sundowners',
												7 => 'Farewell Bush Breakfast & Return Air Transfer',
											);
											echo esc_html( isset( $days[ $i ] ) ? $days[ $i ] : "Wilderness Exploration Day $i" );
											?>
										</h3>
									</div>
									<svg class="w-5 h-5 itinerary-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
								</div>
								<div class="itinerary-body text-xs text-charcoal/80 space-y-3">
									<p><?php esc_html_e( 'Board your private charter flight into the heart of the game reserve. Meet your dedicated master guide and set out on an afternoon game drive searching for lions, leopards, and elephant herds.', 'bo-safari-theme' ); ?></p>
									<div class="grid grid-cols-2 gap-2 pt-2 text-[11px] font-semibold text-safari-green border-t border-sand/40">
										<span><strong>Meals:</strong> Breakfast, Lunch, Gourmet Dinner</span>
										<span><strong>Stay:</strong> Singita Mara River Tented Camp</span>
									</div>
								</div>
							</div>
						<?php endfor; ?>
					</div>
				</section>

				<!-- Inclusions & Exclusions -->
				<section class="inclusions-exclusions bg-white p-8 rounded-2xl border border-sand">
					<h2 class="text-2xl font-serif font-bold text-safari-green mb-6"><?php esc_html_e( 'What Is Included', 'bo-safari-theme' ); ?></h2>
					<div class="grid grid-cols-1 md:grid-cols-2 gap-8 text-xs text-charcoal/80">
						<div>
							<h3 class="font-bold text-safari-green text-sm mb-3 flex items-center gap-2">
								<span class="text-green-600">&check;</span> <?php esc_html_e( 'Included In Your Fare', 'bo-safari-theme' ); ?>
							</h3>
							<ul class="space-y-2 list-none">
								<li>&bull; All internal private charter flight transfers</li>
								<li>&bull; Luxury 5-star tented camp accommodation</li>
								<li>&bull; All gourmet meals & premium alcoholic beverages</li>
								<li>&bull; Dedicated 4x4 Land Cruiser & expert ranger</li>
								<li>&bull; All national park entry fees & conservation levies</li>
							</ul>
						</div>

						<div>
							<h3 class="font-bold text-red-800 text-sm mb-3 flex items-center gap-2">
								<span class="text-red-600">&times;</span> <?php esc_html_e( 'Exclusions', 'bo-safari-theme' ); ?>
							</h3>
							<ul class="space-y-2 list-none">
								<li>&bull; International long-haul flights</li>
								<li>&bull; Entry visas and travel insurance</li>
								<li>&bull; Gratuities for camp staff and guides</li>
							</ul>
						</div>
					</div>
				</section>

			</div>

			<!-- Sidebar Booking Card -->
			<aside class="sidebar-booking space-y-8">
				<div class="sticky top-28 bg-white p-6 rounded-2xl border border-sand shadow-lg text-center">
					<span class="text-xs uppercase font-semibold text-charcoal/60 block"><?php esc_html_e( 'Starting From', 'bo-safari-theme' ); ?></span>
					<span class="text-3xl font-serif font-bold text-safari-green block mb-2">$<?php echo esc_html( $price ); ?> <span class="text-xs font-sans text-charcoal/60 font-normal">/ person</span></span>

					<p class="text-xs text-charcoal/70 mb-6">All-inclusive luxury pricing based on double occupancy.</p>

					<div class="space-y-3 mb-6">
						<a href="#" class="btn-primary w-full py-3.5 text-xs font-bold" data-open-enquiry-modal="true" data-safari-title="<?php echo esc_attr( get_the_title() ); ?>">
							<?php esc_html_e( 'Enquire About Dates', 'bo-safari-theme' ); ?>
						</a>
						<?php bo_safari_render_whatsapp_button( __( 'WhatsApp Instant Chat', 'bo-safari-theme' ), 'safari_sidebar' ); ?>
					</div>

					<div class="text-[11px] text-charcoal/60 pt-4 border-t border-sand space-y-1">
						<p>&check; 100% Financial Guarantee</p>
						<p>&check; Tailor-Made Customizations Available</p>
					</div>
				</div>
			</aside>

		</div>
	</div>

<?php endwhile; ?>

<?php
get_template_part( 'template-parts/components/cta-section' );
get_footer();
