<?php
/*
Plugin Name: Site Plugin for Events Task
Description: Site specific code changes for Events Task
*/
// Our custom post type function

/**
* create_posttype - A new custom post type for Events
**/
function create_posttype() {
 
    register_post_type( 'events',
    // CPT Options
        array(
            'labels' => array(
                'name' => __( 'Events' ),
                'singular_name' => __( 'Event' )
            ),
            'public' => true,
            'has_archive' => true,
            'rewrite' => array('slug' => 'events'),
            'show_in_rest' => true,
 
        )
    );
}
// Hooking up our function to theme setup
add_action( 'init', 'create_posttype' );

/*
* Creating a function to create our CPT
*/
 
function custom_post_type() {
 
// Set UI labels for Custom Post Type
    $labels = array(
        'name'                => _x( 'Events', 'Post Type General Name', 'twentytwenty' ),
        'singular_name'       => _x( 'Event', 'Post Type Singular Name', 'twentytwenty' ),
        'menu_name'           => __( 'Events', 'twentytwenty' ),
        'parent_item_colon'   => __( 'Parent Event', 'twentytwenty' ),
        'all_items'           => __( 'All Events', 'twentytwenty' ),
        'view_item'           => __( 'View Event', 'twentytwenty' ),
        'add_new_item'        => __( 'Add New Event', 'twentytwenty' ),
        'add_new'             => __( 'Add New', 'twentytwenty' ),
        'edit_item'           => __( 'Edit Event', 'twentytwenty' ),
        'update_item'         => __( 'Update Event', 'twentytwenty' ),
        'search_items'        => __( 'Search Event', 'twentytwenty' ),
        'not_found'           => __( 'Not Found', 'twentytwenty' ),
        'not_found_in_trash'  => __( 'Not found in Trash', 'twentytwenty' ),
    );
     
// Set other options for Custom Post Type
     
    $args = array(
        'label'               => __( 'events', 'twentytwenty' ),
        'description'         => __( 'Events dates and location', 'twentytwenty' ),
        'labels'              => $labels,
        // Features this CPT supports in Post Editor
        'supports'            => array( 'title', 'author', 'thumbnail', 'date', 'comments',  'editor', 'excerpt', 'revisions', 'custom-fields'),
        // You can associate this CPT with a taxonomy or custom taxonomy. 
        'taxonomies'          => array( 'genres' ),
        /* A hierarchical CPT is like Pages and can have
        * Parent and child items. A non-hierarchical CPT
        * is like Posts.
        */ 
        'hierarchical'        => true,
        'public'              => true,
        'show_ui'             => true,
        'show_in_menu'        => true,
        'show_in_nav_menus'   => true,
        'show_in_admin_bar'   => true,
        'menu_position'       => 1,
        'can_export'          => true,
        'has_archive'         => true,
        'exclude_from_search' => false,
        'publicly_queryable'  => true,
        'capability_type'     => 'post',
        'show_in_rest' => true
 
    );
     
    // Registering your Custom Post Type
    register_post_type( 'events', $args );
 
}


/* Hook into the 'init' action so that the function
* Containing our post type registration is not 
* unnecessarily executed. 
*/
 
add_action( 'init', 'custom_post_type', 0 );

// Add the custom columns to the events post type:

function set_custom_edit_event_columns($columns) {
    unset( $columns['author'] );
    unset( $columns['date'] );
    unset( $columns['comments'] );
    $columns['event_location'] = 'Location';
    $columns['event_date'] = 'Event date';
    $columns['event_url'] = __( 'URL', 'http://localhost/events/' );

    return $columns;
}
add_filter( 'manage_events_posts_columns', 'set_custom_edit_event_columns' );

// Add the data to the custom columns for the book post type:
function custom_event_column( $column, $post_id ) {
    switch ( $column ) {

        case 'event_location' :
            $terms = get_the_term_list( $post_id , 'event_location' , '' , ',' , '' );
            if ( is_string( $terms ) )
                echo $terms;
            else
                _e( 'Unable to get event location(s)', 'your_text_domain' );
            break;

        case 'event_url' :
            echo get_post_meta( $post_id , 'event_url' , true ); 
            break;
			
		case 'event_date' :
            echo get_post_meta( $post_id , 'event_date' , true ); 
            break;

    }
}

add_action( 'manage_events_posts_custom_column' , 'custom_event_column', 10, 2 );


?>