<?php 
class ImageComponent extends Object
{
    var $controller = true;
 
    function startup(&$controller)
    {
        // This method takes a reference to the controller which is loading it.
        // Perform controller initialization here.
    }
    function createnifty($image_file,$corner_name,$saveto,$corner_radius=20,$angle=0,$topleft=true,$bottomleft=true,$bottomright=true,$topright=true)
    {
		$corner_source = imagecreatefrompng($corner_name);
		
		$corner_width = imagesx($corner_source);  
		$corner_height = imagesy($corner_source);  
		$corner_resized = ImageCreateTrueColor($corner_radius, $corner_radius);
		ImageCopyResampled($corner_resized, $corner_source, 0, 0, 0, 0, $corner_radius, $corner_radius, $corner_width, $corner_height);
		
		$corner_width = imagesx($corner_resized);  
		$corner_height = imagesy($corner_resized);  
		$image = imagecreatetruecolor($corner_width, $corner_height);  
		$image = imagecreatefromjpeg($image_file); // replace filename with $_GET['src'] 
		$size = getimagesize($image_file); // replace filename with $_GET['src'] 
		$white = ImageColorAllocate($image,255,255,255);
		$black = ImageColorAllocate($image,0,0,0);
		
		// Top-left corner
		if ($topleft == true) {
		    $dest_x = 0;  
		    $dest_y = 0;  
		    imagecolortransparent($corner_resized, $black); 
		    imagecopymerge($image, $corner_resized, $dest_x, $dest_y, 0, 0, $corner_width, $corner_height, 100);
		} 
		
		// Bottom-left corner
		if ($bottomleft == true) {
		    $dest_x = 0;  
		    $dest_y = $size[1] - $corner_height; 
		    $rotated = imagerotate($corner_resized, 90, 0);
		    imagecolortransparent($rotated, $black); 
		    imagecopymerge($image, $rotated, $dest_x, $dest_y, 0, 0, $corner_width, $corner_height, 100);  
		}
		
		// Bottom-right corner
		if ($bottomright == true) {
		    $dest_x = $size[0] - $corner_width;  
		    $dest_y = $size[1] - $corner_height;  
		    $rotated = imagerotate($corner_resized, 180, 0);
		    imagecolortransparent($rotated, $black); 
		    imagecopymerge($image, $rotated, $dest_x, $dest_y, 0, 0, $corner_width, $corner_height, 100);  
		}
		
		// Top-right corner
		if ($topright == true) {
		    $dest_x = $size[0] - $corner_width;  
		    $dest_y = 0;  
		    $rotated = imagerotate($corner_resized, 270, 0);
		    imagecolortransparent($rotated, $black); 
		    imagecopymerge($image, $rotated, $dest_x, $dest_y, 0, 0, $corner_width, $corner_height, 100);  
		}
		
		// Rotate image
		$image = imagerotate($image, $angle, $white);
		
		// Output final image
		imagejpeg($image,$saveto); 
		imagedestroy($image);  
		imagedestroy($corner_source);
    }
	/*function createthumb($name,$filename,$new_w,$new_h)
	{
		$system=explode(".",$name);
		if (preg_match("/jpg|jpeg/",$system[1])){$src_img=imagecreatefromjpeg($name);}
		if (preg_match("/png/",$system[1])){$src_img=imagecreatefrompng($name);}
		$old_x=imageSX($src_img);
		$old_y=imageSY($src_img);
		if ($old_x > $old_y) 
		{
			$thumb_h=$new_h;
			$thumb_w=$new_h*($old_x/$old_y);
			if($thumb_h>$new_w){
				$thumb_w=$new_w;
				$thumb_h=$old_y*($new_w/$old_x);
			}
			//$thumb_h=$old_y*($new_w/$old_x);
		}
		if ($old_x < $old_y) 
		{
			$thumb_h=$old_y*($new_w/$old_x);
			$thumb_w=$new_w;
			/*
			$thumb_h=$new_h;
			$thumb_w=$new_h*($old_x/$old_y);*/
		/*}
		if ($old_x == $old_y) 
		{
			$thumb_w=$new_w;
			$thumb_h=$new_h;
		}
		$dst_img=ImageCreateTrueColor($thumb_w,$thumb_h);
		imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y); 
		if (preg_match("/png/",$system[1]))
		{
			imagepng($dst_img,$filename); 
		} else {
			imagejpeg($dst_img,$filename); 
		}
		imagedestroy($dst_img); 
		imagedestroy($src_img); 
	} */
	function createthumb($name,$filename,$new_w,$new_h){
		$system=explode('.',$name);
		$type=strtolower($system[1]);
		if ($type == "jpg" || $type == "jpeg"){
			$src_img=imagecreatefromjpeg($name);
		}
		if ($type == "png"){
			$src_img=imagecreatefrompng($name);
		}
		if ($type == "gif"){
			$src_img=imagecreatefromgif($name);
		}
		$old_x=imageSX($src_img);
		$old_y=imageSY($src_img);
		if ($old_x > $old_y) {
			$thumb_w=$new_w;
			$percent = ($new_w * 100) / $old_x;
			$thumb_h = intval(($percent * $old_y) / 100);
			if($thumb_h>$new_h){
				$percent = ($new_h * 100) / $old_y;
				$thumb_w = intval(($percent * $old_x) / 100);
				$thumb_h=$new_h;
			}
		}
		if ($old_x < $old_y) {
			$percent = ($new_h * 100) / $old_y;
			$thumb_w = intval(($percent * $old_x) / 100);
			$thumb_h=$new_h;
			if($thumb_w>$new_w){
				$thumb_w=$new_w;
				$percent = ($new_w * 100) / $old_x;
				$thumb_h = intval(($percent * $old_y) / 100);
			}
		}
		if ($old_x == $old_y) {
			$thumb_w=$new_w;
			$thumb_h=$new_h;
			if($new_w>$new_h){
				$percent = ($new_h * 100) / $old_y;
				$thumb_w = intval(($percent * $old_x) / 100);
				$thumb_h=$new_h;
			}
			if($thumb_h>$new_h){
				$percent = ($new_h * 100) / $old_y;
				$thumb_w = intval(($percent * $old_x) / 100);
				$thumb_h=$new_h;
			}
		}
		$dst_img=ImageCreateTrueColor($thumb_w,$thumb_h);
		imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,$old_x,$old_y);
		if ($type == "png")
		{
			$transparent = imagecolorallocate($dst_img, 0, 0, 0);
			// Make the background transparent
			imagecolortransparent($dst_img, $transparent);
			imagepng($dst_img,$filename,100);
		}
		if ($type == "gif")
		{
			imagegif($dst_img,$filename);
		}
		if ($type == "jpg" || $type == "jpeg")
		{
			imagejpeg($dst_img,$filename,100);
		}
		imagedestroy($dst_img);
		imagedestroy($src_img);
	}

}
?>