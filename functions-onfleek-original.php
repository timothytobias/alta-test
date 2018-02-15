<?php

/**
 * Glossy Child Theme Function File
 */

/** example for add new social media network **/

add_filter( 'display_posts_shortcode_output', 'be_display_posts_kicker', 10, 9 );
/**
 * Add Time to Display Posts Shortcode
 * @author Bill Erickson
 * @link http://www.billerickson.net/code/add-time-to-display-posts-shortcode/
 *
 * @param $output string, the original markup for an individual post
 * @param $atts array, all the attributes passed to the shortcode
 * @param $image string, the image part of the output
 * @param $title string, the title part of the output
 * @param $date string, the date part of the output
 * @param $excerpt string, the excerpt part of the output
 * @param $inner_wrapper string, what html element to wrap each post in (default is li)
 * @param $content string, post content
 * @param $class array, post classes
 * @return $output string, the modified markup for an individual post
 */

/* added this action to ensure that child theme changes are written after the parent theme.*/
add_action( 'wp_enqueue_scripts', 'my_theme_enqueue_styles' );
function my_theme_enqueue_styles() {

    $parent_style = 'parent-style'; // This is 'twentyfifteen-style' for the Twenty Fifteen theme.

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css' );
    wp_enqueue_style( 'child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style ),
        wp_get_theme()->get('Version')
    );
}
/* end of action added to enqueue theme style scripts*/


function be_display_posts_kicker( $output, $atts, $image, $title, $date, $excerpt, $inner_wrapper, $content, $class ) {
	// Find out if 'include_time=true' was added to  the shortcode
	$kicker = '';
	if( isset( $atts['include_kicker'] ) ){
	if (in_category('reviews')){
	$categories = wp_get_post_categories( get_the_ID() );
	foreach ($categories as $category){
	$cat_name = get_cat_name($category);
	if ($cat_name != 'Reviews'){
	$kicker_link = get_category_link( $category );
	$kicker = '<a href="' . $kicker_link . '">' . get_cat_name($category) . '</a>';

	}
	}
	}else{
		$kicker = get_post_meta ( get_the_ID(), 'df_magz_post_subtitle', true );
		}
		}
	$caption = '';
	if( isset( $atts['include_caption'] ) ){
		$caption = get_the_post_thumbnail_caption();
		}
		$direction = '';
		if( isset( $atts['include_direction'] ) ){
			$direction = get_post_meta ( get_the_ID(), 'df_magz_post_featured_content_layout', true );
			}
	// Now let's rebuild the output and add the $time to it
	$output = '<' . $inner_wrapper . ' class="' . $direction . ' ' . implode( ' ', $class ) . '"><div class="list-image">' . $image . '</div><div class="caption">' . $caption . '</div><div class="list-content-wrapper"><div class="list-content"><div class="list-kicker subtitle"><h5>' . $kicker. '</h5></div><h4 class="list-title article-title">' . $title . '</h4>' . $date . $excerpt . $content . '</div></div></' . $inner_wrapper . '>';
	// Finally we'll return the modified output
	return $output;
}

function deck_headline_meta_box() {

    add_meta_box(
        'deck-headline',
        __( 'Deck Headline', 'sitepoint' ),
        'deck_headline_meta_box_callback',
        'post',
        'normal',
        'high'
    );
}

add_action( 'add_meta_boxes', 'deck_headline_meta_box' );



function by_line_meta_box() {

    add_meta_box(
        'by-line',
        __( 'By Line', 'sitepoint' ),
        'by_line_meta_box_callback',
        'post',
        'normal',
        'high'
    );
}

add_action( 'add_meta_boxes', 'by_line_meta_box' );

function slider_order_meta_box() {

    add_meta_box(
        'slider-order',
        __( 'Slider Order', 'sitepoint' ),
        'slider_order_meta_box_callback',
        'post',
        'normal',
        'high'
    );
}

add_action( 'add_meta_boxes', 'slider_order_meta_box' );

function slider_deck_headline_meta_box() {

    add_meta_box(
        'slider-deck-headline',
        __( 'Slider Deck Headline', 'sitepoint' ),
        'slider_deck_headline_meta_box_callback',
        'post',
        'normal',
        'high'
    );
}

add_action( 'add_meta_boxes', 'slider_deck_headline_meta_box' );

