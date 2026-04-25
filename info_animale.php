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
    <body>
    <div class="container">
        <?php 
        if(isset($data['username']) && trim($data['username']) !== "" && isset($data['cognome']) && trim($data['cognome']) !== "" && isset($data['nome']) && trim($data['nome']) !== "" && isset($data['nome_paziente']) && trim($data['nome_paziente']) !== "" && isset($data['razza']) && trim($data['razza']) !== ""){
            echo "<p class='h1'>Nome animale: ". $data['nome_paziente']." (". $data['razza'].")</p>";
            echo "<p class='h2'>Nome proprietario: ". $data['nome']. " ". $data['cognome']. " (". $data['username']. ")</p>";
        }
        ?>
        

        <?php 

        echo "<div class='mb-3 mt-3 row'>";
        echo "<div class='col'><p class='h1'>Peso:</p><p class='h3'>{$data['peso']}</p></div>";
        echo "<div class='col'><p class='h1'>Sesso:</p>";
        if($data['sesso'] == 1){
            echo "<p class='h3'>Femmina</p></div>";
        }else{
            echo "<p class='h3'>Maschio</p></div>";
        }
        echo "</div>";

        echo "<div class='mb-3 mt-3 row'>";
        echo "<div class='col'><p class='h1'>Data di nascita:</p><p class='h3'>{$data['data_nascita']}</p></div>";
        echo "<div class='col'><p class='h1'>Terapie T0:</p><p class='h3'>{$data['terapie_T0']}</p></div>";
        echo "</div>";

        echo "<div class='mb-3 mt-3 row'>";
        echo "<div class='col'><p class='h1'>Dieta T0:</p><p class='h3'>{$data['dieta_T0']}</p></div>";
        echo "<div class='col'><p class='h1'>Sospetta diagnosi T0:</p><p class='h3'>{$data['sospetta_diagnosi_T0']}</p></div>";
        echo "</div>";
            
        ?>


    </div>
    </body>
</html>


