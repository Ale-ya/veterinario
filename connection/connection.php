
<?php 

define("database", "veterinario");
define("databaseip", "127.0.0.1");
define("user", "dbManager");
define("password", "aracnids");

function get_conn(){
    try{
        return new mysqli(databaseip, user, password, database);
    }catch(Exception $e){
        echo $e;
    }
}




?>
