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
    <title>Aggiunta di un nuovo animale</title>
</head>
<body class=" d-flex justify-content-center bg-dark py-5" >

    <div class="p-5  bg-secondary text-white rounded-3">
        <h1>Questionario per l'aggiunta di un animale</h1>
        <form action="insert_animale.php" method="post">

            <div class="mb-3 mt-3">
                <label for="nome" class="form-label">nome animale:</label>
                <input  class="form-control" type="text" name="nome" id="nome" required>
            </div>
            <div class="mb-3 mt-3">
                <label for="peso" class="form-label">peso: </label>
                <input  class="form-control" type="number" name="peso" id="peso" min="1" step="0.1" required><span > kg</span>
            </div>
            <div class="mb-3 mt-3">
                <label for="razza" class="form-label">razza:</label>
                <input class="form-control"  type="text" name="razza" id="razza" required>
            </div>

            
            <div class="mb-3 mt-3">
                <label for="terapia_t0" class="form-label"> terapia_t0 </label>
                <input  class="form-control" type="text" name="terapia_t0" id="terapia_t0" required>
            </div>
            <div class="mb-3 mt-3">
                <label for="dieta_t0" class="form-label"> terapia_t0 </label>
                <input  class="form-control" type="text" name="dieta_t0" id="dieta_t0" required>
            </div>
            <div class="mb-3 mt-3">
                <label for="sospetta_diagnosi_t0" class="form-label"> terapia_t0 </label>
                <input class="form-control" type="text" name="sospetta_diagnosi_t0" id="sospetta_diagnosi_t0" required>
            </div>

            <div class="mb-3 mt-3">
                <label for="date" class="form-label">data di nascita:</label>
                <input class="form-control" type="date" name="date" id="date" required>
            </div>

            <label for="sesso" class="form-label">sesso: </label>
            <select name="sesso" id="sesso" class="form-select">
                <!--  
                0 (false) = femmina
                1 (true) = maschio
                -->
                <option value="1">MASCHIO</option>
                <option value="0">FEMMINA</option>
            </select><br> 

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

            <button class="btn btn-success" type="submit">Login</button>
        </form>
    </div>
</body>
</html>



