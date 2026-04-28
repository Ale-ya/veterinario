<!--
vedere la documetnazioen  
https://icons.getbootstrap.com/
-->

<?php
require_once("connection/check_owner.php");
//debug 
//var_dump($_SESSION); 
//die();
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <title>Dashboard - Pet Monitoring</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="d-flex vh-100 justify-content-center align-items-center bg-dark">
    <div class="container row justify-content-center">
        <!--<div class="row justify-content-center " style="min-width: 40vw;">-->
        <!--
        tentativo di renderlo più responsive possibile seguendo la documentazioen fornita https://getbootstrap.com/docs/5.0/layout/columns/
        bootstrap divide il display in 12 colonne ( poi centra con justify-content-center)
        col-md-6 = usa 6 colonne negli schermi medi 
        col-lg-5 = si usa per gli schermi grandi (5 colonne)
        md e lg identificano lo schermo per rendere responsive il tutto 
        -->
        
        <div class="col-md-6 col-lg-5">

            <div class="p-4 p-md-5 text-center bg-light text-dark rounded-3 ">
                
                <p class="h1 mb-2 fw-bold text-primary ">
                    Benvenuta/o, <br>
                    <strong><?php echo ($_SESSION['type'] == 'vet' ? 'dottor ' : '') . htmlspecialchars($_SESSION['username']); ?></strong>
                </p>
                
                <!-- span(inline)? -->
                <div class="badge bg-warning text-dark mb-4">
                    <?php echo $_SESSION['type'] == 'vet' ? 'Veterinario' : 'Proprietario'; ?>
                </div>
                
                <!-- per icone bootstrap "bi bi{nome icona trovato in https://icons.getbootstrap.com/}"-->
                <div class="pb-2 mt-4 d-grid gap-3 border-bottom border-3 border-secondary">
                    <a href="insert_log.php" class="btn btn-light btn-lg bg-warning">
                        <i class="bi bi-clipboard-plus me-2"></i> Inserisci nuovo monitoraggio
                    </a>
                    <a href="insert_animale.php" class="btn btn-outline-light btn-lg bg-primary">
                        <i class="bi bi-plus-circle me-2"></i> Inserisci animale
                    </a>
                </div>
                <div class="mt-3 d-grid gap-3 ">
                    <a href="logout.php" class="btn btn-danger btn-lg">
                        <i class="bi bi-box-arrow-right me-2"></i> Logout
                    </a>

                </div>
            </div>

        </div>
    </div>
</body>
</html>
