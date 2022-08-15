<?php
include_once "db-info.php";

class Database {
    public $dbname = "image-app";
    public $table = "images";
    public $instance = null;
    private function init_db_connection()
    {
        try {
            $db = DbLoginInfos();
            $dsn = "mysql:dbname=" . $this->dbname . ";host=" . $db["host"];
            $settings = array( PDO::ATTR_PERSISTENT => true );
            $this->instance = new PDO( $dsn, $db["dbuser"], $db["dbpassword"], $settings );
            return array( "success" => true, "message" => "success" );
        } catch (Exception $e) {
            return array( "success" => false, "message" => $e->getMessage() );
        }
    }
    public function get_datas()
    {
        $sql = "SELECT * FROM `$this->table`";
        $this->init_db_connection();
        $source = $this->instance->exec($sql);
        $datas = array();
        if ($source) {
            if ( mysqli_num_rows($source) > 0 ) {
                while ($row = mysqli_fetch_assoc($source))
                {   // 每跑一次迴圈就抓一筆值，最後放進data陣列中
                    $datas[] = $row;
                }
            }
        }
        return $datas;
    }
    public function set_data($img_path = "", $img_name = "", $img_description = "")
    {
        try {
            $this->init_db_connection();
            $sql = "INSERT INTO `images` (`id`, `path`, `name`, `description`) VALUES (NULL, ?, ?, ?);";
            $source = $this->instance->prepare(
                $sql
            )->execute([
                $this->instance->quote($img_path),
                $this->instance->quote($img_name),
                $this->instance->quote($img_description)
            ]);
            $success = false;
            if ($source) {
                $success = true;
            }
            return $success;
        }
        catch (Exception $e) {
            return false;
        }
    }
}