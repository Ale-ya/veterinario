<?php
require_once("connection/connection.php");
//ricordarsi che quando si usa require_once() viene eseguito tutto il codice "libero" automaticamente appena viene chamato
require_once("connection/check_vet.php");



if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET"){
    if(isset($_GET["id"]) && isset($_SESSION)){
        $conn = get_conn();
        $id_paziente = htmlspecialchars($_GET['id']);
        $sql = "select pa.*, pr.nome, pr.cognome, pr.username from pazienti pa join proprietari pr on pr.id = pa.id_proprietario where pa.id = {$id_paziente} ";
        $res = $conn->query($sql);
        if (!$res){
            //todo chiedere al prof se è meglio usare il 500(internal server error) o il 503(service unavailable)
            http_response_code(500);
            echo "<h1> Dati sul paziente non disponibili</h1>";
            exit();
        }
        if($res->num_rows  == 1){
            $data = $res->fetch_assoc();
        }else{
            echo "<h1> Dati sul paziente non disponibili </h1>";
            exit();
        }

    }

}


?>




<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title></title>
    <link href="css/style.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="d-flex justify-content-center bg-dark py-5">
<div class=" p-5 text-center bg-white text-dark rounded-3 " style="min-width: 70vw;">
    <div class="d-flex justify-content-between align-items-center me-auto">
        <p class="h1 mb-5 fw-bold text-primary me-4">Informazioni Generali</p>
        <a href="dashboard_vet.php" class="btn btn-secondary mb-5 ms-1">Torna alla home</a>
    </div>
    <?php 
    $values= ["username","cognome","nome","nome_paziente","razza","peso","data_nascita", "terapie_T0","dieta_T0", "sospetta_diagnosi_T0","sesso"];
    foreach ($values as $variable) {
        if(!isset($data[$variable])){
            http_response_code(500);
            echo "<h1> alcuni dati sul paziente non sono disponibili</h1>";
            var_dump($data);
            exit();
        }
    }

    echo "<p class='h2 mb-5 fw-semibold text-dark me-4'>Nome animale: ". $data['nome_paziente']." (". $data['razza'].")</p>";
    echo "<p class='h2 mb-5 fw-semibold text-dark me-4'>Nome proprietario: ". $data['nome']. " ". $data['cognome']. " (". $data['username']. ")</p>";
    


    echo "<div class='mb-3 mt-3 row'>";
    echo "<div class='col'><p class='h3 mb-5 fw-semibold text-dark me-4'>Peso: {$data['peso']} kg</p></div>";
    echo "<div class='col'><p class='h3 mb-5 fw-semibold text-dark me-4'>Sesso: ";
    if($data['sesso'] == 1){
        echo "Femmina</p></div>";
    }else{
        echo "Maschio</p></div>";
    }
    echo "</div>";

    echo "<div class='mb-3 mt-3 row'>";
    echo "<div class='col'><p class='h3 mb-5 fw-semibold text-dark me-4'>Data di nascita: {$data['data_nascita']}</p></div>";
    echo "<div class='col'><p class='h3 mb-5 fw-semibold text-dark me-4'>Terapie T0: {$data['terapie_T0']}</p></div>";
    echo "</div>";

    echo "<div class='mb-3 mt-3 row'>";
    echo "<div class='col'><p class='h3 mb-5 fw-semibold text-dark me-4'>Dieta T0: {$data['dieta_T0']}</p></div>";
    echo "<div class='col'><p class='h3 mb-5 fw-semibold text-dark me-4'>Sospetta diagnosi T0: {$data['sospetta_diagnosi_T0']}</p></div>";
    echo "</div>";
        
    ?>


</div>
</body>
</html>


