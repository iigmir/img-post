<?php
define("ACCESS_DB", TRUE);
include_once "db.php";
$instance = new Database();

header("Content-type:application/json; charset=utf-8;");
die( json_encode( array( "datas" => $instance->get_datas() ) ) );

?>