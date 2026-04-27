

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
        <h1> Accesso all'applicazione: </h1>
        <a href="choose_signin_type.php" class="btn btn-secondary mb-5 ms-1">Sign-in</a>
        <a href="login.php" class="btn btn-secondary mb-5 ms-1">Login</a>
        <!--
        <form action="choose_signin_type.php" method="POST">
            <div class="mb-3 mt-3">
            <input type="hidden" name="type" value="vet">
            <button class="btn btn-primary" type="submit">Sign-in</button>
            </div>
        </form>

        <form action="login.php" method="POST">
            <div class="mb-3 mt-3">
            <input type="hidden" name="type" value="customer">
            <button class="btn btn-primary" type="submit">Login</button>
            </div>
        </form>
        -->
    </div>

</body>
</html>


