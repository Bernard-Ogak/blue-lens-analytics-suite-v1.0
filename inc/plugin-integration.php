<?php
/**
 * B.O-Safari-Plugin Integration & Data Abstraction Layer
 *
 * Provides safe API wrappers for safari CPTs, pricing, reviews, destinations,
 * accommodation, enquiries, and bookings with graceful mock fallbacks when the plugin is inactive.
 *
 * @package B.O-Safari-theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Check if B.O-Safari-Plugin is active
 *
 * @return bool
 */
function bo_safari_is_plugin_active() {
	return class_exists( 'BO_Safari_Plugin' ) || function_exists( 'bo_safari_plugin_init' ) || defined( 'BO_SAFARI_PLUGIN_VERSION' );
}

/**
 * Get Safaris list
 *
 * @param array $args Query arguments.
 * @return array List of safari objects/posts.
 */
function bo_safari_get_safaris( $args = array() ) {
	if ( bo_safari_is_plugin_active() && function_exists( 'bo_safari_api_get_safaris' ) ) {
		return bo_safari_api_get_safaris( $args );
	}

	// Query standard CPT if registered
	$default_args = array(
		'post_type'      => 'safari',
		'posts_per_page' => isset( $args['posts_per_page'] ) ? $args['posts_per_page'] : 6,
		'post_status'    => 'publish',
	);

	$query = new WP_Query( wp_parse_args( $args, $default_args ) );

	if ( $query->have_posts() ) {
		$results = array();
		while ( $query->have_posts() ) {
			$query->the_post();
			$results[] = array(
				'id'           => get_the_ID(),
				'title'        => get_the_title(),
				'permalink'    => get_permalink(),
				'thumbnail'    => get_the_post_thumbnail_url( get_the_ID(), 'safari-card' ),
				'destination'  => get_post_meta( get_the_ID(), '_safari_destination', true ) ?: 'Serengeti & Masai Mara',
				'duration'     => get_post_meta( get_the_ID(), '_safari_duration', true ) ?: '7 Days / 6 Nights',
				'price'        => get_post_meta( get_the_ID(), '_safari_price', true ) ?: '3,850',
				'currency'     => get_post_meta( get_the_ID(), '_safari_currency', true ) ?: 'USD',
				'rating'       => get_post_meta( get_the_ID(), '_safari_rating', true ) ?: '4.95',
				'review_count' => get_post_meta( get_the_ID(), '_safari_reviews', true ) ?: '128',
				'style'        => get_post_meta( get_the_ID(), '_safari_style', true ) ?: 'Luxury Private',
				'badge'        => get_post_meta( get_the_ID(), '_safari_badge', true ) ?: 'Bestseller',
				'excerpt'      => get_the_excerpt(),
			);
		}
		wp_reset_postdata();
		return $results;
	}

	// Authentic Mock Fallback Data when plugin is missing or no posts created yet
	return array(
		array(
			'id'           => 101,
			'title'        => 'The Great Migration & Serengeti Wonders',
			'permalink'    => '#',
			'thumbnail'    => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&w=800&q=80',
			'destination'  => 'Tanzania (Serengeti & Ngorongoro)',
			'duration'     => '8 Days / 7 Nights',
			'price'        => '4,250',
			'currency'     => 'USD',
			'rating'       => '4.98',
			'review_count' => '142',
			'style'        => 'Luxury Private',
			'badge'        => 'Most Popular',
			'excerpt'      => 'Witness millions of wildebeest and zebras crossing the Mara River in unmatched luxury lodge comfort.',
		),
		array(
			'id'           => 102,
			'title'        => 'Ultimate Masai Mara & Big Five Fly-In Safari',
			'permalink'    => '#',
			'thumbnail'    => 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?auto=format&fit=crop&w=800&q=80',
			'destination'  => 'Kenya (Masai Mara & Amboseli)',
			'duration'     => '6 Days / 5 Nights',
			'price'        => '3,650',
			'currency'     => 'USD',
			'rating'       => '4.96',
			'review_count' => '98',
			'style'        => 'Fly-In Luxury',
			'badge'        => 'Signature',
			'excerpt'      => 'Shorter flight transfers between Amboseli’s majestic elephants and the lion territory of Masai Mara.',
		),
		array(
			'id'           => 103,
			'title'        => 'Rwanda Gorilla Trekking & Virunga Highlands',
			'permalink'    => '#',
			'thumbnail'    => 'https://images.unsplash.com/photo-1534177616072-ef7dc120449d?auto=format&fit=crop&w=800&q=80',
			'destination'  => 'Rwanda (Volcanoes National Park)',
			'duration'     => '5 Days / 4 Nights',
			'price'        => '5,900',
			'currency'     => 'USD',
			'rating'       => '5.0',
			'review_count' => '76',
			'style'        => 'Exclusive Eco-Luxe',
			'badge'        => 'Bucket List',
			'excerpt'      => 'An unforgettable encounter with mountain gorillas in lush cloud forests, stayed at world-class sanctuary lodges.',
		),
		array(
			'id'           => 104,
			'title'        => 'Grand East Africa Odyssey (Kenya & Tanzania)',
			'permalink'    => '#',
			'thumbnail'    => 'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?auto=format&fit=crop&w=800&q=80',
			'destination'  => 'Kenya & Tanzania',
			'duration'     => '12 Days / 11 Nights',
			'price'        => '7,800',
			'currency'     => 'USD',
			'rating'       => '4.99',
			'review_count' => '115',
			'style'        => 'Grand Luxury',
			'badge'        => 'Exclusive',
			'excerpt'      => 'Combine Kenya’s Mara and Amboseli with Tanzania’s Ngorongoro Crater and Serengeti National Park.',
		),
	);
}

