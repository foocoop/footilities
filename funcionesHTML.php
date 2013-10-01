<?php

function themeDir() {
	return get_stylesheet_directory_uri();
}



/***********************************************************
 * 					Estructuras HTML
 * ********************************************************/


function foo_div($id="",$class="", $content="", $link=""){
	$str = '<div';
		if($id!="") { 		$str .= ' id="'.$id.'"';	}
		if($class!="") { 	$str .= ' class="'.$class.'"'; }

	$str .= '>';

		if($link!="") { 		$str .= '<a href="'.$link.'">';	}
		if($content!="") { 	$str .= $content;	}
		if($link!="") {		$str .= '</a>';	}
	
  $str .= '</div>';
	
	return $str;
}



function foo_open($id="",$class=""){
	$str = '<div';
		if($id!="") {     $str .= ' id="'.$id.'"';  }
		if($class!="") {  $str .= ' class="'.$class.'"'; }

	$str .= '>';
  
	return $str;
}



function foo_close(){
  $str .= '</div>';
  return $str;
}

/* nos permite centrar verticalmente los contenidos de una div */

function foo_vcenter($content="", $link="", $align="justify", $id="", $class="" ){
	$str = 	foo_div($id,'vcenter_table '.$classm,
				foo_div("","vcenter_container",foo_div("", "vcenter_content ".$align, $content) )				
			);
	if($link!="") $str = foo_link($str,$link);
	
	return $str;
}



function foo_scroller($content){
	$str = 	foo_div($id,'scroll_hide '.$classm,
			foo_div("","scroller",$content) 				
		);
		  
  return $str;
}







function foo_span($id="",$class="", $content="", $link=""){
	$str = '<span';
		if($id!="") { 		$str .= ' id="'.$id.'"';	}
		if($class!="") { 	$str .= ' class="'.$class.'"'; }

	$str .= '>';

		if($link!="") { 		$str .= '<a href="'.$link.'">';	}
		if($content!="") { 	$str .= $content;	}
		if($link!="") {		$str .= '</a>';	}
	
  $str .= '</span>';
	
	return $str;
}



/***********************************************************
 * 					Imágenes
 **********************************************************/



function foo_imgdir($filename=""){
  if($filename!="") {
    $str = themeDir() . '/img/' . $filename;
  }
  return $str;
}


function foo_img($src=""){
  if($src!="") {
    $str = '<img src="'.$src.'"/>';
  }

  return $str;
}

function foo_featImg( $size = 'full', $id = "" ){
  if($id != "")
    $img = wp_get_attachment_image_src( get_post_thumbnail_id($id), $size);
  else
    $img = wp_get_attachment_image_src( get_post_thumbnail_id(), $size);
  return $img[0];
}


