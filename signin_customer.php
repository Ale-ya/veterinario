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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <title>LOGIN</title>
</head>
<body class="d-flex vh-100 justify-content-center align-items-center bg-dark p-5" >

    <div class="p-5  bg-white text-white rounded-3">
        <div class="d-flex justify-content-between align-items-center ">
            <p class="h1 mb-4 fw-bold text-primary me-5">Sign In</p>
            <!-- <i> per mettere le icone è consigliato dalla documentazione -->
            <a href="index.php" class="btn btn-white text-muted mb-4 ms-1 "><i class="bi bi-arrow-left text-muted me-1"></i> Torna indietro</a>
        </div>
        <form action="signin_customer.php" method="post">
            
            <div class="mb-3 mt-3 form-floating">
            <input  class="form-control" type="text" name="nome" id="nome" placeholder="inserire il proprio nome" autocomplete="off" required>
            <label for="nome" class="form-label">Nome: </label>
            </div>

            <div class="mb-3 mt-3 form-floating">
            <input  class="form-control" type="text" name="cognome" id="cognome" placeholder="inserire il proprio cognome" autocomplete="off" required>
            <label for="cognome" class="form-label">Cognome: </label>
            </div>

            <div class="mb-3 mt-3 form-floating">
            <input class="form-control"  type="text" name="email" id="email" placeholder="inserire email" autocomplete="off" required>
            <label for="email" class="form-label">Email: </label>
            </div>
            
            <div class="mb-3 mt-3 form-floating">
            <input  class="form-control" type="text" name="username" id="username" placeholder="inserire username" autocomplete="off" required>
            <label for="username" class="form-label">Username: </label>
            </div>

            <div class="mb-3 mt-3 form-floating">
            <input  class="form-control" type="password" name="password" id="password" placeholder="inserire password" autocomplete="off" required>
            <label for="password" class="form-label">Password: </label>
            </div>

            <label for="vet" class="form-label">vet:</label>
            <select name="vet" id="vet"  class="form-select mb-3">
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

            <button class="btn btn-success" type="submit"><i class="bi bi-person-plus-fill me-3 "></i> Crea account</button>

        </form>
    </div>
</body>
</html>