/**
 * Get Destinations list
 *
 * @param int $limit Number of destinations.
 * @return array
 */
function bo_safari_get_destinations( $limit = 6 ) {
	if ( bo_safari_is_plugin_active() && function_exists( 'bo_safari_api_get_destinations' ) ) {
		return bo_safari_api_get_destinations( $limit );
	}

	return array(
		array(
			'title'       => 'Serengeti National Park',
			'country'     => 'Tanzania',
			'image'       => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&w=800&q=80',
			'safari_count'=> '14 Safaris',
			'highlights'  => 'Great Migration, Big Cat Predators, Endless Plains',
			'permalink'   => '#',
		),
		array(
			'title'       => 'Masai Mara National Reserve',
			'country'     => 'Kenya',
			'image'       => 'https://images.unsplash.com/photo-1547471080-7cc2caa01a7e?auto=format&fit=crop&w=800&q=80',
			'safari_count'=> '18 Safaris',
			'highlights'  => 'River Crossings, Big Five, Maasai Culture',
			'permalink'   => '#',
		),
		array(
			'title'       => 'Volcanoes National Park',
			'country'     => 'Rwanda',
			'image'       => 'https://images.unsplash.com/photo-1534177616072-ef7dc120449d?auto=format&fit=crop&w=800&q=80',
			'safari_count'=> '6 Safaris',
			'highlights'  => 'Gorilla Trekking, Golden Monkeys, Virunga Volcanoes',
			'permalink'   => '#',
		),
		array(
			'title'       => 'Ngorongoro Crater',
			'country'     => 'Tanzania',
			'image'       => 'https://images.unsplash.com/photo-1518709268805-4e9042af9f23?auto=format&fit=crop&w=800&q=80',
			'safari_count'=> '11 Safaris',
			'highlights'  => 'UNESCO Caldera, Dense Rhino Population, Flamingos',
			'permalink'   => '#',
		),
		array(
			'title'       => 'Amboseli National Park',
			'country'     => 'Kenya',
			'image'       => 'https://images.unsplash.com/photo-1523805009345-7448845a9e53?auto=format&fit=crop&w=800&q=80',
			'safari_count'=> '9 Safaris',
			'highlights'  => 'Mt. Kilimanjaro Views, Big Elephant Herds',
			'permalink'   => '#',
		),
		array(
			'title'       => 'Bwindi Impenetrable Forest',
			'country'     => 'Uganda',
			'image'       => 'https://images.unsplash.com/photo-1544735716-392fe2489ffa?auto=format&fit=crop&w=800&q=80',
			'safari_count'=> '8 Safaris',
			'highlights'  => 'Mountain Gorillas, Primitive Rainforest, Birdwatching',
			'permalink'   => '#',
		),
	);
}

