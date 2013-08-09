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

		if($link!="") { 	$str .= '<a href="'.$link.'">';	}
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
	if($link!="") $str = makeLink($str,$link);
	
	return $str;
}



function foo_scroller($content){
	$str = 	foo_div($id,'scroll_hide '.$classm,
			foo_div("","scroller",$content) 				
		);
		  
  return $str;
}









/***********************************************************
 * 					Imágenes
 **********************************************************/



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


function foo_kimgs( $eventoID, $size = 'thumbnail', $addFeatured = 'false') {
  $photos = get_children( array('post_parent' => $eventoID, 'post_status' => 'null', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => 'ASC') ); 
  $results = array();
  
  if($addFeatured)
	$results[]  = featImg();
	
  if ($photos) {
    foreach ($photos as $photo) {
      // get the correct image html for the selected size
      $results[] = wp_get_attachment_image_src($photo->ID, $size);
    }
  }
  return $results;
}


function foo_thumb( $src, $w=200, $h=200, $zc=1, $q=100 ) {
  return themeDir().'/scripts/timthumb/timthumb.php?src='.$src.'&w='.$w.'&h='.$h.'&zc='.$zc.'&q='.$q;
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
 * 				Contenido Wordpress
 **********************************************/

function filter($title="",$filter="filter"){
  return apply_filters("the_".$filter,$title);
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

?>
