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
    <?php
    $values= ["username","cognome","nome","nome_paziente","razza","peso","data_nascita", "terapie_T0","dieta_T0", "sospetta_diagnosi_T0","sesso"];
    foreach ($values as $variable) {
        if(!isset($data[$variable])){
            http_response_code(500);
            echo "<p class='h2 mb-4 fw-semibold text-warning'> alcuni dati sul paziente non sono disponibili</p>";
            exit();
        }
    }
    ?>
    <title>Informazioni <?php echo $data['nome_paziente']?></title>
    <link href="css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body class="d-flex justify-content-center bg-dark p-3 p-sm-5 ">
<div class="container-fluid p-3 p-sm-5 text-center bg-white text-dark rounded-3" style="min-width: 70vw;">
    <div class="d-flex justify-content-between align-items-center me-auto">
        <p class="h1 mb-5 fw-bold text-primary me-2 me-sm-4">Info Generali</p>
        <a href="dashboard_vet.php" class="btn btn-secondary mb-5 ms-1"><i class="bi  bi-house me-1"></i>Torna alla home</a>
    </div>
    
    <p class='h3 mb-5 fw-semibold text-dark me-4'>Nome animale: <?php echo $data['nome_paziente'] ." (". $data['razza'] ?> )</p>
    <p class='h3 mb-5 fw-semibold text-dark me-4'>Nome proprietario: <?php echo $data['nome']. " ". $data['cognome']. " (". $data['username']?> )</p>

    <!-- mantenere h-100 per avere altezza uniforme tra le righe e le colonne  -->
    <div class="row g-4 mt-2">
        <div class="col-md-4">
            <div class="border rounded p-3 bg-light h-100 text-start text-break  ">
                <p class="h5 fw-semibold text-dark mb-0">Peso: <small class="text-muted d-flex mt-1"><?php echo $data['peso']; ?>kg</small></p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="border rounded p-3 bg-light h-100 text-start text-break  ">
                <p class="h5 fw-semibold text-dark mb-0">
                    Sesso: <small class="text-muted d-flex mt-1"><?php echo ($data['sesso'] == 1) ? "Femmina" : "Maschio"; ?></small>
                </p>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="border rounded p-3 bg-light h-100 text-start text-break  ">
                <p class="h5 fw-semibold text-dark mb-0">Data di nascita: <small class="text-muted d-flex mt-1"><?php echo $data['data_nascita']; ?></small></p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="border rounded p-3 bg-light h-100 text-start text-break  ">
                <p class="h5 fw-semibold text-dark mb-0">Terapie T0: <small class="text-muted d-flex mt-1"><?php echo $data['terapie_T0']; ?></small></p>
            </div>
        </div>
        
        <div class="col-md-4">
            <div class="border rounded p-3 bg-light h-100 text-start  text-break ">
                <p class="h5 fw-semibold text-dark mb-0">Dieta T0: <small class="text-muted d-flex mt-1"><?php echo $data['dieta_T0']; ?></small></p>
            </div>
        </div>
        <div class="col-md-4">
            <div class="border rounded p-3 bg-light h-100 text-start text-break ">
                <p class="h5 fw-semibold text-dark mb-0">Sospetta diagnosi T0: <small class="text-muted d-flex mt-1"><?php echo $data['sospetta_diagnosi_T0']; ?></small></p>
            </div>
        </div>
    </div>
</div>

</body>
</html>