/**
 * Get Signature Experiences
 *
 * @return array
 */
function bo_safari_get_experiences() {
	if ( bo_safari_is_plugin_active() && function_exists( 'bo_safari_api_get_experiences' ) ) {
		return bo_safari_api_get_experiences();
	}

	return array(
		array(
			'title'       => 'Hot Air Balloon Safari',
			'category'    => 'Aerial Adventure',
			'image'       => 'https://images.unsplash.com/photo-1507608616759-54f48f0af0ee?auto=format&fit=crop&w=800&q=80',
			'description' => 'Drift gently over the savannah at dawn followed by a champagne bush breakfast.',
			'permalink'   => '#',
		),
		array(
			'title'       => 'Mountain Gorilla Trekking',
			'category'    => 'Primate Encounter',
			'image'       => 'https://images.unsplash.com/photo-1534177616072-ef7dc120449d?auto=format&fit=crop&w=800&q=80',
			'description' => 'Stand face to face with majestic mountain gorillas in the misty Virunga rainforest.',
			'permalink'   => '#',
		),
		array(
			'title'       => 'Private Sunset Bush Dining',
			'category'    => 'Culinary & Romance',
			'image'       => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=800&q=80',
			'description' => 'Gourmet 5-course cuisine illuminated by lanterns under the star-lit African sky.',
			'permalink'   => '#',
		),
		array(
			'title'       => 'Guided Bush Walking Safaris',
			'category'    => 'Immersive Nature',
			'image'       => 'https://images.unsplash.com/photo-1516426122078-c23e76319801?auto=format&fit=crop&w=800&q=80',
			'description' => 'Track wildlife on foot with armed expert rangers and indigenous Maasai guides.',
			'permalink'   => '#',
		),
	);
}

/**
 * Get Luxury Accommodations
 *
 * @return array
 */
function bo_safari_get_accommodations() {
	if ( bo_safari_is_plugin_active() && function_exists( 'bo_safari_api_get_accommodations' ) ) {
		return bo_safari_api_get_accommodations();
	}

	return array(
		array(
			'title'       => 'Singita Mara River Tented Camp',
			'destination' => 'Lamai Triangle, Serengeti',
			'type'        => 'Luxury Tented Camp',
			'rating'      => '5.0',
			'image'       => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=800&q=80',
			'permalink'   => '#',
		),
		array(
			'title'       => 'Angama Mara',
			'destination' => 'Masai Mara Escarpment, Kenya',
			'type'        => 'Ultra-Luxe Lodge',
			'rating'      => '4.98',
			'image'       => 'https://images.unsplash.com/photo-1582719508461-905c673771fd?auto=format&fit=crop&w=800&q=80',
			'permalink'   => '#',
		),
		array(
			'title'       => 'Bisate Lodge',
			'destination' => 'Volcanoes National Park, Rwanda',
			'type'        => 'Forest Sanctuary',
			'rating'      => '5.0',
			'image'       => 'https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=800&q=80',
			'permalink'   => '#',
		),
	);
}

/**
 * Get Traveller Reviews & Ratings
 *
 * @return array
 */
