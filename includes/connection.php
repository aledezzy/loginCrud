<?php
     class Connection {
        private static $user = "scuola";
        private static $pass = "paolino";
        private static $dbAddress = "localhost";
        private static $dbName = "tpsapp";
        
        public static function new(){
            $conn = new mysqli(self::$dbAddress, self::$user, self::$pass, self::$dbName, 3307);
            if(!$conn){
                die();
                include("ERROR.php");
            }
            return $conn;
         }
     }
     
     

?>