function slider_title_meta_box() {

    add_meta_box(
        'slider-title',
        __( 'Slider Title', 'sitepoint' ),
        'slider_title_meta_box_callback',
        'post',
        'normal',
        'high'
    );
}

add_action( 'add_meta_boxes', 'slider_title_meta_box' );

function slider_kicker_meta_box() {

    add_meta_box(
        'slider-kicker-headline',
        __( 'Slider Kicker', 'sitepoint' ),
        'slider_kicker_meta_box_callback',
        'post',
        'normal',
        'high'
    );
}

add_action( 'add_meta_boxes', 'slider_kicker_meta_box' );


function deck_headline_meta_box_callback( $post ) {

    // Add a nonce field so we can check for it later.
    wp_nonce_field( 'deck_headline_nonce', 'deck_headline_nonce' );

    $value = get_post_meta( $post->ID, '_deck_headline', true );

    echo '<textarea style="width:100%" id="deck_headline" name="deck_headline">' . esc_attr( $value ) . '</textarea>';
}

function by_line_meta_box_callback( $post ) {

    // Add a nonce field so we can check for it later.
    wp_nonce_field( 'by_line_nonce', 'by_line_nonce' );

    $value = get_post_meta( $post->ID, '_by_line', true );

		echo '<textarea style="width:100%" id="by_line" name="by_line">' . esc_attr( $value ) . '</textarea>';
}

function slider_order_meta_box_callback( $post ) {

    // Add a nonce field so we can check for it later.
    wp_nonce_field( 'slider_order_nonce', 'slider_order_nonce' );

    $value = get_post_meta( $post->ID, '_slider_order', true );

		echo '<input type="number" name="slider_order" min="0" max="3" value="'. esc_attr( $value ) . '" />';
}

function slider_title_meta_box_callback( $post ) {

    // Add a nonce field so we can check for it later.
    wp_nonce_field( 'slider_title_nonce', 'slider_title_nonce' );

    $value = get_post_meta( $post->ID, '_slider_title', true );

		echo '<textarea style="width:100%" id="slider_title" name="slider_title">' . esc_attr( $value ) . '</textarea>';
}

function slider_deck_headline_meta_box_callback( $post ) {

    // Add a nonce field so we can check for it later.
    wp_nonce_field( 'slider_deck_headline_nonce', 'slider_deck_headline_nonce' );

    $value = get_post_meta( $post->ID, '_slider_deck_headline', true );

		echo '<textarea style="width:100%" id="slider_deck_headline" name="slider_deck_headline">' . esc_attr( $value ) . '</textarea>';
}

function slider_kicker_meta_box_callback( $post ) {

    // Add a nonce field so we can check for it later.
    wp_nonce_field( 'slider_kicker_nonce', 'slider_kicker_nonce' );

    $value = get_post_meta( $post->ID, '_slider_kicker', true );

		echo '<textarea style="width:100%" id="slider_kicker" name="slider_kicker">' . esc_attr( $value ) . '</textarea>';
}



/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id
 */