function bo_safari_get_reviews() {
	if ( bo_safari_is_plugin_active() && function_exists( 'bo_safari_api_get_reviews' ) ) {
		return bo_safari_api_get_reviews();
	}

	return array(
		array(
			'author'      => 'Eleanor & Lord Harrington',
			'country'     => 'United Kingdom',
			'tour'        => '12-Day Grand East Africa Odyssey',
			'rating'      => 5,
			'platform'    => 'TripAdvisor',
			'date'        => 'February 2026',
			'text'        => 'An extraordinary experience from start to finish. The attention to detail, private air transfers, and lodge selections were unmatched. Our guide Patrick spotted the Big Five within our first 24 hours!',
			'avatar'      => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=150&q=80',
		),
		array(
			'author'      => 'Dr. Robert Vance',
			'country'     => 'United States',
			'tour'        => 'Rwanda Gorilla & Serengeti Fly-In',
			'rating'      => 5,
			'platform'    => 'SafariBookings',
			'date'        => 'January 2026',
			'text'        => 'Standing 10 meters away from a silverback gorilla in Volcanoes NP was the spiritual highlight of my life. The team handled every detail seamlessly. World-class hospitality.',
			'avatar'      => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=150&q=80',
		),
		array(
			'author'      => 'Sophie & Marcus Weber',
			'country'     => 'Germany',
			'tour'        => '7-Day Migration Luxury Safari',
			'rating'      => 5,
			'platform'    => 'Google Reviews',
			'date'        => 'December 2025',
			'text'        => 'We celebrated our 20th anniversary on safari. The private candlelit dinner under the stars in Mara North Conservancy was magical. Flawless organization.',
			'avatar'      => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=150&q=80',
		),
	);
}

/**
 * Get External Review Platform Badges
 *
 * @return array
 */
function bo_safari_get_external_platforms() {
	return array(
		array(
			'name'   => 'TripAdvisor',
			'rating' => '5.0 / 5',
			'badge'  => 'Travelers’ Choice Best of the Best 2026',
			'reviews'=> '380+ Verified Reviews',
		),
		array(
			'name'   => 'SafariBookings',
			'rating' => '4.98 / 5',
			'badge'  => 'Top-Rated African Safari Operator',
			'reviews'=> '240+ Verified Reviews',
		),
		array(
			'name'   => 'Google Reviews',
			'rating' => '4.9 / 5',
			'badge'  => '5-Star Excellence Rating',
			'reviews'=> '190+ Verified Reviews',
		),
		array(
			'name'   => 'Viator & Booking.com',
			'rating' => '4.95 / 5',
			'badge'  => 'Premier Luxury Partner',
			'reviews'=> '150+ Verified Reviews',
		),
	);
}

/**
 * Handle AJAX Enquiry Form Submission
 */
function bo_safari_handle_ajax_enquiry() {
	check_ajax_referer( 'bo_safari_nonce', 'nonce' );

	$name    = isset( $_POST['full_name'] ) ? sanitize_text_field( $_POST['full_name'] ) : '';
	$email   = isset( $_POST['email'] ) ? sanitize_email( $_POST['email'] ) : '';
	$phone   = isset( $_POST['phone'] ) ? sanitize_text_field( $_POST['phone'] ) : '';
	$safari  = isset( $_POST['safari_title'] ) ? sanitize_text_field( $_POST['safari_title'] ) : '';
	$message = isset( $_POST['message'] ) ? sanitize_textarea_field( $_POST['message'] ) : '';

	if ( empty( $name ) || empty( $email ) ) {
		wp_send_json_error( array( 'message' => esc_html__( 'Please fill in all required fields.', 'bo-safari-theme' ) ) );
	}

	// Forward enquiry to B.O-Safari-Plugin if present
	if ( bo_safari_is_plugin_active() && function_exists( 'bo_safari_save_enquiry' ) ) {
		bo_safari_save_enquiry( compact( 'name', 'email', 'phone', 'safari', 'message' ) );
	} else {
		// Log or send admin email as standard WP fallback
		$admin_email = get_option( 'admin_email' );
		$subject     = sprintf( esc_html__( 'New Safari Enquiry: %s', 'bo-safari-theme' ), $safari ?: 'General' );
		$body        = "Name: $name\nEmail: $email\nPhone: $phone\nSafari: $safari\nMessage:\n$message";
		wp_mail( $admin_email, $subject, $body );
	}

	wp_send_json_success( array(
		'message' => esc_html__( 'Thank you! Your safari enquiry has been received. Our luxury travel concierge will contact you within 24 hours.', 'bo-safari-theme' ),
	) );
}
add_action( 'wp_ajax_bo_safari_submit_enquiry', 'bo_safari_handle_ajax_enquiry' );
add_action( 'wp_ajax_nopriv_bo_safari_submit_enquiry', 'bo_safari_handle_ajax_enquiry' );

