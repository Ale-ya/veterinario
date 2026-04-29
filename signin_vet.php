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
        $sql = "select * from veterinari where  username = '{$username}'";
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <title>signin vet</title>
</head>
<body class="d-flex p-3 justify-content-center align-items-center bg-dark ">
    <div class="p-4  bg-secondary text-white rounded-3">

        <p class="h1 mb-5 fw-bold text-primary me-2">sign-in vet</p>
        <form action="signin_vet.php" method="post">
            <div class="mb-1 mt-1 form-floating" style="min-width: 45vw;">
            <input class="form-control" type="text" name="nome" id="nome" placeholder="inserire il proprio nome" autocomplete="off" required><br>
            <label class="form-label" for="nome">Nome: </label>
            </div>

            <div class="mb-1 mt-1 form-floating" style="min-width: 45vw;">
            <input class="form-control" type="text" name="cognome" id="cognome" placeholder="inserire il proprio cognome" autocomplete="off" required><br>
            <label class="form-label" for="cognome">Cognome: </label>
            </div>

            <div class="mb-1 mt-1 form-floating" style="min-width: 45vw;">
            <input class="form-control" type="text" name="email" id="email" placeholder="inserire email" autocomplete="off" required><br>
            <label class="form-label" for="email">Email: </label>
            </div>

            <div class="mb-1 mt-1 form-floating" style="min-width: 45vw;">
            <input class="form-control" type="text" name="username" id="username" placeholder="inserire username" autocomplete="off" required><br>
            <label class="form-label" for="username">Username: </label>
            </div>

            <div class="mb-1 mt-1 form-floating" style="min-width: 45vw;">
            <input class="form-control" type="password" name="password" id="password" placeholder="inserire password" autocomplete="off" required><br>
            <label class="form-label" for="password">Password: </label>
            </div>

            <button class="btn btn-success" type="submit">Crea account</button>

        </form>
        <p class="h1 mb-5 fw-bold text-primary me-2"><?php echo $error ?? '' ?></p>
    </div>
</body>
</html>



