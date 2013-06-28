<?php
#!/usr/local/php5/bin/php
        include( "wp-load.php" );
        // include( "wp-config.php" );
        // include ('wp-admin/admin.php');
        // include ('wp-includes/post.php');
        
        $authorID = "admin";
        $title = "titulo";
        $post_type = "prueba_product";
        $publish = 'publish';
        $excerpt = "Lorem ipsum dolor sit amet.";
        $content = "Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.";

        $new_post = array(
                        'post_status'   => $publish,
                        'post_type'     => $post_type,
                        'post_author'   => $authorID,
                        'post_title'    => $title,
                        'post_content'  => $content,
                        'post_excerpt'  => $excerpt,
                        'comment_status'=> 'closed',
                        'ping_status'   => 'closed',
                        'post_category' => array($category),
                );

                //-- Create the new post
        $new_post_id = wp_insert_post($new_post);




$image_url = ABSPATH . 'imagenprueba.jpg';

$upload_dir = wp_upload_dir();
$image_data = file_get_contents($image_url);
$filename = basename($image_url);
if(wp_mkdir_p($upload_dir['path']))
    $file = $upload_dir['path'] . '/' . $filename;
else
    $file = $upload_dir['basedir'] . '/' . $filename;
file_put_contents($file, $image_data);

$wp_filetype = wp_check_filetype($filename, null );
$attachment = array(
    'post_mime_type' => $wp_filetype['type'],
    'post_title' => sanitize_file_name($filename),
    'post_content' => '',
    'post_status' => 'inherit'
);
$attach_id = wp_insert_attachment( $attachment, $file, $post_id );
require_once(ABSPATH . 'wp-admin/includes/image.php');
$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
wp_update_attachment_metadata( $attach_id, $attach_data );

set_post_thumbnail( $new_post_id, $attach_id );

?>