/**
 * Handle AJAX Custom Safari Builder Submission
 */
function bo_safari_handle_ajax_custom_builder() {
	check_ajax_referer( 'bo_safari_nonce', 'nonce' );

	$destination   = isset( $_POST['destination'] ) ? sanitize_text_field( $_POST['destination'] ) : '';
	$travel_dates  = isset( $_POST['travel_dates'] ) ? sanitize_text_field( $_POST['travel_dates'] ) : '';
	$adults        = isset( $_POST['adults'] ) ? sanitize_text_field( $_POST['adults'] ) : '2';
	$children      = isset( $_POST['children'] ) ? sanitize_text_field( $_POST['children'] ) : '0';
	$travel_style  = isset( $_POST['travel_style'] ) ? sanitize_text_field( $_POST['travel_style'] ) : '';
	$accommodation = isset( $_POST['accommodation_type'] ) ? sanitize_text_field( $_POST['accommodation_type'] ) : '';
	$budget        = isset( $_POST['budget_range'] ) ? sanitize_text_field( $_POST['budget_range'] ) : '';
	$name          = isset( $_POST['full_name'] ) ? sanitize_text_field( $_POST['full_name'] ) : '';
	$email         = isset( $_POST['email'] ) ? sanitize_email( $_POST['email'] ) : '';
	$phone         = isset( $_POST['phone'] ) ? sanitize_text_field( $_POST['phone'] ) : '';
	$notes         = isset( $_POST['special_requests'] ) ? sanitize_textarea_field( $_POST['special_requests'] ) : '';

	if ( empty( $name ) || empty( $email ) ) {
		wp_send_json_error( array( 'message' => esc_html__( 'Please complete contact details.', 'bo-safari-theme' ) ) );
	}

	// Forward request to plugin or send admin email
	$admin_email = get_option( 'admin_email' );
	$subject     = sprintf( esc_html__( 'Custom Safari Request from %s', 'bo-safari-theme' ), $name );
	$body        = "Custom Safari Details:\n" .
				   "Destination: $destination\n" .
				   "Dates: $travel_dates\n" .
				   "Travellers: $adults Adults, $children Children\n" .
				   "Style: $travel_style\n" .
				   "Accommodation: $accommodation\n" .
				   "Budget Range: $budget\n" .
				   "Contact Name: $name\n" .
				   "Email: $email\n" .
				   "Phone: $phone\n" .
				   "Notes:\n$notes";

	wp_mail( $admin_email, $subject, $body );

	wp_send_json_success( array(
		'message' => esc_html__( 'Your custom safari request has been submitted successfully! One of our senior trip architects will craft a personalized itinerary for you.', 'bo-safari-theme' ),
	) );
}
add_action( 'wp_ajax_bo_safari_submit_custom_builder', 'bo_safari_handle_ajax_custom_builder' );
add_action( 'wp_ajax_nopriv_bo_safari_submit_custom_builder', 'bo_safari_handle_ajax_custom_builder' );
