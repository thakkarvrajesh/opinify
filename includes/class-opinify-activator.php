<?php
/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0
 * @package    Opinify
 * @author     Vrajesh Thakkar
 */

class Opinify_Activator {

	public static function activate() {

		// Call the opinify_register_post_type method
        self::opinify_register_post_type();

	}

	public static function opinify_register_post_type() {

		// Register Custom Post Type Opinify Review.
		register_post_type( 'opinify-reviews',
            array(
                'labels' => array(
                    'name' => _x( 'Opinify Reviews', 'Post Type General Name', 'opinify' ),
					'singular_name' => _x( 'Opinify Review', 'Post Type Singular Name', 'opinify' ),
					'menu_name' => _x( 'Opinify Reviews', 'Admin Menu text', 'opinify' ),
					'name_admin_bar' => _x( 'Opinify Review', 'Add New on Toolbar', 'opinify' ),
					'archives' => __( 'Opinify Review Archives', 'opinify' ),
					'attributes' => __( 'Opinify Review Attributes', 'opinify' ),
					'parent_item_colon' => __( 'Parent Opinify Review:', 'opinify' ),
					'all_items' => __( 'All Opinify Reviews', 'opinify' ),
					'add_new_item' => __( 'Add New Opinify Review', 'opinify' ),
					'add_new' => __( 'Add New', 'opinify' ),
					'new_item' => __( 'New Opinify Review', 'opinify' ),
					'edit_item' => __( 'Edit Opinify Review', 'opinify' ),
					'update_item' => __( 'Update Opinify Review', 'opinify' ),
					'view_item' => __( 'View Opinify Review', 'opinify' ),
					'view_items' => __( 'View Opinify Reviews', 'opinify' ),
					'search_items' => __( 'Search Opinify Review', 'opinify' ),
					'not_found' => __( 'Not found', 'opinify' ),
					'not_found_in_trash' => __( 'Not found in Trash', 'opinify' ),
					'featured_image' => __( 'Featured Image', 'opinify' ),
					'set_featured_image' => __( 'Set featured image', 'opinify' ),
					'remove_featured_image' => __( 'Remove featured image', 'opinify' ),
					'use_featured_image' => __( 'Use as featured image', 'opinify' ),
					'insert_into_item' => __( 'Insert into Opinify Review', 'opinify' ),
					'uploaded_to_this_item' => __( 'Uploaded to this Opinify Review', 'opinify' ),
					'items_list' => __( 'Opinify Reviews list', 'opinify' ),
					'items_list_navigation' => __( 'Opinify Reviews list navigation', 'opinify' ),
					'filter_items_list' => __( 'Filter Opinify Reviews list', 'opinify' ),
                ),
				'label' => __( 'Opinify Review', 'opinify' ),
				'description' => __( '', 'opinify' ),
                'menu_icon' => 'dashicons-testimonial',
				'supports' => array('title', 'editor', 'thumbnail', 'custom-fields'),
				'taxonomies' => array(),
				'public' => true,
				'show_ui' => true,
				'show_in_menu' => true,
				'menu_position' => 5,
				'show_in_admin_bar' => true,
				'show_in_nav_menus' => true,
				'can_export' => true,
				'has_archive' => true,
				'hierarchical' => false,
				'exclude_from_search' => true,
				'show_in_rest' => true,
				'publicly_queryable' => true,
				'capability_type' => 'post',
                'rewrite' => array('slug' => 'opinify-reviews'),
            )
        );

	}

}
