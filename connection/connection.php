
<?php

define("database", "veterinario");
define("databaseip", "127.0.0.1");
define("user", "");
define("password", "");

function get_conn()
{
    try {
        //todo capire che fa 
        //mysqli_report(MYSQLI_REPORT_OFF); 
        return new mysqli(databaseip, user, password, database);
    } catch (Exception $e) {
        echo $e;
    }
}




?>
