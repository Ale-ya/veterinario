<?php
session_start();
require_once("connection/connection.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);
if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET"){
    if(isset($_GET["status"])&& $_GET["status"] == "error"){
        $error = "inserimento nel database non riuscito";
    }elseif(isset($_GET["status"])&& $_GET["status"] == "usernameused"){
        $error = "username gia usato";
    }elseif (isset($_GET["status"])&& $_GET["status"] == "usernameerror") {
        $error = "errore in fase di autenticazione";
    }
}


if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["nome"]) && isset($_POST["cognome"])  && isset($_POST["email"]) && isset($_POST["username"]) && isset($_POST["password"]) ){
        $nome = htmlspecialchars($_POST["nome"]);
        $cognome = htmlspecialchars($_POST["cognome"]);
        $email = htmlspecialchars($_POST["email"]);
        $username = htmlspecialchars($_POST["username"]);
        $pass = $_POST["password"];

        $hash_pass = password_hash($pass, PASSWORD_DEFAULT);


        $conn = get_conn();
        $sql = "select * from veterinari where {$username} = username";
        $res = $conn->query($sql);

        if($res){
            $data = $res->fetch_assoc();
            if($data["username"] == $username){
                header("Location: signin_vet.php?status=usernameused");
                die();
            }
        }else{
            header("Location: signin_vet.php?status=usernameerror");
            die();
        }

        $sql = "insert into veterinari (username, password, nome, cognome,email) values ('{$username}', '{$hash_pass}','{$nome}','{$cognome}','{$email}')";

        //$res = $conn->query($sql);
        if ($conn->query($sql)){
            $_SESSION["status"] = "verified";
            $_SESSION["usertype"] = "vet";

            $_SESSION["username"] = $username;
            $_SESSION["nome"] = $nome;
            $_SESSION["cognome"] = $cognome;
            $_SESSION["email"] = $email;
            $_SESSION["id"] = $conn->insert_id;

            header("Location: dashboard_vet.php");
            die();

        }else{
            header("Location: signin_vet.php?status=error");
            die();
        }

    }
}


?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>signin vet</title>
</head>
<body>
    <h1>sign-in vet</h1>
    <form action="signin_vet.php" method="post">
        <label for="nome">Nome: </label><br>
        <input type="text" name="nome" id="nome" placeholder="inserire il proprio nome" autocomplete="off" required><br>
        <label for="cognome">Cognome: </label><br>
        <input type="text" name="cognome" id="cognome" placeholder="inserire il proprio cognome" autocomplete="off" required><br>
        <label for="email">Email: </label><br>
        <input type="text" name="email" id="email" placeholder="inserire email" autocomplete="off" required><br>
        <label for="username">Username: </label><br>
        <input type="text" name="username" id="username" placeholder="inserire username" autocomplete="off" required><br>
        <label for="password">Password: </label><br>
        <input type="password" name="password" id="password" placeholder="inserire password" autocomplete="off" required><br>

        <input type="submit" value="sign-in">

    </form>
    <h1><?php echo $error ?? '' ?></h1>
</body>
</html>



