<?php
//Setup Imports
require("../main.php");
error_reporting(0);
if(!function_exists("create_square_image")){
    function create_square_image($original_file, $destination_file=NULL, $square_size = 96){
        
        if(isset($destination_file) and $destination_file!=NULL){
            if(!is_writable($destination_file)){
                echo '<p style="color:#FF0000">Oops, the destination path is not writable. Make that file or its parent folder wirtable.</p>'; 
            }
        }
        
        // get width and height of original image
        $imagedata = getimagesize($original_file);
        $original_width = $imagedata[0];    
        $original_height = $imagedata[1];
        
        if($original_width > $original_height){
            $new_height = $square_size;
            $new_width = $new_height*($original_width/$original_height);
        }
        if($original_height > $original_width){
            $new_width = $square_size;
            $new_height = $new_width*($original_height/$original_width);
        }
        if($original_height == $original_width){
            $new_width = $square_size;
            $new_height = $square_size;
        }
        
        $new_width = round($new_width);
        $new_height = round($new_height);
        
        // load the image
        if(substr_count(strtolower($original_file), ".jpg") or substr_count(strtolower($original_file), ".jpeg") or substr_count(strtolower($original_file), ".JPG") or substr_count(strtolower($original_file), ".JEPG")){
            $original_image = imagecreatefromjpeg($original_file);
        }
        
        $smaller_image = imagecreatetruecolor($new_width, $new_height);
        $square_image = imagecreatetruecolor($square_size, $square_size);
        
        imagecopyresampled($smaller_image, $original_image, 0, 0, 0, 0, $new_width, $new_height, $original_width, $original_height);
        
        if($new_width>$new_height){
            $difference = $new_width-$new_height;
            $half_difference =  round($difference/2);
            imagecopyresampled($square_image, $smaller_image, 0-$half_difference+1, 0, 0, 0, $square_size+$difference, $square_size, $new_width, $new_height);
        }
        if($new_height>$new_width){
            $difference = $new_height-$new_width;
            $half_difference =  round($difference/2);
            imagecopyresampled($square_image, $smaller_image, 0, 0-$half_difference+1, 0, 0, $square_size, $square_size+$difference, $new_width, $new_height);
        }
        if($new_height == $new_width){
            imagecopyresampled($square_image, $smaller_image, 0, 0, 0, 0, $square_size, $square_size, $new_width, $new_height);
        }
        

        // if no destination file was given then display a png      
        if(!$destination_file){
            imagepng($square_image,NULL,9);
        }
        
        // save the smaller image FILE if destination file given
        if(substr_count(strtolower($destination_file), ".jpg")){
            imagejpeg($square_image,$destination_file,70);
        }

        imagedestroy($original_image);
        imagedestroy($smaller_image);
        imagedestroy($square_image);

    }
}

$target_dir = "";
$target_file = "../../users/".$_SESSION['u']['code']."/profile.jpg";
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);

if(!empty($_FILES["file"])) {
    // Check file size
    if ($_FILES["file"]["size"] > 10485760) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }
    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    // if everything is ok, try to upload file
    } else {
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
        	create_square_image($target_file,$target_file,400);
        	echo "Stored in: ".$target_file;
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}
?>