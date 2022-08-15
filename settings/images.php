<?php
include_once "pdo.php";

function set_img_path($img_path = "", $img_name = "", $img_description = "")
{
    $instance = new Database();
    $result = $instance->set_data($img_path, $img_name, $img_description);
    return $result;
}

?>