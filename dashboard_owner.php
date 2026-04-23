<?php
require_once("connection/check_owner.php");
//debug 
//var_dump($_SESSION); 
//die();

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="d-flex vh-100 justify-content-center align-items-center bg-dark " >
<div class="p-5 text-center bg-secondary text-white rounded-3">
    <h1>Benvenuta/o, <?php echo  ($_SESSION['type'] == 'vet' ? 'dottor ' : '') . $_SESSION['username'] ?></h1><br><br>
    <a href="insert_log.php" class="btn btn-primary">Inserisci nuovo monitoraggio</a><br><br>
    <a href="insert_animale.php" class="btn btn-primary">Inserisci animale</a><br><br>
      <!--
    <button class="btn btn-primary">Primary</button>
    <button class="btn btn-success">Success</button>
      -->
</div>

<!--
<div class="container">
    <h1><?php echo htmlspecialchars($_SESSION["username"]) ?></h1>
    <form action="login.php" method="POST">
        <input type="hidden" name="type" value="vet">
        <button type="submit">Sign-in Vet</button>
    </form>

    <form action="login.php" method="POST">
        <input type="hidden" name="type" value="customer">
        <button type="submit">Sign-in Customer</button>
    </form>
</div>
-->
</body>
</html>
