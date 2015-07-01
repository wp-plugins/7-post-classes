<?php
/*
Plugin Name: 7 Post Classes
Plugin URI: http://www.7listings.net
Description: Remove generated taxonomy post classes for posts
Version: 1.0.0
Author: 7 Listings
Author URI: http://www.7listings.net
*/

class Sl_Post_Classes
{
	/**
	 * Constructor
	 */
	public function __construct()
	{
		add_filter( 'post_class', array( $this, 'post_class' ) );
	}

	/**
	 * Remove post classes for all taxonomies (except categories) for posts
	 *
	 * @param $classes
	 *
	 * @return array
	 */
	public function post_class( $classes )
	{
		// Use static variable so we don't have to get taxonomies, tersm twice
		static $class_remove = null;

		// Get taxonomies and terms first time
		if ( null === $class_remove )
		{
			$class_remove = array();
			$taxonomies = get_taxonomies( array(), 'names', 'and' );
			foreach ( $taxonomies as $taxonomy )
			{
				if ( 'category' == $taxonomy )
					continue;

				$terms = get_terms( $taxonomy, array() );
				foreach ( $terms as $term )
				{
					$class_remove[] = $taxonomy . '-' . $term->slug;
				}
			}
		}

		$classes = array_diff( $classes, $class_remove );
		return $classes;
	}
}

new Sl_Post_Classes;
