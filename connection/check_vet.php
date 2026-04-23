<?php

session_start();

if (!isset($_SESSION["usertype"]) || !isset($_SESSION["status"]) || !isset($_SESSION["username"]) || $_SESSION["status"] !== "verified"){

    header("Location: login.php");
    exit();

}
if($_SESSION["usertype"] != "vet"){

    header("Location: dashboard_owner.php");
    exit();

}




?>