function save_deck_headline_meta_box_data( $post_id ) {

    // Check if our nonce is set.
    if ( ! isset( $_POST['deck_headline_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['deck_headline_nonce'], 'deck_headline_nonce' ) ) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }

    }
    else {

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }

    /* OK, it's safe for us to save the data now. */

    // Make sure that it is set.
    if ( ! isset( $_POST['deck_headline'] ) ) {
        return;
    }

    // Sanitize user input.
    $my_data = sanitize_text_field( $_POST['deck_headline'] );

    // Update the meta field in the database.
    update_post_meta( $post_id, '_deck_headline', $my_data );
}

add_action( 'save_post', 'save_deck_headline_meta_box_data' );

function save_slider_deck_headline_meta_box_data( $post_id ) {

    // Check if our nonce is set.
    if ( ! isset( $_POST['slider_deck_headline_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['slider_deck_headline_nonce'], 'slider_deck_headline_nonce' ) ) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }

    }
    else {

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }

    /* OK, it's safe for us to save the data now. */

    // Make sure that it is set.
    if ( ! isset( $_POST['slider_deck_headline'] ) ) {
        return;
    }

    // Sanitize user input.
    $my_data = sanitize_text_field( $_POST['slider_deck_headline'] );

    // Update the meta field in the database.
    update_post_meta( $post_id, '_slider_deck_headline', $my_data );
}

add_action( 'save_post', 'save_slider_deck_headline_meta_box_data' );

function save_slider_kicker_meta_box_data( $post_id ) {

    // Check if our nonce is set.
    if ( ! isset( $_POST['slider_kicker_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['slider_kicker_nonce'], 'slider_kicker_nonce' ) ) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }

    }
    else {

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }

    /* OK, it's safe for us to save the data now. */

    // Make sure that it is set.
    if ( ! isset( $_POST['slider_kicker'] ) ) {
        return;
    }

    // Sanitize user input.
    $my_data = sanitize_text_field( $_POST['slider_kicker'] );

    // Update the meta field in the database.
    update_post_meta( $post_id, '_slider_kicker', $my_data );
}

add_action( 'save_post', 'save_slider_kicker_meta_box_data' );

function save_slider_title_meta_box_data( $post_id ) {

    // Check if our nonce is set.
    if ( ! isset( $_POST['slider_title_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['slider_title_nonce'], 'slider_title_nonce' ) ) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }

    }
    else {

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }

    /* OK, it's safe for us to save the data now. */

    // Make sure that it is set.
    if ( ! isset( $_POST['slider_title'] ) ) {
        return;
    }

    // Sanitize user input.
    $my_data = sanitize_text_field( $_POST['slider_title'] );

    // Update the meta field in the database.
    update_post_meta( $post_id, '_slider_title', $my_data );
}

add_action( 'save_post', 'save_slider_title_meta_box_data' );



function save_by_line_meta_box_data( $post_id ) {

    // Check if our nonce is set.
    if ( ! isset( $_POST['by_line_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['by_line_nonce'], 'by_line_nonce' ) ) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }

    }
    else {

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }

    /* OK, it's safe for us to save the data now. */

    // Make sure that it is set.
    if ( ! isset( $_POST['by_line'] ) ) {
        return;
    }

    // Sanitize user input.
    $my_data = sanitize_text_field( $_POST['by_line'] );

    // Update the meta field in the database.
    update_post_meta( $post_id, '_by_line', $my_data );
}

add_action( 'save_post', 'save_by_line_meta_box_data' );

function save_slider_order_meta_box_data( $post_id ) {

    // Check if our nonce is set.
    if ( ! isset( $_POST['slider_order_nonce'] ) ) {
        return;
    }

    // Verify that the nonce is valid.
    if ( ! wp_verify_nonce( $_POST['slider_order_nonce'], 'slider_order_nonce' ) ) {
        return;
    }

    // If this is an autosave, our form has not been submitted, so we don't want to do anything.
    if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
        return;
    }

    // Check the user's permissions.
    if ( isset( $_POST['post_type'] ) && 'page' == $_POST['post_type'] ) {

        if ( ! current_user_can( 'edit_page', $post_id ) ) {
            return;
        }

    }
    else {

        if ( ! current_user_can( 'edit_post', $post_id ) ) {
            return;
        }
    }

    /* OK, it's safe for us to save the data now. */

    // Make sure that it is set.
    if ( ! isset( $_POST['slider_order'] ) ) {
        return;
    }

    // Sanitize user input.
    $my_data = sanitize_text_field( $_POST['slider_order'] );

    // Update the meta field in the database.
    update_post_meta( $post_id, '_slider_order', $my_data );
}

add_action( 'save_post', 'save_slider_order_meta_box_data' );

function wp_get_attachment( $attachment_id ) {

$attachment = get_post( $attachment_id );
return array(
    'alt' => get_post_meta( $attachment->ID, '_wp_attachment_image_alt', true ),
    'caption' => $attachment->post_excerpt,
    'description' => $attachment->post_content,
    'href' => get_permalink( $attachment->ID ),
    'src' => $attachment->guid,
    'title' => $attachment->post_title
);
}

function modify_slider_order($query, $slider_id) {

    // only alter the order for slider with "x" ID
    // http://tinyurl.com/zb6hzpc
    if($slider_id == 8) {

				$query['meta_key'] = '_slider_order';

        // Order by Custom Meta values
        $query['orderby'] = '_slider_order';

        // Calculate order based on:
        // 'NUMERIC', 'CHAR', 'DATE', 'DATETIME', 'TIME'
        $query['meta_type'] = 'NUMERIC';

    }

    return $query;

}

add_filter('revslider_get_posts', 'modify_slider_order', 10, 2);

function pippin_get_image_id($image_url) {
	global $wpdb;
	$attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url ));
        return $attachment[0];
}
