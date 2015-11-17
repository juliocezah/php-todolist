<?php

class ConnectionFactory{
    
    public static function getDB(){
        $connection = self::getConnection();

        $db = new NotORM($connection);
        
        return $db;
    }
    
    private static function getConnection(){
        $dbhost = getenv('IP');
        $dbuser = getenv('C9_USER');
        $dbpass = '';
        $dbname = 'c9';
        
        $connection = new PDO("mysql:host=$dbhost; dbname=$dbname", $dbuser, $dbpass);
        
        return $connection;
    }
    
}    
?>