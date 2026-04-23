<?php
session_start();

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
        <h1> scegliere il tipo di accesso: </h1>
        <form action="signin_vet.php" method="POST">
            <div class="mb-3 mt-3">
            <input type="hidden" name="type" value="vet">
            <button class="btn btn-primary" type="submit">Sign-in veterinario</button>
            </div>
        </form>

        <form action="signin_customer.php" method="POST">
            <div class="mb-3 mt-3">
            <input type="hidden" name="type" value="customer">
            <button class="btn btn-primary" type="submit">sign-in proprietario</button>
            </div>
        </form>
    </div>

</body>
</html>

