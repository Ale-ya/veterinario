<?php
require_once("connection/check_owner.php");

require_once("connection/connection.php");
/*
error_reporting(E_ALL);
ini_set('display_errors', 1);
var_dump($_SESSION);
*/

if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["nome"]) && isset($_POST["date"])  && isset($_POST["peso"]) && isset($_POST["razza"]) && isset($_POST["sesso"]) && isset($_POST["terapia_t0"]) && isset($_POST["dieta_t0"]) && isset($_POST["sospetta_diagnosi_t0"])&& isset($_POST["vet"])){
        $nome = htmlspecialchars($_POST["nome"]);
        $date = htmlspecialchars($_POST["date"]);
        $peso = htmlspecialchars($_POST["peso"]);
        $razza = htmlspecialchars($_POST["razza"]);
        $sesso = htmlspecialchars($_POST["sesso"]);
        $terapia_t0 = htmlspecialchars($_POST["terapia_t0"]);
        $dieta_t0 = htmlspecialchars($_POST["dieta_t0"]);
        $sospetta_diagnosi_t0  = htmlspecialchars($_POST["sospetta_diagnosi_t0"]);
        $vetid = htmlspecialchars($_POST["vet"]);
        
        $conn = get_conn();
        if(!isset($_SESSION["id"])){
            header("Location: login.php");
        }
        $sql  = "INSERT INTO `pazienti`(`id_proprietario`, `nome_paziente`, `data_nascita`, `peso`, `razza`, `sesso`, `terapie_T0`, `dieta_T0`, `sospetta_diagnosi_T0`) VALUES ('{$_SESSION['id']}','{$nome}','{$date}','{$peso}','{$razza}','{$sesso}','{$terapia_t0}','{$dieta_t0}','{$sospetta_diagnosi_t0}')";
        $res = $conn->query($sql);
        $paz_id = $conn->insert_id;
        $sql_lookuptable = "insert into pazienti_veterinari (id_paziente, id_veterinario) values ({$paz_id}, {$vetid})";
        if ($res){
            $res = $conn->query($sql_lookuptable);
            if($res){
                header("Location: dashboard_owner.php");
                die();
            }
            header("Location: insert_animale.php?status=error_assoc");
            die();
        }else{
            header("Location: insert_animale.php?status=error");
            die();
        }

    }
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <title>Aggiunta di un nuovo animale</title>
</head>
<body class=" d-flex justify-content-center bg-dark py-5" >

    <div class="p-5  bg-light text-muted rounded-3">
        <div class="d-flex justify-content-between align-items-center ">
            <p class="h1 mb-5 fw-bold text-primary me-3">Aggiungi un animale</p>
            <!-- <i> per mettere le icone è consigliato dalla documentazione -->
            <a href="dashboard_owner.php" class="btn btn-secondary mb-5 ms-1 "><i class="bi bi-house me-1"></i> Torna alla home</a>
        </div>
        <form action="insert_animale.php" method="post">

            <div class="mb-3 mt-3 form-floating">
                <!-- placeholder necessario per l'animzaione --> 
                <input  class="form-control" type="text" name="nome" id="nome" required placeholder=" inseriere il nome ">
                <label class="form-label" for="nome" >nome animale:</label>
            </div>
            <div class="mb-3 mt-3 form-floating">
                <input  class="form-control" type="number" name="peso" id="peso" min="1" step="0.1" required>
                <label for="peso" class="form-label">peso: (kg) </label>
            </div>
            <div class="mb-3 mt-3 form-floating">
                <input class="form-control"  type="text" name="razza" id="razza" required placeholder=" inseriere la razza ">
                <label for="razza" class="form-label">razza:</label>
            </div>

            
            <div class="mb-3 mt-3 form-floating">
                <input  class="form-control" type="text" name="terapia_t0" id="terapia_t0" required placeholder=" ">
                <label for="terapia_t0" class="form-label"> terapia_t0 </label>
            </div>
            <div class="mb-3 mt-3 form-floating">
                <input  class="form-control" type="text" name="dieta_t0" id="dieta_t0" required placeholder=" ">
                <label for="dieta_t0" class="form-label"> dieta T0: </label>
            </div>
            <div class="mb-3 mt-3 form-floating">
                <input class="form-control" type="text" name="sospetta_diagnosi_t0" id="sospetta_diagnosi_t0" required placeholder=" ">
                <label for="sospetta_diagnosi_t0" class="form-label"> terapia_t0 </label>
            </div>

            <div class="mb-3 mt-3 form-floating">
            <?php 
            //parte di codice presa da https://www.html.it/articoli/date-in-php-come-gestirle/
            $data_età_minima = date('Y-m-d', strtotime('-1 days'));
            $data_età_massima   = date('Y-m-d', strtotime('-25 year'));
            echo " <input type='date' class='form-control' name='date' id='date' min='{$data_età_massima}' max='{$data_età_minima}' value='{$data_età_minima}'><br><br>";
 
            ?>
            <label for="date" class="form-label">Data di nascita: </label>
            </div>

            <div class="d-flex gap-3">
                <!--  
                0 (false) = femmina
                1 (true) = maschio
                -->
                <input type="radio" class="btn-check" name="sesso" id="sesso_m" value="1" autocomplete="off" checked>
                <label class="btn btn-outline-primary rounded-pill px-4" for="sesso_m">Maschio</label>

                <input type="radio" class="btn-check" name="sesso" id="sesso_f" value="0" autocomplete="off">
                <label class="btn btn-outline-primary rounded-pill px-4" for="sesso_f">Femmina</label>
            </div><br>

            <!--
            <label for="sesso" class="form-label">sesso: </label>
            <select name="sesso" id="sesso" class="form-select">
                <option value="1">MASCHIO</option>
                <option value="0">FEMMINA</option>
            </select><br> 
            -->

            <label for="vet" class="form-label">veterinario specifico</label>
            <select name="vet" id="vet" class="form-select">

                <?php
                    $conn = get_conn();
                    $sql = "SELECT id, nome, cognome, username FROM `veterinari` ";
                    $res = $conn->query($sql);
                    
                    if (!$res){
                        echo "<option value='unknown'>dati non disponibili</option>";
                        exit();
                    }
                    foreach($res as $record){
                        echo "<option value='" . $record['id'] . "'>" . $record['username'] ." ( " . $record['nome'] . " " . $record['cognome'] . " ) ". "</option>";
                    }
                ?>

            </select><br> 

            <button class="btn btn-success" type="submit">Inserisci animale</button>
        </form>
    </div>
</body>
</html>



