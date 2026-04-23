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
    if(isset($_POST["nome"]) && isset($_POST["cognome"])  && isset($_POST["email"]) && isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["vet"])){
        $nome = htmlspecialchars($_POST["nome"]);
        $cognome = htmlspecialchars($_POST["cognome"]);
        $email = htmlspecialchars($_POST["email"]);
        $username = htmlspecialchars($_POST["username"]);
        $pass = htmlspecialchars($_POST["password"]);
        $id_vet = htmlspecialchars($_POST["vet"]);
        $hash_pass = password_hash($pass, PASSWORD_DEFAULT);
        
        $conn = get_conn();

        $sql = "select * from proprietari where username = '{$username}'";
        $res = $conn->query($sql);

        if($res){
            $data = $res->fetch_assoc();
            if($data["username"] == $username){
                header("Location: signin_customer.php?status=usernameused");
                die();
            }
        }else{
            header("Location: signin_customer.php?status=usernameerror");
            die();
        }

        $sql  = "";
        if ($id_vet == "none" || $id_vet == "unknown"){
            $sql = "insert into proprietari (username, password, nome, cognome,email) values ('{$username}', '{$hash_pass}','{$nome}','{$cognome}','{$email}')";
        }else{
            $sql = "insert into proprietari (id_vet, username, password, nome, cognome,email) values ('{$id_vet}','{$usename}', '{$hash_pass}','{$nome}','{$cognome}','{$email}')";
        }
        $res = $conn->query($sql);

        if ($res){
            $_SESSION["status"] = "verified";
            $_SESSION["usertype"] = "owner";

            $_SESSION["username"] = $username;
            $_SESSION["nome"] = $nome;
            $_SESSION["cognome"] = $cognome;
            $_SESSION["email"] = $email;
            $_SESSION["id"] = $conn->insert_id;

            header("Location: dashboard_owner.php");
            die();
        }else{
            header("Location: signin_customer?status=error");
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <title>LOGIN</title>
</head>
<body class="d-flex vh-100 justify-content-center align-items-center bg-dark " >

    <div class="p-5  bg-secondary text-white rounded-3">
        <h1>Sign-in</h1>
        <form action="signin_customer.php" method="post">
            
            <div class="mb-3 mt-3">
            <label for="nome" class="form-label">Nome: </label><br>
            <input  class="form-control" type="text" name="nome" id="nome" placeholder="inserire il proprio nome" autocomplete="off" required>
            </div>

            <div class="mb-3 mt-3">
            <label for="cognome" class="form-label">Cognome: </label><br>
            <input  class="form-control" type="text" name="cognome" id="cognome" placeholder="inserire il proprio cognome" autocomplete="off" required>
            </div>

            <div class="mb-3 mt-3">
            <label for="email" class="form-label">Email: </label><br>
            <input class="form-control"  type="text" name="email" id="email" placeholder="inserire email" autocomplete="off" required>
            </div>
            
            <div class="mb-3 mt-3">
            <label for="username" class="form-label">Username: </label><br>
            <input  class="form-control" type="text" name="username" id="username" placeholder="inserire username" autocomplete="off" required>
            </div>

            <div class="mb-3 mt-3">
            <label for="password" class="form-label">Password: </label><br>
            <input  class="form-control" type="password" name="password" id="password" placeholder="inserire password" autocomplete="off" required>
            </div>

            <label for="vet" class="form-label">vet:</label>
            <select name="vet" id="vet"  class="form-select">
                <option value="none"> non associarti a nessun vet </option>
                <?php
                    //require("connection/connection.php");
                    $conn = get_conn();
                    $sql = "select id, nome, cognome from veterinari";
                    $res = $conn->query($sql);
                    if (!$res){
                        echo "<option value='unknown'>dati non disponibili</option>";
                    }else{
                        foreach($res as $record){
                            echo "<option value='" . $record['id'] . "'>" . $record['nome'] . " " . $record['cognome'] . "</option>";
                        }
                    }
                ?>
            </select><br>

            <button class="btn btn-success" type="submit">Crea account</button>

        </form>
    </div>
</body>
</html>







