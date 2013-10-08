<?php
/**
Description: Adds a taxonomy filter in the admin list page for a custom post type.
Written for: http://wordpress.stackexchange.com/posts/582/
By: Mike Schinkel - http://mikeschinkel.com/custom-workpress-plugins
Instructions: Put this code in your theme's functions.php file or inside your own plugin. Edit to suite your post types and taxonomies. Hope this helps...
 */
add_filter('manage_listing_posts_columns', 'add_businesses_column_to_listing_list');
function add_businesses_column_to_listing_list( $posts_columns ) {
  if (!isset($posts_columns['author'])) {
    $new_posts_columns = $posts_columns;
  } else {
    $new_posts_columns = array();
    $index = 0;
    foreach($posts_columns as $key => $posts_column) {
      if ($key=='author') {
        $new_posts_columns['businesses'] = null;
      }
      $new_posts_columns[$key] = $posts_column;
    }
  }
  $new_posts_columns['businesses'] = 'Businesses';
  return $new_posts_columns;
}

add_action('manage_posts_custom_column', 'show_businesses_column_for_listing_list',10,2);
function show_businesses_column_for_listing_list( $column_id,$post_id ) {
  global $typenow;
  if ($typenow=='listing') {
    $taxonomy = 'business';
    switch ($column_id) {
      case 'businesses':
        $businesses = get_the_terms($post_id,$taxonomy);
        if (is_array($businesses)) {
          foreach($businesses as $key => $business) {
            $edit_link = get_term_link($business,$taxonomy);
            $businesses[$key] = '<a href="'.$edit_link.'">' . $business->name . '</a>';
        }
          echo implode(' | ',$businesses);
      }
        break;
    }
  }
}


/* JUST AN HYPOTHETICAL EXAMPLE
add_action('manage_posts_custom_column', 'manage_posts_custom_column',10,2);
function manage_posts_custom_column( $column_id,$post_id ) {
global $typenow;
switch ("{$typenow}:{$column_id}") {
case 'listing:business':
echo '...whatever...';
break;
case 'listing:property':
echo '...whatever...';
break;
case 'agent:listing':
echo '...whatever...';
break;
}
}
 */

add_action('restrict_manage_posts','restrict_listings_by_business');
function restrict_listings_by_business() {
  global $typenow;
  global $wp_query;
  if ($typenow=='listing') {
    $taxonomy = 'business';
    $business_taxonomy = get_taxonomy($taxonomy);
    wp_dropdown_categories(array(
      'show_option_all' =>  __("Show All {$business_taxonomy->label}"),
      'taxonomy'        =>  $taxonomy,
      'name'            =>  'business',
      'orderby'         =>  'name',
      'selected'        =>  $wp_query->query['term'],
      'hierarchical'    =>  true,
      'depth'           =>  3,
      'show_count'      =>  true,  // This will give a view
      'hide_empty'      =>  true,   // This will give false positives, i.e. one's not empty related to the other terms. TODO: Fix that
    ));
  }
}
add_filter('parse_query','convert_business_id_to_taxonomy_term_in_query');
function convert_business_id_to_taxonomy_term_in_query($query) {
  global $pagenow;
  $qv = &$query->query_vars;
  if ($pagenow=='edit.php' &&
      isset($qv['taxonomy']) && $qv['taxonomy']=='business' &&
      isset($qv['term']) && is_numeric($qv['term'])) {
    $term = get_term_by('id',$qv['term'],'business');
    $qv['term'] = $term->slug;
  }
}
add_action('init','register_listing_post_type');
function register_listing_post_type() {
  register_post_type('listing',array(
    'label' => 'Listings',
    'public' => true,
    'publicly_queryable' => true,
    'show_ui' => true,
    'query_var' => true,
    'rewrite' => true,
    'capability_type' => 'post',
    'hierarchical' => false,
  ));
}
add_action('init','register_business_taxonomy');
function register_business_taxonomy() {
  register_taxonomy('business',array('listing'),array(
    'label' => 'Businesses',
    'public'=>true,
    'hierarchical'=>true,
    'show_ui'=>true,
    'query_var'=>true
  ));
}

?>