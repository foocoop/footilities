<?php

// textbox repetible : 


function foo_textbox_meta_box() {
  global $post;

  $textbox = get_post_meta($post->ID, 'textbox', true);
  var_dump( get_post_meta($post->ID) );
  wp_nonce_field( 'foo_textbox_nonce', 'foo_textbox_nonce' );
?>
<script type="text/javascript">
 jQuery(document).ready(function( $ ){
   $( '#add-row' ).on('click', function() {
     var row = $( '.empty-row.screen-reader-text' ).clone(true);
     row.removeClass( 'empty-row screen-reader-text' );
     row.insertBefore( '#textbox-one tbody>tr:last' );
     return false;
   });
   
   $( '.remove-row' ).on('click', function() {
     $(this).parents('tr').remove();
     return false;
   });
 });
</script>

<table id="textbox-one" width="100%">
  <thead>
    <tr>
      <th width="82%">Participante</th>
      <!--
      <th width="12%">Select</th>
      -->
      <th width="8%"></th>
    </tr>
  </thead>
  <tbody>
    <?php

    if ( $textbox ) :
         
         foreach ( $textbox as $field ) {
    ?>
    <tr>
      <td><input type="text" class="widefat" name="textbox[]" value="<?php if($field['textbox'] != '') echo esc_attr( $field['textbox'] ); ?>" /></td>
        <td><a class="button remove-row" href="#">Quitar</a></td>
    </tr>
    <?php
    }
    else :
                                      // show a blank one
    ?>
    <tr>
      <td><input type="text" class="widefat" name="textbox[]" /></td>
      <td><a class="button remove-row" href="#">Quitar</a></td>
    </tr>
      <?php endif; ?>

      <!-- empty hidden one for jQuery -->
      <tr class="empty-row screen-reader-text">
        <td><input type="text" class="widefat" name="textbox[]" /></td>
        <td><a class="button remove-row" href="#">Remove</a></td>
      </tr>
  </tbody>
</table>

<p><a id="add-row" class="button" href="#">Añadir</a></p>
<?php
}

add_action('save_post', 'foo_textbox_save');
function foo_textbox_save($post_id) {
  if ( ! isset( $_POST['foo_textbox_nonce'] ) ||
      ! wp_verify_nonce( $_POST['foo_textbox_nonce'], 'foo_textbox_nonce' ) )
  return;
  
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
  return;
  
  if (!current_user_can('edit_post', $post_id))
  return;

  
  
  $old = get_post_meta($post_id, 'textbox', true);
  $new = array();
  //~ $options = foo_get_sample_options();
  
  $textbox = $_POST['textbox'];
  
  $count = count( $textbox );
  
  for ( $i = 0; $i < $count; $i++ ) {
    if ( $textbox[$i] != '' ) {
      $new[$i]['textbox'] = stripslashes( strip_tags( $textbox[$i] ) );
    }
  }

  if ( !empty( $new ) && $new != $old )
  update_post_meta( $post_id, 'textbox', $new );
  elseif ( empty($new) && $old )
  delete_post_meta( $post_id, 'textbox', $old );
}




















/* dropdown o select repetible */












function foo_participantes_meta_box() {
  global $post;

  
  $participantes = get_post_meta($post->ID, 'participantes', true);
  
  $arr = array();
  $invitados = new WP_Query(array( 'post_type'=>'invitado','posts_per_page'=>-1 ) );
  if( $invitados->have_posts() ) {
    while ( $invitados->have_posts() ) {
      $invitados->the_post();

      array_push( $arr, foo_filter( $post->post_title, 'title' ) );

    }
  }

  wp_nonce_field( 'foo_participantes_nonce', 'foo_participantes_nonce' );
?>
<script type="text/javascript">
 jQuery(document).ready(function( $ ){
   $( '#add-row' ).on('click', function() {
     var row = $( '.empty-row.screen-reader-text' ).clone(true);
     row.removeClass( 'empty-row screen-reader-text' );
     row.insertBefore( '#participantes-one tbody>tr:last' );
     return false;
   });
   
   $( '.remove-row' ).on('click', function() {
     $(this).parents('tr').remove();
     return false;
   });
 });
</script>

<table id="participantes-one" width="100%">
  <thead>
    <tr>
      <th width="82%">Participante</th>
      <!--
      <th width="12%">Select</th>
      -->
      <th width="8%"></th>
    </tr>
  </thead>
  <tbody>
    <?php
    
    if ( $participantes ) {
      
      foreach ( $participantes as $field ) {
        
        $options = '<option value="" ></option>';
        
        foreach( $arr as $t ) {
          $options .= '<option value="'.$t.'" '.selected($field,$t,0).'> '.$t.'</option>';
        }
        
        $select = '<select name="participantes[]">'.$options.'</select>';

    ?>
    <tr>
      <td>
        <?php
        echo $select;
        ?>
      </td>
      <td><a class="button remove-row" href="#">Quitar</a></td>
    </tr>
    <?php
    }

    }
    else {
      // show a blank one
    ?>
    
    <tr>
      <td>
        <?php
        $options = '<option value="" ></option>';
        foreach( $arr as $t ) {
          $options .= '<option value="'.$t.'">'.$t.'</option>';
        }
        $select = '<select name="participantes[]">'.$options.'</select>';
        echo $select;
        ?>
      </td>
      <td><a class="button remove-row" href="#">Quitar</a></td>
    </tr>

    <?php } ?>

    <!-- empty hidden one for jQuery -->
    <tr class="empty-row screen-reader-text">
      <td>

        <?php
        
        $options = '<option value=""></option>';
        foreach( $arr as $t ) {
          $options .= '<option value="'.$t.'">'.$t.'</option>';
        }
        $select = '<select name="participantes[]">'.$options.'</select>';

        echo $select;
        ?>
      </td>
      <td><a class="button remove-row" href="#">Quitar</a></td>

    </tr>
  </tbody>
</table>

<p><a id="add-row" class="button" href="#">Añadir</a></p>
<?php
}

add_action('save_post', 'foo_participantes_save');
function foo_participantes_save($post_id) {
  if ( ! isset( $_POST['foo_participantes_nonce'] ) ||
      ! wp_verify_nonce( $_POST['foo_participantes_nonce'], 'foo_participantes_nonce' ) )
  return;
  
  if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
  return;
  
  if (!current_user_can('edit_post', $post_id))
  return;

  
  
  $old = get_post_meta($post_id, 'participantes', true);
  $new = array();
  //~ $options = foo_get_sample_options();
  
  $participantes = $_POST['participantes'];
  
  $count = count( $participantes );
  
  for ( $i = 0; $i < $count; $i++ ) {
    if ( $participantes[$i] != '' ) {
      $new[$i] = stripslashes( strip_tags( $participantes[$i] ) );
    }
  }

  if ( !empty( $new ) && $new != $old )
  update_post_meta( $post_id, 'participantes', $new );
  elseif ( empty($new) && $old )
  delete_post_meta( $post_id, 'participantes', $old );
}














?>