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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="d-flex vh-100 justify-content-center align-items-center bg-dark " >

    <div class="row justify-content-center g-4">
        <!-- classi prese da esempi https://getbootstrap.com/docs/5.0/components/card/ -->

        <!-- per il login -->
        <div class="col-md-5">
            <!-- inizio div card-->
            <div class="card h-100 text-center">
                <div class="card-body">
                    <!-- <i> separato o dentro a <h3>? 
                        todo chiedere al prof
                    -->
                    <i class="bi bi-person-plus text-primary fs-1"></i>
                    <h3 class="card-title mt-3">Sign in proprietario</h3>
                    <p class="card-text">possiedi un animale? crea un account</p>
                    <a href="signin_customer.php" class="btn btn-primary"><i class="bi bi-plus-circle-dotted  me-1"></i> Crea account</a>
                </div>
            </div>
        </div>
        
        <!-- per il signin -->
        <div class="col-md-5">
            <!-- inizio div card-->
            <div class="card h-100 text-center">
                <div class="card-body">
                    <!-- <i> separato o dentro a <h3>? 
                        todo chiedere al prof
                    -->
                    <i class="bi bi-person-plus text-primary fs-1"></i>
                    <h3 class="card-title mt-3">Sign in veterinario</h3>
                    <p class="card-text">sei un veterinario? crea un account</p>
                    <a href="signin_vet.php" class="btn btn-primary"><i class="bi bi-plus-circle-dotted  me-1"></i>Crea account</a>
                </div
                
            </div>
        </div>
    </div>

</body>
</html>

