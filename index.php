

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Landing page</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="d-flex vh-100 justify-content-center align-items-center bg-dark " >
    <div class="container mt-5">
        <div class="row justify-content-center g-4">
            <!-- classi prese da esempi https://getbootstrap.com/docs/5.0/components/card/ -->

            <!-- per il login -->
            <div class="col-md-5">
                <!-- inizio div card-->
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <i class="bi bi-box-arrow-in-right fs-1"></i>
                        <h3 class="card-title mt-3">Login</h3>
                        <p class="card-text">Già registrato? Accedi subito</p>
                        <a href="login.php" class="btn btn-primary">Accedi</a>
                    </div>
                </div>
            </div>
            
            <!-- per il signin -->
            <div class="col-md-5">
                <!-- inizio div card-->
                <div class="card h-100 text-center">
                    <div class="card-body">
                        <i class="bi bi-person-plus fs-1"></i>
                        <h3 class="card-title mt-3">Registrati</h3>
                        <p class="card-text">Nuovo utente? Crea un account</p>
                        <a href="choose_signin_type.php" class="btn btn-success">Registrati</a>
                    </div>
                    
                </div>
            </div>
        </div>
    </div>

</body>
</html>


