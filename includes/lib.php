<?php
class DB{
    private static $pdo = null;

    public static function connect(){
        if(self::$pdo === null){
            $database = require_once __DIR__."/../database.php";
            self::$pdo = new PDO("mysql:host=".$database["server"].";dbname=".$database["name"].";charset=utf8mb4",$database["user"],$database["password"]);
        }
        return self::$pdo;
    }

    public static function query($query){
        $pdo = self::connect();
        $res = $pdo->query($query);
        return $res;
    }
}

function animate($image){
	$ext = substr($image,0,2);
	if($ext == "a_"){
		return ".gif";
	}else{
		return ".png";
	}
}
?>