<?php
require_once("connection/check_owner.php");
require_once("connection/connection.php");
error_reporting(E_ALL);
ini_set('display_errors', 1);

if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_POST["animale"]) && isset($_POST["vomito"]) && isset($_POST["atteggiamento"])  && isset($_POST["appetito"]) && isset($_POST["dimagrimento"]) && isset($_POST["frequenza_feci"]) && isset($_POST["sangue"]) && isset($_POST["muco"]) && isset($_POST["flatulenza"]) && isset($_POST["lambimento"])&& isset($_POST["date"])){
        $vomito = htmlspecialchars($_POST["vomito"]);
        $atteggiamento = htmlspecialchars($_POST["atteggiamento"]);
        $appetito = htmlspecialchars($_POST["appetito"]);
        $dimagrimento = htmlspecialchars($_POST["dimagrimento"]);
        $frequenza_feci = htmlspecialchars($_POST["frequenza_feci"]);
        $sangue = htmlspecialchars($_POST["sangue"]);
        $muco = htmlspecialchars($_POST["muco"]);
        $lambimento  = htmlspecialchars($_POST["lambimento"]);
        $flatulenza = htmlspecialchars($_POST["flatulenza"]);
        $id_animale = htmlspecialchars($_POST["animale"]);
        $date = htmlspecialchars($_POST["date"]);

        $conn = get_conn();
        $sql  = "INSERT INTO `log`(`id_paziente`, `id_vomito`, `id_atteggiamento`, `id_appetito`, `id_dimagrimento`, `id_frequenza_feci`, `id_sangue`, `id_muco`, `id_flatulenza`, `id_lambimento`, `data_di_riferimento`) VALUES ('{$id_animale}','{$vomito}','{$atteggiamento}','{$appetito}','{$dimagrimento}','{$frequenza_feci}','{$sangue}','{$muco}','{$flatulenza}','{$lambimento}','{$date}')";
        $res = $conn->query($sql);
        
        if ($res){
            header("Location: dashboard_owner.php");
            die();

        }else{
            header("Location: signin_vet?status=error");
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
    <title>Document</title>
</head>
<body class="d-flex justify-content-center bg-dark py-5 " >
    <div class="p-5 text-center bg-light text-dark rounded-3">
        <form action="insert_log.php" method="post">
            <h2> Form monitoraggio </h2>
            <div class="d-flex gap-3">
                <p class="h3">Animale</p>
                <?php
                    if(isset($_SESSION['id'])){
                        $conn = get_conn();
                        $sql = "SELECT id, nome_paziente, razza, sesso FROM `pazienti` WHERE id_proprietario = {$_SESSION['id']}";

                        $res = $conn->query($sql);
                        if (!$res){
                            echo "<p class='h3 text-danger'>dati non disponibili, errore interno database</p>";
                        }else{
                            //se va in errore la query usando else evito di eseguire questa parte inutile
                            $first_radio_button = true;
                            foreach($res as $record){
                                $id_radio_button = "animale_{$record['id']}";
                                $checked = ($first_radio_button ? 'checked' : '');
                                $first_radio_button = false;
                                echo "
                                <input type='radio' class='btn-check' name='animale' id='{$id_radio_button}' value='{$record['id']}' autocomplete='off' {$checked}>
                                <label class='btn btn-outline-primary rounded-pill px-4' for='{$id_radio_button}'>{$record['nome_paziente']} ({$record['razza']} ".($record['sesso'] == 0 ? 'femmina' : 'maschio').")</label>";
                            }
                        }
                        
                    }else{
                        header("Location: login.php");
                        exit();
                    }
                ?>
            </div><br>

            <div class="d-flex gap-3">
                <p class="h3">Vomito</p>
                <?php
                    $conn = get_conn();
                    $sql = "select * from vomito";
                    $res = $conn->query($sql);
                    if (!$res){
                        echo "<p class='h3 text-danger'>dati non disponibili, errore interno database</p>";
                    }else{
                        //se va in errore la query usando else evito di eseguire questa parte inutile
                        $first_radio_button = true;
                        foreach($res as $record){
                            $id_radio_button = "vomito_{$record['id']}";
                            $checked = ($first_radio_button ? 'checked' : '');
                            $first_radio_button = false;
                            echo "
                            <input type='radio' class='btn-check' name='vomito' id='{$id_radio_button}' value='{$record['id']}' autocomplete='off' {$checked}>
                            <label class='btn btn-outline-primary rounded-pill px-4' for='{$id_radio_button}'>{$record['description']}</label>";
                        }
                    }
                        
                ?>
            </div><br>

            <div class="d-flex gap-3">
                <p class="h3">Frequenza feci</p>
                <?php
                    $conn = get_conn();
                    $sql = "select * from frequenza_feci";
                    $res = $conn->query($sql);
                    if (!$res){
                        echo "<p class='h3 text-danger'>dati non disponibili, errore interno database</p>";
                    }else{
                        //se va in errore la query usando else evito di eseguire questa parte inutile
                        $first_radio_button = true;
                        foreach($res as $record){
                            $id_radio_button = "freq_{$record['id']}";
                            $checked = ($first_radio_button ? 'checked' : '');
                            $first_radio_button = false;
                            echo "
                            <input type='radio' class='btn-check' name='frequenza_feci' id='{$id_radio_button}' value='{$record['id']}' autocomplete='off' {$checked}>
                            <label class='btn btn-outline-primary rounded-pill px-4' for='{$id_radio_button}'>{$record['description']}</label>";
                        }
                    }
                        
                ?>
            </div><br>

            <div class="d-flex gap-3">
                <p class="h3">Dimagrimento</p>
                <?php
                    $conn = get_conn();
                    $sql = "select * from dimagrimento";
                    $res = $conn->query($sql);
                    if (!$res){
                        echo "<p class='h3 text-danger'>dati non disponibili, errore interno database</p>";
                    }else{
                        //se va in errore la query usando else evito di eseguire questa parte inutile
                        $first_radio_button = true;
                        foreach($res as $record){
                            $id_radio_button = "dimagrimento_{$record['id']}";
                            $checked = ($first_radio_button ? 'checked' : '');
                            $first_radio_button = false;
                            echo "
                            <input type='radio' class='btn-check' name='dimagrimento' id='{$id_radio_button}' value='{$record['id']}' autocomplete='off' {$checked}>
                            <label class='btn btn-outline-primary rounded-pill px-4' for='{$id_radio_button}'>{$record['description']}</label>";
                        }
                    }
                ?>
            </div><br>
            <div class="d-flex gap-3">
                <p class="h3">Atteggiamento riscontrato:</p>
                <?php
                    $conn = get_conn();
                    $sql = "select * from atteggiamento";
                    $res = $conn->query($sql);
                    if (!$res){
                        echo "<p class='h3 text-danger'>dati non disponibili, errore interno database</p>";
                    }else{
                        //se va in errore la query usando else evito di eseguire questa parte inutile
                        $first_radio_button = true;
                        foreach($res as $record){
                            $id_radio_button = "atteggiamento_{$record['id']}";
                            $checked = ($first_radio_button ? 'checked' : '');
                            $first_radio_button = false;
                            echo "
                            <input type='radio' class='btn-check' name='atteggiamento' id='{$id_radio_button}' value='{$record['id']}' autocomplete='off' {$checked}>
                            <label class='btn btn-outline-primary rounded-pill px-4' for='{$id_radio_button}'>{$record['description']}</label>";
                        }
                    }
                ?>
            </div><br>
            <div class="d-flex gap-3">
                <p class="h3">Appetito:</p>
                <?php
                    $conn = get_conn();
                    $sql = "select * from appetito";
                    $res = $conn->query($sql);
                    if (!$res){
                        echo "<p class='h3 text-danger'>dati non disponibili, errore interno database</p>";
                    }else{
                        //se va in errore la query usando else evito di eseguire questa parte inutile
                        $first_radio_button = true;
                        foreach($res as $record){
                            $id_radio_button = "appetito_{$record['id']}";
                            $checked = ($first_radio_button ? 'checked' : '');
                            $first_radio_button = false;
                            echo "
                            <input type='radio' class='btn-check' name='appetito' id='{$id_radio_button}' value='{$record['id']}' autocomplete='off' {$checked}>
                            <label class='btn btn-outline-primary rounded-pill px-4' for='{$id_radio_button}'>{$record['description']}</label>";
                        }
                    }
                ?>
            </div><br>
            <div class="d-flex gap-3">
                <p class="h3">Muco:</p>
                <?php
                    $conn = get_conn();
                    $sql = "select * from muco";
                    $res = $conn->query($sql);
                    if (!$res){
                        echo "<p class='h3 text-danger'>dati non disponibili, errore interno database</p>";
                    }else{
                        //se va in errore la query usando else evito di eseguire questa parte inutile
                        $first_radio_button = true;
                        foreach($res as $record){
                            $id_radio_button = "muco_{$record['id']}";
                            $checked = ($first_radio_button ? 'checked' : '');
                            $first_radio_button = false;
                            echo "
                            <input type='radio' class='btn-check' name='muco' id='{$id_radio_button}' value='{$record['id']}' autocomplete='off' {$checked}>
                            <label class='btn btn-outline-primary rounded-pill px-4' for='{$id_radio_button}'>{$record['description']}</label>";
                        }
                    }
                ?>
            </div><br>

            <div class="d-flex gap-3">
                <p class="h3">Sanguinamento animale:</p>
                <?php
                    $conn = get_conn();
                    $sql = "select * from sangue";
                    $res = $conn->query($sql);
                    if (!$res){
                        echo "<p class='h3 text-danger'>dati non disponibili, errore interno database</p>";
                    }else{
                        //se va in errore la query usando else evito di eseguire questa parte inutile
                        $first_radio_button = true;
                        foreach($res as $record){
                            $id_radio_button = "sangue_{$record['id']}";
                            $checked = ($first_radio_button ? 'checked' : '');
                            $first_radio_button = false;
                            echo "
                            <input type='radio' class='btn-check' name='sangue' id='{$id_radio_button}' value='{$record['id']}' autocomplete='off' {$checked}>
                            <label class='btn btn-outline-primary rounded-pill px-4' for='{$id_radio_button}'>{$record['description']}</label>";
                        }
                    }
                ?>
            </div><br>
       
            <div class="d-flex gap-3">
                <p class="h3">Flatulenza:</p>
                <?php
                    $conn = get_conn();
                    $sql = "select * from flatulenza";
                    $res = $conn->query($sql);
                    if (!$res){
                        echo "<p class='h3 text-danger'>dati non disponibili, errore interno database</p>";
                    }else{
                        //se va in errore la query usando else evito di eseguire questa parte inutile
                        $first_radio_button = true;
                        foreach($res as $record){
                            $id_radio_button = "flatulenza_{$record['id']}";
                            $checked = ($first_radio_button ? 'checked' : '');
                            $first_radio_button = false;
                            echo "
                            <input type='radio' class='btn-check' name='flatulenza' id='{$id_radio_button}' value='{$record['id']}' autocomplete='off' {$checked}>
                            <label class='btn btn-outline-primary rounded-pill px-4' for='{$id_radio_button}'>{$record['description']}</label>";
                        }
                    }
                ?>
            </div><br>

            <div class="d-flex gap-3">
                <p class="h3">Lambimento:</p>
                <?php
                    $conn = get_conn();
                    $sql = "select * from lambimento";
                    $res = $conn->query($sql);
                    if (!$res){
                        echo "<p class='h3 text-danger'>dati non disponibili, errore interno database</p>";
                    }else{
                        //se va in errore la query usando else evito di eseguire questa parte inutile
                        $first_radio_button = true;
                        foreach($res as $record){
                            $id_radio_button = "lambimento_{$record['id']}";
                            $checked = ($first_radio_button ? 'checked' : '');
                            $first_radio_button = false;
                            echo "
                            <input type='radio' class='btn-check' name='lambimento' id='{$id_radio_button}' value='{$record['id']}' autocomplete='off' {$checked}>
                            <label class='btn btn-outline-primary rounded-pill px-4' for='{$id_radio_button}'>{$record['description']}</label>";
                        }
                    }
                ?>
            </div><br>

            <div class="mb-3 mt-3">
            <label for="date" class="form-label">data delle rilevazioni: </label><br>
            <input type="date" name="date" id="date"><br><br>
            </div>

            <button class="btn btn-success" type="submit">inserisci log</button>

        </form>
    </div>
</body>
</html>


