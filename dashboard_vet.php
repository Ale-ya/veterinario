<?php

require_once("connection/connection.php");
//ricordarsi che quando si usa require_once() viene eseguito tutto il codice "libero" automaticamente appena viene chamato
require_once("connection/check_vet.php");

//prima fetch dati poi mostro
//

$conn = get_conn();
$sql = "select * from pazienti_veterinari pv join pazienti p on p.id = pv.id_paziente where id_veterinario = {$_SESSION['id']}";
$res = $conn->query($sql);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="d-flex justify-content-center bg-dark py-5" >

    <div class="p-5 text-center bg-white text-dark rounded-3 ">

    <p class="h1 mb-2 fw-bold text-primary ">
        Benvenuta/o, dottor <br>
        <strong><?php echo htmlspecialchars($_SESSION['username']); ?></strong>
        <!-- strong utile per rendere piùvisibile non necessario -->
    </p>
    
    <!-- span(inline)? -->
    <div class="badge bg-warning text-dark mb-4" >
        <?php echo $_SESSION['usertype'] == 'vet' ? 'Veterinario' : 'Proprietario'; ?>
    </div>

    <div class="mt-3 mb-5 d-grid gap-3 ">
        <a href="logout.php" class="btn btn-danger btn-lg">
            <i class="bi bi-box-arrow-right me-2"></i> Logout
        </a>
    </div>
    <?php 

        foreach ($res as $record) {
            
            echo "<div class='p-4 p-sm-5 text-center bg-light text-secondary rounded-3 mb-5 border border-secondary border-1 rounded-3'>";
            echo "<p class='h2 mb-4 fw-semibold text-secondary'> " . $record["nome_paziente"] . ", ". $record["razza"] . "</p>";
            echo "<div class='btn-group'>";
            echo "<a class='btn btn-primary btn-1g fs-0 fs-sm-3 ' href='storico.php?id={$record['id_paziente']}'><i class='bi bi-graph-up-arrow m-2'></i>storico</a></button>";
            echo "<a class='btn btn-primary btn-1g fs-0 fs-sm-3 ' href='info_animale.php?id={$record['id_paziente']}'><i class='bi bi-info-circle m-2'></i>informazioni generali</a></button>";
            echo "</div>";
            echo "</div>";

        }

    ?>

    </div>

</body>
</html>

