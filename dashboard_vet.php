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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="d-flex justify-content-center bg-dark py-5" >

    <div class="p-5 text-center bg-white text-dark rounded-3 ">
    <p class="h1 mb-1 fw-bold text-primary me-1">Benvenuta/o, <?php echo  ($_SESSION['usertype'] == 'vet' ? 'dottor ' : '') . $_SESSION['username'] ?></p><br><br>

    <?php 

        foreach ($res as $record) {
            
            echo "<div class='p-5 text-center bg-light text-secondary rounded-3 mb-5 border border-secondary border-1 rounded-3'>";
            echo "<p class='h2 mb-4 fw-semibold text-secondary'> " . $record["nome_paziente"] . ", ". $record["razza"] . "</p>";
            echo "<div class='btn-group'>";
            echo "<a class='btn btn-primary btn-1g fs-3' href='storico.php?id={$record['id_paziente']}'>storico</a></button>";
            echo "<a class='btn btn-primary btn-1g fs-3' href='info_animale.php?id={$record['id_paziente']}'>informazioni generali</a></button>";
            echo "</div>";
            echo "</div>";

        }

    ?>

    </div>

</body>
</html>
