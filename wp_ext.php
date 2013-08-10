<?php
// mods a wp

function the_slug() {
  global $post;
  $post_data = get_post($post->ID, ARRAY_A);
  $slug = $post_data['post_name'];
  return $slug; 
}

?>