function foo_imgs( $ID, $size = 'thumbnail', $addFeatured = 'false') {
  $photos = get_children( array('post_parent' => $ID, 'post_status' => 'null', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC') ); 
  $results = array();
  
  if($addFeatured)
	$results[]  = foo_featImg();
	
  if ($photos) {
    foreach ($photos as $photo) {
      // get the correct image html for the selected size
            $att_img_src = wp_get_attachment_image_src($photo->ID, $size);
            $results[] = $att_img_src[0];
    }
  }
  return $results;
}


function foo_thumb( $src, $w=200, $h=200, $zc=1, $q=100 ) {
  return themeDir().'/scripts/timthumb/timthumb.php?src='.$src.'&w='.(int)$w.'&h='.(int)$h.'&zc='.(int)$zc.'&q='.(int)$q;
}









/***********************************************************
 * 					Listas
 **********************************************************/

function foo_ul($id="",$class="", $content="", $link=""){
  $str = '<ul';
    if($id!="") {     $str .= ' id="'.$id.'"';  }
    if($class!="") {  $str .= ' class="'.$class.'"'; }

  $str .= '>';

    if($link!="") {   $str .= '<a href="'.$link.'">'; }
    if($content!="") {  $str .= $content; }
    if($link!="") {   $str .= '</a>'; }
  $str .= '</ul>';
  
  return $str;
}
      

function foo_li($id="",$class="", $content="", $link=""){
	$str = '<li';
		if($id!="") {     $str .= ' id="'.$id.'"';  }
		if($class!="") {  $str .= ' class="'.$class.'"'; }
	$str .= '>';

	if($link!="") {   $str .= '<a href="'.$link.'">'; }
	if($content!="") {  $str .= $content; }
	if($link!="") {   $str .= '</a>'; }

	$str .= '</li>';

	return $str;
}




function foo_dropdown($id="",$class="", $option_array, $link=""){
  $str = '<select';
    if($id!="") {     $str .= ' id="'.$id.'"';  }
    if($class!="") {  $str .= ' class="'.$class.'"'; }
  $str .= '>';

    if($link!="") {   $str .= '<a href="'.$link.'">'; }
    if($option_array!="") {  
		$options = "";
		
		foreach( $option_array as $option ) {
			$str .= '<option value="'.$id.'">'.$option.'</option>';
		}
			
			
	}
    if($link!="") {   $str .= '</a>'; }
  $str .= '</select>';
  
  return $str;
}


/* específica para generar los banners para usar con mobilyslider */

function foo_banner($content="", $link="", $align="justify"){
  
    if($link!="") {   $str .= '<a href="'.$link.'">'; }
    if($content!="") {  
      $str .= foo_div("","div_banner",
                foo_div("","text_table",
                  foo_div("","text_container",
                      foo_div("","vcenter_text ".$align,$content )
                  )
                )
              );
    }
    if($link!="") {   $str .= '</a>'; }
  
  return $str;
}




function foo_link($content="",$url="",$onclick=""){
	if($url=="") $url = "#";
		$str = "";
		$str = '<a href="'.$url.'"';
		if($onclick!="") {    
			$str .= ' onclick="'.$onclick.'"';
		}

	$str .= '>';
	$str .= $content;
	$str .= '</a>';

	return $str;
}










/***********************************************
 * 				Textos
 **********************************************/


      
function foo_h($text="",$number=""){
	$str = '<h'.$number.'>'.$text.'</h'.$number.'>';
	return $str;
}






/***********************************************
 * 				Utilidades gráficas
 **********************************************/


function foo_curtain( $behind, $over ) {
	return foo_div( "", "curtain_holder",
				foo_div("","behind_curtain",$behind)
				. foo_div("","curtain")
				. foo_div("","over_curtain",$over )
			);
}


/***********************************************
 * 				Contenido Wordpress
 **********************************************/

function foo_filter($content="",$filter="filter"){
  return apply_filters("the_".$filter,$content);
}


function foo_post(){
  $arr = array();
  
  $arr['ID'] = get_the_ID();
  $arr['ttl'] = foo_filter( get_the_title(), 'title');
  $arr['ext'] = foo_filter( get_the_excerpt(), 'excerpt');
  $arr['cnt'] = foo_filter( get_the_content(), 'content');
  $arr['meta'] = get_post_meta( get_the_ID() );
  $arr['url'] = get_permalink( get_the_ID() );
  $arr['img'] = foo_featImg( get_the_ID() );
  
  return $arr;

}




function foo_post_ID($ID){


  $arr = array();
  $post = get_post($ID);
  $arr['ID'] = $ID;
  $arr['ttl'] = foo_filter( get_the_title($post), 'title');
  $arr['ext'] = foo_filter( get_the_excerpt($post), 'excerpt');
  $arr['cnt'] = foo_filter( get_the_content($post), 'content');
  $arr['meta'] = get_post_meta( $ID );
  $arr['url'] = get_permalink( $ID );
  $arr['img'] = foo_featImg( $ID );
  
  return $arr;

}





function foo_strip( $content, $tag ) {
	$content = preg_replace('/<'.$tag.'[^>]+./','', $content);
	return $content;
}

function foo_split_txt( $txt="", $num_chars=20 ) {
  $lines = explode("\n", wordwrap($txt, $num_chars));
  return $lines;
}

function foo_article( $args ) {
	
	$id = $args['id'];
	$class = $args['class'];
	
	$content = $args['content'];
	$header = $args['header'];
	$navigation = $args['navigation'];
	$footer = $args['footer'];
	
	
	$str .= '<article id="'.$id.'" class="'.$class.'" role="article">	';						
		$str .= '<header>'.$header.'</header>';			
		$str .= '<section class="content">'.$content.'</section>';					
		$str .= '<footer>'.$footer.'</footer>';
	$str .= '</article>';
	
	return $str;
}


function foo_dbg( $content ) {
	echo foo_div("","debug",$content);
}

?>
