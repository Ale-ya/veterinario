<?php 
session_start();

require_once("connection/connection.php");

$str = "";

if (isset($_GET["status"])) {

    if ($_GET["status"] == "databaseerror") {
        $str = "Errore del database";
    } elseif ($_GET["status"] == "accountunknown") {
        $str = "Username non trovato";
    } elseif ($_GET["status"] == "passworderror") {
        $str = "Password errata";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["type"], $_POST["username"], $_POST["password"])) {
        $connection = get_conn();

        $user = $_POST["username"];
        $type = $_POST["type"];
        $pass = $_POST["password"];

        if ($type == "vet") {
            $table = "veterinari";
        } elseif ($type == "owner") {
            $table = "proprietari";
        } else {
            die("Tipo non valido");
        }

        $sqlquery = "SELECT id, username, nome, cognome, password, email FROM $table WHERE username = '$user'";

        $res = $connection->query($sqlquery);

        if (!$res) {
            header("Location: login.php?status=databaseerror");
            exit;
        }

        if ($res->num_rows === 1) {
            $data = $res->fetch_assoc();
            
            if (password_verify($pass, $data["password"])) {

                //operatore ternario per evitare troppi if
                $_SESSION["usertype"] = $type == "vet" ? "vet" : "owner";

                $_SESSION["status"] = "verified";
                $_SESSION["username"] = $data["username"];
                $_SESSION["nome"] = $data["nome"];
                $_SESSION["cognome"] = $data["cognome"];
                $_SESSION["email"] = $data["email"];
                $_SESSION["id"] = $data["id"];


                if($type == "vet"){
                    header("Location: dashboard_vet.php");
                }else{
                    header("Location: dashboard_owner.php");
                }
                exit;

            } else {
                header("Location: login.php?status=passworderror");
                exit;
            }
        } else {
            header("Location: login.php?status=accountunknown");
            exit;
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <title>Login Page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="d-flex vh-100 p-3 p-sm-5 justify-content-center align-items-center bg-dark " >

    <div class="p-4 p-sm-5 text-center bg-light text-dark rounded-3 align-items-center ">
        <div class="d-flex justify-content-between align-items-center ">
            <p class="h1 mb-5 fw-bold text-primary me-3">Login</p>
            <!-- <i> per mettere le icone è consigliato dalla documentazione -->
            <a href="index.php" class="btn btn-white  mb-5 ms-1 p-0"><i class="bi bi-arrow-left-circle text-primary fs-2"  ></i></a>
        </div>
        <h1><?php echo $str ?? ''?></h1>
        <form action="login.php" method="post">
            <div class="d-flex flex-wrap gap-2" style="max-width: 70vw;">
                <input type='radio' class='btn-check' name='type' id='veterinario' value='vet' autocomplete='off' checked>
                <label class='btn btn-outline-primary rounded-pill px-3 px-sm-4 ' for='veterinario'> Veterinario </label>
                <input type='radio' class='btn-check' name='type' id='customer' value='owner' autocomplete='off'>
                <label class='btn btn-outline-primary rounded-pill px-3 px-sm-4 ' for='customer'> Proprietario </label>
            </div>

            <div class="mb-3 mt-3 form-floating">
                <input  class="form-control" type="text" name="username" id="username" required placeholder="">
                <label for="username" class="form-label">Username: </label>
            </div>
            <div class="mb-3 mt-3 form-floating">
                <input class="form-control" type="password" name="password" id="password" required placeholder="">
                <label for="password" class="form-label">Password: </label>
            </div>
            <button class="btn btn-success" type="submit"><i class="bi bi-box-arrow-in-right me-1"></i> Login</button>
        </form>
    </div>

</body>
</html>

