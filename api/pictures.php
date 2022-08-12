
<?php
include_once "../settings/images.php";
include_once "../settings/pic-func.php";
header("Content-type:application/json;charset=utf-8");

if( isset($_FILES["avatar"]) )
{
    $avatar = $_FILES["avatar"];
    $target_dir = __DIR__ . "/../" . "images/";
    $target_file = $target_dir . basename($avatar["name"]);
    // uploadOk
    $uploadOk = 0;
    $uploadOk = is_image($avatar);
    $uploadOk = image_inexisted($target_file, $uploadOk);

    if ($uploadOk != 0)
    {   // Check if $uploadOk is set to 0 by an error
        $error_msgs = get_error_msgs( $uploadOk );
        die( get_message( $error_msgs["code"], "Sorry, your file was not uploaded.", $error_msgs["msg"] ) );
    }
    else
    {   // if everything is ok, try to upload file
        if (move_uploaded_file($avatar["tmp_name"], $target_file)) {
            function success_action($avatar)
            {
                $path = htmlspecialchars( basename( $avatar["name"] ) );
                $info = array( "path" => $path );
                $description = isset($_POST["description"]) ? $_POST["description"] : "";
                $pathcb = set_img_path( $path, $path, $description );
                if( $pathcb ) {
                    die( get_message( 200, "The file has been uploaded.", $info ) );
                }
                die( get_message( 500, "Sorry, there was an error uploading your file." ) );
            }
            success_action($avatar);
        } else {
            die( get_message( 500, "Sorry, there was an error uploading your file." ) );
        }
    }

}
die( get_message( 400, "No file uploaded" ) );

?>
