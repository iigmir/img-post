<?php
include_once "db-info.php";

class Database {
    public $dbname = "image-app";
    public $table = "images";
    private function init_db_connection()
    {
        $db = DbLoginInfos();
        $link = mysqli_connect( $db["host"], $db["dbuser"], $db["dbpassword"], $this->dbname );
        if( $link ) {
            return $link;
        } else {
            return array(
                "msg" => "Connection unsuccessful",
                "dump" => mysqli_connect_error()
            );
        }
    }
    public function get_datas()
    {
        $sql = "SELECT * FROM `$this->table`";
        $connection = $this->init_db_connection();
        $source = mysqli_query( $connection, $sql );
        $datas = array();
        if ($source) {
            if ( mysqli_num_rows($source) > 0 ) {
                while ($row = mysqli_fetch_assoc($source))
                {   // 每跑一次迴圈就抓一筆值，最後放進data陣列中
                    $datas[] = $row;
                }
            }
        }
        mysqli_close($connection);
        return $datas;
    }
    public function set_data($img_path = "", $img_name = "", $img_description = "")
    {
        $sql = "INSERT INTO `images` (`id`, `path`, `name`, `description`) VALUES (NULL, '$img_path', '$img_name', '$img_description');";
        $connection = $this->init_db_connection();
        $source = mysqli_query( $connection, $sql );
        $success = false;
        if ($source) {
            $success = true;
        }
        mysqli_close($connection);
        return $success;
    }
}

if( !defined("ACCESS_DB") )
{
    http_response_code(406);
    header("Content-type:application/json;charset=utf-8");
    die( json_encode( array( "message" => "Illegal access" ) ) );
}
?>
