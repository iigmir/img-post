<?php
function is_image($avatar)
{   // Check if image file is a actual image or fake image
    $check = getimagesize($avatar["tmp_name"]);
    if ($check !== false)
    {   // File is an image
        return 0;
    }
    else if( mime_content_type($avatar["tmp_name"]) === "image/svg+xml" )
    {   // File is a SVG since getimagesize doesn't support SVG. See: https://bugs.php.net/bug.php?id=71517
        return 0;
    }
    else
    {   // File is not an image
        return 1;
    }
}

function image_inexisted($target_file, $uploadOk)
{
    if ( $uploadOk != 0 )
    {
        return $uploadOk;
    }
    if ( file_exists($target_file) )
    {
        return 2;
    }
    return 0;
}

function legal_size($avatar, $uploadOk)
{
    if ($uploadOk != 0) {
        return $uploadOk;
    }
    if ($avatar["size"] > 500000) {
        echo "Sorry, your file is too large.";
        return 3;
    }
    return 0;
}

function legal_format($target_file, $uploadOk)
{
    if ($uploadOk != 0) {
        return $uploadOk;
    }
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
        echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        return 4;
    }
    return 0;
}

function get_error_msgs($uploadOk = 0)
{
    if( $uploadOk == 1 ) {
        return array( "msg" => "Uploaded file is not an image.", "code" => 400 );
    }
    if( $uploadOk == 2 ) {
        return array( "msg" => "File existed.", "code" => 409 );
    }
    return array( "msg" => "Other error", "code" => 500 );
}

function get_message($response_code, $message, $infos = array())
{
    http_response_code($response_code);
    return json_encode(array(
        "message" => $message,
        "infos" => $infos
    ));
}

?>
