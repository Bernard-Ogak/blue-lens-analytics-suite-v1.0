<?php
/**
 * Template Name: Custom Safari Builder
 *
 * @package B.O-Safari-theme
 */

get_header();
?>

<div class="builder-hero py-12 bg-ivory border-b border-sand text-center">
	<div class="site-container max-w-3xl">
		<span class="badge-gold mb-2 inline-block"><?php esc_html_e( 'Bespoke Itinerary Architect', 'bo-safari-theme' ); ?></span>
		<h1 class="text-3xl md:text-5xl font-serif text-safari-green font-bold mb-3">
			<?php esc_html_e( 'Build Your Custom African Safari', 'bo-safari-theme' ); ?>
		</h1>
		<p class="text-charcoal/80 text-sm">
			<?php esc_html_e( 'Complete the 10 quick steps below to design your tailor-made luxury safari.', 'bo-safari-theme' ); ?>
		</p>
	</div>
</div>

<div class="site-container py-12 max-w-4xl">

	<!-- Progress Bar -->
	<div class="builder-progress-wrapper mb-10">
		<div class="builder-progress-bar">
			<div class="builder-progress-fill" style="width: 0%;"></div>
			<?php for ( $i = 1; $i <= 10; $i++ ) : ?>
				<div class="builder-step-dot <?php echo $i === 1 ? 'is-active' : ''; ?>"><?php echo esc_html( $i ); ?></div>
			<?php endfor; ?>
		</div>
		<h2 id="builder-current-step-title" class="text-2xl font-serif text-center font-bold text-safari-green mt-4">
			<?php esc_html_e( 'Step 1: Select Your Destination', 'bo-safari-theme' ); ?>
		</h2>
	</div>

	<!-- Builder Form -->
	<form id="custom-safari-builder-form" class="bg-white p-8 lg:p-12 border border-sand rounded-2xl shadow-sm">

		<!-- Step 1: Destinations -->
		<div class="builder-step-panel is-active" data-step="1">
			<p class="text-charcoal/70 text-sm mb-6 text-center"><?php esc_html_e( 'Where in Africa would you like to explore?', 'bo-safari-theme' ); ?></p>
			<div class="option-grid">
				<label class="option-card">
					<input type="checkbox" name="destination[]" value="Kenya">
					<h4 class="font-serif font-bold text-safari-green text-lg">Kenya</h4>
					<p class="text-xs text-charcoal/60 mt-1">Masai Mara, Amboseli, Samburu</p>
				</label>
				<label class="option-card">
					<input type="checkbox" name="destination[]" value="Tanzania">
					<h4 class="font-serif font-bold text-safari-green text-lg">Tanzania</h4>
					<p class="text-xs text-charcoal/60 mt-1">Serengeti, Ngorongoro, Zanzibar</p>
				</label>
				<label class="option-card">
					<input type="checkbox" name="destination[]" value="Rwanda">
					<h4 class="font-serif font-bold text-safari-green text-lg">Rwanda</h4>
					<p class="text-xs text-charcoal/60 mt-1">Volcanoes NP, Gorilla Trekking</p>
				</label>
				<label class="option-card">
					<input type="checkbox" name="destination[]" value="Uganda">
					<h4 class="font-serif font-bold text-safari-green text-lg">Uganda</h4>
					<p class="text-xs text-charcoal/60 mt-1">Bwindi Forest, Murchison Falls</p>
				</label>
			</div>
		</div>

		<!-- Step 2: Travel Dates & Season -->
		<div class="builder-step-panel" data-step="2">
			<p class="text-charcoal/70 text-sm mb-6 text-center"><?php esc_html_e( 'When are you planning to travel?', 'bo-safari-theme' ); ?></p>
			<div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-lg mx-auto">
				<div>
					<label class="block text-xs uppercase font-semibold text-charcoal/70 mb-2"><?php esc_html_e( 'Approximate Month & Year', 'bo-safari-theme' ); ?></label>
					<input type="text" name="travel_dates" placeholder="e.g. August 2026" class="w-full p-3.5 bg-sand-light border border-sand rounded text-sm">
				</div>
				<div>
					<label class="block text-xs uppercase font-semibold text-charcoal/70 mb-2"><?php esc_html_e( 'Duration', 'bo-safari-theme' ); ?></label>
					<select name="duration" class="w-full p-3.5 bg-sand-light border border-sand rounded text-sm">
						<option value="5-7 Days">5 - 7 Days</option>
						<option value="8-10 Days">8 - 10 Days</option>
						<option value="11-14 Days">11 - 14 Days</option>
						<option value="15+ Days">15+ Days</option>
					</select>
				</div>
			</div>
		</div>

		<!-- Step 3: Travellers -->
		<div class="builder-step-panel" data-step="3">
			<p class="text-charcoal/70 text-sm mb-6 text-center"><?php esc_html_e( 'Who will be travelling with you?', 'bo-safari-theme' ); ?></p>
			<div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-lg mx-auto">
				<div>
					<label class="block text-xs uppercase font-semibold text-charcoal/70 mb-2"><?php esc_html_e( 'Adults (12+ yrs)', 'bo-safari-theme' ); ?></label>
					<input type="number" name="adults" value="2" min="1" max="30" class="w-full p-3.5 bg-sand-light border border-sand rounded text-sm">
				</div>
				<div>
					<label class="block text-xs uppercase font-semibold text-charcoal/70 mb-2"><?php esc_html_e( 'Children (0-11 yrs)', 'bo-safari-theme' ); ?></label>
					<input type="number" name="children" value="0" min="0" max="10" class="w-full p-3.5 bg-sand-light border border-sand rounded text-sm">
				</div>
			</div>
		</div>

		<!-- Step 4: Preferred Travel Style -->
		<div class="builder-step-panel" data-step="4">
			<div class="option-grid">
				<label class="option-card">
					<input type="radio" name="travel_style" value="Luxury Fly-In">
					<h4 class="font-serif font-bold text-safari-green">Luxury Fly-In</h4>
					<p class="text-xs text-charcoal/60 mt-1">Bush plane transfers between camps</p>
				</label>
				<label class="option-card">
					<input type="radio" name="travel_style" value="Private Overland">
					<h4 class="font-serif font-bold text-safari-green">Private Overland</h4>
					<p class="text-xs text-charcoal/60 mt-1">Dedicated 4x4 Land Cruiser & guide</p>
				</label>
				<label class="option-card">
					<input type="radio" name="travel_style" value="Family Adventure">
					<h4 class="font-serif font-bold text-safari-green">Family Safari</h4>
					<p class="text-xs text-charcoal/60 mt-1">Kid-friendly lodges & activities</p>
				</label>
				<label class="option-card">
					<input type="radio" name="travel_style" value="Honeymoon & Romantic">
					<h4 class="font-serif font-bold text-safari-green">Honeymoon & Romance</h4>
					<p class="text-xs text-charcoal/60 mt-1">Private dinners & plunge pools</p>
				</label>
			</div>
		</div>

		<!-- Step 5: Accommodation Comfort Level -->
		<div class="builder-step-panel" data-step="5">
			<div class="option-grid">
				<label class="option-card">
					<input type="radio" name="accommodation_type" value="Ultra Luxury Lodges">
					<h4 class="font-serif font-bold text-safari-green">Ultra-Luxury Lodges</h4>
					<p class="text-xs text-charcoal/60 mt-1">Singita, Angama, One&Only tier</p>
				</label>
				<label class="option-card">
					<input type="radio" name="accommodation_type" value="Classic Luxury Tented Camps">
					<h4 class="font-serif font-bold text-safari-green">Luxury Tented Camps</h4>
					<p class="text-xs text-charcoal/60 mt-1">Authentic canvas under wild stars</p>
				</label>
				<label class="option-card">
					<input type="radio" name="accommodation_type" value="Boutique Safari Lodges">
					<h4 class="font-serif font-bold text-safari-green">Boutique Lodges</h4>
					<p class="text-xs text-charcoal/60 mt-1">Intimate 5-star eco-comfort</p>
				</label>
			</div>
		</div>

		<!-- Step 6: Signature Experiences -->
		<div class="builder-step-panel" data-step="6">
			<div class="option-grid">
				<label class="option-card">
					<input type="checkbox" name="experiences[]" value="Hot Air Balloon Flight">
					<h4 class="font-serif font-bold text-safari-green">Hot Air Balloon</h4>
				</label>
				<label class="option-card">
					<input type="checkbox" name="experiences[]" value="Gorilla Trekking">
					<h4 class="font-serif font-bold text-safari-green">Gorilla Trekking</h4>
				</label>
				<label class="option-card">
					<input type="checkbox" name="experiences[]" value="Bush Dining">
					<h4 class="font-serif font-bold text-safari-green">Bush Dining</h4>
				</label>
				<label class="option-card">
					<input type="checkbox" name="experiences[]" value="Walking Safari">
					<h4 class="font-serif font-bold text-safari-green">Walking Safari</h4>
				</label>
			</div>
		</div>

		<!-- Step 7: Wildlife Interests -->
		<div class="builder-step-panel" data-step="7">
			<div class="option-grid">
				<label class="option-card">
					<input type="checkbox" name="wildlife[]" value="Big Five Predators">
					<h4 class="font-serif font-bold text-safari-green">Big Five Predators</h4>
				</label>
				<label class="option-card">
					<input type="checkbox" name="wildlife[]" value="Great River Crossings">
					<h4 class="font-serif font-bold text-safari-green">Migration Crossings</h4>
				</label>
				<label class="option-card">
					<input type="checkbox" name="wildlife[]" value="Primates & Gorillas">
					<h4 class="font-serif font-bold text-safari-green">Gorillas & Chimps</h4>
				</label>
			</div>
		</div>

		<!-- Step 8: Budget Range -->
		<div class="builder-step-panel" data-step="8">
			<div class="option-grid">
				<label class="option-card">
					<input type="radio" name="budget_range" value="$3,500 - $5,000 per person">
					<h4 class="font-serif font-bold text-safari-green">$3,500 - $5,000 / person</h4>
				</label>
				<label class="option-card">
					<input type="radio" name="budget_range" value="$5,000 - $8,000 per person">
					<h4 class="font-serif font-bold text-safari-green">$5,000 - $8,000 / person</h4>
				</label>
				<label class="option-card">
					<input type="radio" name="budget_range" value="$8,000+ per person">
					<h4 class="font-serif font-bold text-safari-green">$8,000+ / person</h4>
				</label>
			</div>
		</div>

		<!-- Step 9: Special Requests -->
		<div class="builder-step-panel" data-step="9">
			<p class="text-charcoal/70 text-sm mb-4"><?php esc_html_e( 'Any specific dietary requirements, celebrations, or preferences?', 'bo-safari-theme' ); ?></p>
			<textarea name="special_requests" rows="5" class="w-full p-4 bg-sand-light border border-sand rounded-lg text-sm" placeholder="e.g. Celebrating 10th anniversary, vegetarian meals..."></textarea>
		</div>

		<!-- Step 10: Contact Information -->
		<div class="builder-step-panel" data-step="10">
			<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
				<div>
					<label class="block text-xs uppercase font-semibold text-charcoal/70 mb-2"><?php esc_html_e( 'Full Name *', 'bo-safari-theme' ); ?></label>
					<input type="text" name="full_name" required class="w-full p-3.5 bg-sand-light border border-sand rounded text-sm">
				</div>
				<div>
					<label class="block text-xs uppercase font-semibold text-charcoal/70 mb-2"><?php esc_html_e( 'Email Address *', 'bo-safari-theme' ); ?></label>
					<input type="email" name="email" required class="w-full p-3.5 bg-sand-light border border-sand rounded text-sm">
				</div>
				<div>
					<label class="block text-xs uppercase font-semibold text-charcoal/70 mb-2"><?php esc_html_e( 'Phone / WhatsApp', 'bo-safari-theme' ); ?></label>
					<input type="tel" name="phone" class="w-full p-3.5 bg-sand-light border border-sand rounded text-sm">
				</div>
				<div>
					<label class="block text-xs uppercase font-semibold text-charcoal/70 mb-2"><?php esc_html_e( 'Country of Residence', 'bo-safari-theme' ); ?></label>
					<input type="text" name="country" class="w-full p-3.5 bg-sand-light border border-sand rounded text-sm">
				</div>
			</div>
		</div>

		<div class="builder-feedback mt-6"></div>

		<!-- Navigation Controls -->
		<div class="builder-nav flex items-center justify-between pt-8 mt-8 border-t border-sand">
			<button type="button" id="builder-prev-btn" class="btn-outline py-3 px-6 text-xs">
				&larr; <?php esc_html_e( 'Previous', 'bo-safari-theme' ); ?>
			</button>
			<button type="button" id="builder-next-btn" class="btn-primary py-3 px-8 text-xs">
				<?php esc_html_e( 'Next Step', 'bo-safari-theme' ); ?> &rarr;
			</button>
			<button type="submit" id="builder-submit-btn" class="btn-primary py-3 px-8 text-xs font-bold uppercase tracking-wider" style="display: none;">
				<?php esc_html_e( 'Submit Custom Safari Request', 'bo-safari-theme' ); ?>
			</button>
		</div>

	</form>
</div>

<?php
get_footer();
