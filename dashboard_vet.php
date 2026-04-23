<?php
session_start();
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
<body class="dacambiare" >

<h1>Benvenuta/o, <?php echo  ($_SESSION['type'] == 'vet' ? 'dottor ' : '') . $_SESSION['username'] ?></h1><br><br>

<?php 

    foreach ($res as $record) {
        
        echo "<div class='p-5 text-center bg-secondary text-white rounded-3'>";
        echo "<h1> " . $record["nome_paziente"] . " ". $record["razza"] . "</h1>";
        echo "<div class='btn-group'>";
        echo "<button type='button' class='btn btn-primary'><a href='storico.php?id={$record['id_paziente']}'>storico</a></button>";
        echo "<button type='button' class='btn btn-primary'><a href='info.php?id={$record['id_paziente']}'>informazioni generali</a></button>";
        echo "</div>";
        echo "</div>";

    }

?>



</body>
</html>
