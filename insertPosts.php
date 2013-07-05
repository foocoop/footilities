<?php

include( "../../../../wp-config.php" );


$upload_dir = wp_upload_dir();

$image_urls = array(
	"insertImgs/01.jpg", 
	"insertImgs/02.jpg",
	"insertImgs/03.jpg",
	"insertImgs/04.jpg",
	"insertImgs/05.jpg"
);

for($i=0; $i<6; $i++){

	$titulo = "Título" . ( $i + 1 );
	
	$categorias = array( get_category_by_slug('cat1')->cat_ID );
	$disciplinas = array( get_term_by('name','Disciplina 1','disciplina') -> term_id  );

	$post = array(
		'post_status' => 'publish',
		'post_type' => 'proyecto',
		'post_title' => $titulo,
		'comment_status' => 'closed',
		'ping_status' => 'closed',
	);

		//-- Create the new post
	$newPostID = wp_insert_post($post, true);
			
	
	if($newPostID)
		if( ! is_wp_error( $newPostID ) ) 		{
			
			// asignar taxonomías
			wp_set_post_terms( $newPostID, $categorias, 'category' );
			wp_set_post_terms( $newPostID, $disciplinas, 'disciplina' );
//~ 

			// insertar imagen


			$image_url = $image_urls[ $i % count($image_urls) ];

			$image_data = file_get_contents($image_url);
			$filename = basename($image_url);
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
			$attach_id = wp_insert_attachment( $attachment, $file, $newPostID );
			require_once(ABSPATH . 'wp-admin/includes/image.php');
			$attach_data = wp_generate_attachment_metadata( $attach_id, $file );
			wp_update_attachment_metadata( $attach_id, $attach_data );

			set_post_thumbnail( $newPostID, $attach_id );
			
			echo "ok";
		
		
		}
		else
			echo "ERROR";
		
		
		
}


?>
