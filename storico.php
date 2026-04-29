<?php

require_once("connection/connection.php");
require_once("connection/check_vet.php");

//debug
//var_dump($_SESSION);
//die();

$pesolambimento = [];
$pesovomito = [];
$pesoappetito = [];
$pesoatteggiamento = [];
$pesodimagrimento = [];
$pesofrequenza_feci = [];
$pesosangue = [];
$pesomuco = [];
$pesoflatulenza = [];
$data_riferimento = [];

$des_lambimento = [];
$des_vomito = [];
$des_appetito = [];
$des_atteggiamento = [];
$des_dimagrimento = [];
$des_frequenza_feci = [];
$des_sangue = [];
$des_muco = [];
$des_flatulenza = [];
$nome = "";
if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "POST"){
    if(isset($_SESSION['id_paziente'])  && isset($_POST["datainizio"]) && isset($_POST["datafine"])) get_data($_SESSION['id_paziente']);
    else{
        http_response_code(400);
        //TODO button per tornare alla home
        exit();
    }
}

if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET"){
    if(isset($_GET["id"]) && isset($_SESSION)){
        $_SESSION["id_paziente"] = htmlspecialchars($_GET['id']);
        get_data($_SESSION["id_paziente"]);
    }
}

function get_data($id_paziente){
    global $pesolambimento;
    global $pesovomito ;
    global $pesoappetito;
    global $pesoatteggiamento;
    global $pesodimagrimento;
    global $pesofrequenza_feci;
    global $pesosangue;
    global $pesomuco;
    global $pesoflatulenza;
    global $data_riferimento ;

    global $des_lambimento;
    global $des_vomito;
    global $des_appetito;
    global $des_atteggiamento;
    global $des_dimagrimento;
    global $des_frequenza_feci;
    global $des_sangue ;
    global $des_muco ;
    global $des_flatulenza;
    global $nome;
    $conn = get_conn();
    // select 1 dovrebbe migliorare le performance del db siccome non deve cercare nulla ma solo confrontare la condizione e se trova qualcosa restituisce 1
    // dovrebbe returnare un record con tutti i valori ad 1 per ogni corrispondenza
    $sql = "SELECT 1 FROM pazienti_veterinari WHERE id_paziente = {$id_paziente} AND id_veterinario = {$_SESSION['id']}";
    $res = $conn->query($sql);
    if(!$res){
        
        http_response_code(500);
        //TODO button per tornare alla home
        exit();
    }
    if($res->num_rows == 0){
        //401 dovrebbe essere "unauthorized"
        //403 "forbidden" quando mancano i permessi in teoria
        http_response_code(403);
        exit();
        //TODO button per tornare alla home
        //
    }
    $sql = "select nome_paziente from pazienti where id = {$id_paziente}";
    $res = $conn->query($sql);
    $nome = $res->fetch_assoc();
    $condition = "";
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $condition = "and data_di_riferimento between'". htmlspecialchars($_POST["datainizio"]) . "' and '". htmlspecialchars($_POST["datafine"]). "'";
    }
    
    $sql = "SELECT data_di_riferimento,a.description as appetito_des, a.peso as peso_appetito,att.description as att_des, att.peso as peso_atteggiamento,d.description as dimagrimento_des, d.peso as peso_dimagrimento, f.description as frequenza_feci_des,f.peso as frequenza_feci_peso,s.description as sangue_des, s.peso as sangue_peso,m.description as muco_des, m.peso as muco_peso, flat.description as flat_des,flat.peso as flatulenza_peso, lamb.description as lamb_des,lamb.peso as lambimento_peso,v.description as vom_des, v.peso as vomito_peso FROM `log` JOIN appetito a ON id_appetito = a.id JOIN atteggiamento att ON id_atteggiamento = att.id JOIN dimagrimento d on d.id = id_dimagrimento JOIN frequenza_feci f on id_frequenza_feci = f.id JOIN sangue s ON id_sangue=s.id JOIN muco m ON m.id = id_muco JOIN flatulenza flat ON flat.id = id_flatulenza JOIN lambimento lamb ON lamb.id = id_lambimento JOIN vomito v ON v.id = id_vomito  WHERE id_paziente = {$id_paziente} {$condition}; ";

    $res = $conn->query($sql);
    if(!$res){
        $str = "errore durante la connessione al database";

    }else{
        foreach ($res as $record) {
            $pesolambimento[] = $record["lambimento_peso"];
            $pesovomito[] = $record["vomito_peso"];
            $pesoappetito[] = $record["peso_appetito"];
            $pesoatteggiamento[] = $record["peso_atteggiamento"];
            $pesodimagrimento[] = $record["peso_dimagrimento"];
            $pesofrequenza_feci[] = $record["frequenza_feci_peso"];
            $pesosangue[] = $record["sangue_peso"];
            $pesomuco[] = $record["muco_peso"];
            $pesoflatulenza[] = $record["flatulenza_peso"];
            $data_riferimento[] = $record["data_di_riferimento"];

            $des_lambimento[$record["lambimento_peso"]] = $record['lamb_des'];
            $des_vomito[$record["vomito_peso"]] = $record['vom_des'];
            $des_appetito[$record["peso_appetito"]] = $record['appetito_des'];
            $des_atteggiamento[$record["peso_atteggiamento"]] = $record['att_des'];
            $des_dimagrimento[$record["peso_dimagrimento"]] = $record['dimagrimento_des'];
            $des_frequenza_feci[$record["frequenza_feci_peso"]] = $record['frequenza_feci_des'];
            $des_sangue[$record["sangue_peso"]] = $record['sangue_des'];
            $des_muco[$record["muco_peso"]] = $record['muco_des'];
            $des_flatulenza[$record["flatulenza_peso"]] = $record['flat_des'];

        }
    }


}



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
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="d-flex justify-content-center bg-dark py-5">

    <div class=" p-5 text-center bg-white text-dark rounded-3 " style="min-width: 70vw;">
        <div class="d-flex justify-content-between align-items-center ">
            <p class="h1 mb-5 fw-bold text-primary me-3">Storico di <?php echo $nome['nome_paziente'] ?? 'errore database '?> </p>
            <!-- <i> per mettere le icone è consigliato dalla documentazione -->
            <a href="dashboard_owner.php" class="btn btn-secondary mb-5 ms-1 "><i class="bi bi-house me-1"></i> Torna alla home</a>
        </div>
        <div class="mb-4 mt-3 ">
        <form action="storico.php" method="post">
            
            <div class="mb-2 mt-2">
            <label for="datainizio" class="form-label text-start fw-semibold h4  d-block">da: </label>
            <!-- non togliere d-block perhce label è un elemento inline e d-block fa si che occupi tutta la riga da quel che ho capito-->
            <?php 
            //parte di codice presa da https://www.html.it/articoli/date-in-php-come-gestirle/
            $data_rilevamento_minimo = date('Y-m-d');
            $data_rilevamento_massimo   = date('Y-m-d', strtotime('-20 years'));

            echo "<input type='date' class='form-control' name='datainizio' id='datainizio' min='{$data_rilevamento_massimo}' max='{$data_rilevamento_minimo}' required>";
 
            ?>
            </div>

            <div class="mb-2 mt-2">
            <label for="datafine" class="form-label text-start fw-semibold h4  d-block">a: </label>
            <!-- non togliere d-block perhce label è un elemento inline e d-block fa si che occupi tutta la riga da quel che ho capito-->
            <?php 
            //parte di codice presa da https://www.html.it/articoli/date-in-php-come-gestirle/
            $data_rilevamento_minimo = date('Y-m-d');
            $data_rilevamento_massimo   = date('Y-m-d', strtotime('-20 years'));

            echo "<input type='date' class='form-control' name='datafine' id='datafine' min='{$data_rilevamento_massimo}' max='{$data_rilevamento_minimo}' value={$data_rilevamento_minimo} required><br>";
 
            ?>
            </div>
            <button class="btn btn-success btn-sm fs-4" type="submit"><i class="bi bi-calendar3 me-3"></i>Applica filtro data</button>
        </form>
        </div>

        <p class="h4 fw-semibold mb-3 text-start">Vomito: </p>
        <div class="p-5 text-center bg-light text-secondary rounded-3 mb-5 border border-secondary border-1 rounded-3" style="height: 300px;">
            <canvas id="vomito"></canvas>
        </div>

        <p class="h4 fw-semibold mb-3 text-start">Lambimento: </p>
        <div class="p-5 text-center bg-white text-secondary rounded-3 mb-5 border border-secondary border-1 rounded-3" style="height: 300px;">
            <canvas id="lambimento"></canvas>
        </div>

        <p class="h4 fw-semibold mb-3 text-start">Appetito: </p>
        <div class="p-5 text-center bg-light text-secondary rounded-3 mb-5 border border-secondary border-1 rounded-3" style="height: 300px;">
            <canvas id="appetito"></canvas>
        </div>

        <p class="h4 fw-semibold mb-3 text-start">Atteggiamento: </p>
        <div class="p-5 text-center bg-white text-secondary rounded-3 mb-5 border border-secondary border-1 rounded-3" style="height: 300px;">
            <canvas id="atteggiamento"></canvas>
        </div>

        <p class="h4 fw-semibold mb-3 text-start">Dimagrimento: </p>
        <div class="p-5 text-center bg-light text-secondary rounded-3 mb-5 border border-secondary border-1 rounded-3" style="height: 300px;">
            <canvas id="dimagrimento"></canvas>
        </div>
        <p class="h4 fw-semibold mb-3 text-start">Frequenza feci: </p>
        <div class="p-5 text-center bg-white text-secondary rounded-3 mb-5 border border-secondary border-1 rounded-3" style="height: 300px;">
            <canvas id="frequenza_feci"></canvas>
        </div>
        <p class="h4 fw-semibold mb-3 text-start">Sangue: </p>
        <div  class="p-5 text-center bg-light text-secondary rounded-3 mb-5 border border-secondary border-1 rounded-3" style="height: 300px;">
            <canvas id="sangue"></canvas>
        </div>
        <p class="h4 fw-semibold mb-3 text-start">Muco: </p>
        <div class="p-5 text-center bg-white text-secondary rounded-3 mb-5 border border-secondary border-1 rounded-3" style="height: 300px;">
            <canvas id="muco"></canvas>
        </div>
        <p class="h4 fw-semibold mb-3 text-start">Flatulenza: </p>
        <div class="p-5 text-center bg-light text-secondary rounded-3 mb-5 border border-secondary border-1 rounded-3" style="height: 300px;">
            <canvas id="flatulenza"></canvas>
        </div>

    </div>
<!-- chart.js documentazione per ticks
https://www.chartjs.org/docs/latest/samples/scale-options/ticks.html
-->
<script>
var label_flatulenza = <?php echo json_encode($des_flatulenza) ?>;
var label_muco = <?php echo json_encode($des_muco) ?>;
var label_sangue = <?php echo json_encode($des_sangue) ?>;
var label_frequenza_feci = <?php echo json_encode($des_frequenza_feci) ?>;
var label_dimagrimento = <?php echo json_encode($des_dimagrimento) ?>;
var label_atteggiamento = <?php echo json_encode($des_atteggiamento) ?>;
var label_appetito = <?php echo json_encode($des_appetito) ?>;
var label_vomito = <?php echo json_encode($des_vomito) ?>;
var label_lambimento = <?php echo json_encode($des_lambimento) ?>;


const vomito_charts = document.getElementById('vomito').getContext('2d');
new Chart(vomito_charts, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($data_riferimento) ?>,
            datasets: [
            {
                label: 'Vomito',
                data: <?php echo json_encode($pesovomito) ?>,
                borderWidth: 1,
                fill: false,
                borderColor: 'red',
                pointRadius: 0,
            },
            {
                label: 'Vomito (solo rilevazioni)',
                data: <?php
                    //array_map(callable $callback, array $array, array ...$arrays): array
                    //cicla ogni elemento dell'array e, per iterazione, esegue la funzione sul singolo elemento corrente, poi spara i risultati in un nuovo array
                    $array_no_zeri = array_map(
                    function($value) {
                        return $value == 0 ? null : $value;
                    }
                    ,$pesovomito);
                    echo json_encode($array_no_zeri);
                ?>,
                borderWidth: 2,
                fill: false,
                borderColor: 'blue',
                pointRadius: 2,
                pointBackgroundColor: 'blue',
                spanGaps: true, // ricordarsi di mettere false se non si vuole  collegare i punti attraverso i null
                hidden: true,
            }
            ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                ticks: {
                    callback: function(value, index, values) {
                       
                        if (!Number.isInteger(value)) return;

                        return label_vomito[value] ?? "";
                    }
                }

            }
        }
    }
});

const lambimento_chart = document.getElementById('lambimento').getContext('2d');
new Chart(lambimento_chart, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($data_riferimento) ?>,
            datasets: [
            {
                label: 'Lambimento',
                data: <?php echo json_encode($pesolambimento) ?>,
                borderWidth: 1,
                fill: false,
                borderColor: 'red',
                pointRadius: 0,
            },
            {
                label: 'Lambimento (solo rilevazioni)',
                data: <?php
                    //array_map(callable $callback, array $array, array ...$arrays): array
                    //cicla ogni elemento dell'array e, per iterazione, esegue la funzione sul singolo elemento corrente, poi spara i risultati in un nuovo array
                    $array_no_zeri = array_map(
                    function($value) {
                        return $value == 0 ? null : $value;
                    }
                    ,$pesolambimento);
                    echo json_encode($array_no_zeri);
                ?>,
                borderWidth: 2,
                fill: false,
                borderColor: 'blue',
                pointRadius: 2,
                pointBackgroundColor: 'blue',
                spanGaps: true, // ricordarsi di mettere false se non si vuole  collegare i punti attraverso i null
                hidden: true,
            }
            ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                ticks: {
                    callback: function(value, index, values) {
                       
                        if (!Number.isInteger(value)) return;

                        return label_lambimento[value] ?? "";
                    }
                }

            }
        }
    }
});
const appetito_chart = document.getElementById('appetito').getContext('2d');
new Chart(appetito_chart, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($data_riferimento) ?>,
            datasets: [
            {
                label: 'Appetito',
                data: <?php echo json_encode($pesoappetito) ?>,
                borderWidth: 1,
                fill: false,
                borderColor: 'red',
                pointRadius: 0,
            },
            {
                label: 'Appetito (solo rilevazioni)',
                data: <?php
                    //array_map(callable $callback, array $array, array ...$arrays): array
                    //cicla ogni elemento dell'array e, per iterazione, esegue la funzione sul singolo elemento corrente, poi spara i risultati in un nuovo array
                    $array_no_zeri = array_map(
                    function($value) {
                        return $value == 0 ? null : $value;
                    }
                    ,$pesoappetito);
                    echo json_encode($array_no_zeri);
                ?>,
                borderWidth: 2,
                fill: false,
                borderColor: 'blue',
                pointRadius: 2,
                pointBackgroundColor: 'blue',
                spanGaps: true, // ricordarsi di mettere false se non si vuole  collegare i punti attraverso i null
                hidden: true,
            }
            ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                ticks: {
                    callback: function(value, index, values) {
                       
                        if (!Number.isInteger(value)) return;

                        return label_appetito[value] ?? "";
                    }
                }

            }
        }
    }
});
const atteggiamento_chart = document.getElementById('atteggiamento').getContext('2d');
new Chart(atteggiamento_chart, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($data_riferimento) ?>,
            datasets: [
            {
                label: 'Atteggiamento',
                data: <?php echo json_encode($pesoatteggiamento) ?>,
                borderWidth: 1,
                fill: false,
                borderColor: 'red',
                pointRadius: 0,
            },
            {
                label: 'Atteggiamento (solo rilevazioni)',
                data: <?php
                    //array_map(callable $callback, array $array, array ...$arrays): array
                    //cicla ogni elemento dell'array e, per iterazione, esegue la funzione sul singolo elemento corrente, poi spara i risultati in un nuovo array
                    $array_no_zeri = array_map(
                    function($value) {
                        return $value == 0 ? null : $value;
                    }
                    ,$pesoatteggiamento);
                    echo json_encode($array_no_zeri);
                ?>,
                borderWidth: 2,
                fill: false,
                borderColor: 'blue',
                pointRadius: 2,
                pointBackgroundColor: 'blue',
                spanGaps: true, // ricordarsi di mettere false se non si vuole  collegare i punti attraverso i null
                hidden: true,
            }
            ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                ticks: {
                    callback: function(value, index, values) {
                       
                        if (!Number.isInteger(value)) return;

                        return label_atteggiamento[value] ?? "";
                    }
                }

            }
        }
    }
});
const dimagrimento_chart = document.getElementById('dimagrimento').getContext('2d');
new Chart(dimagrimento_chart, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($data_riferimento) ?>,
            datasets: [
            {
                label: 'Dimagrimento',
                data: <?php echo json_encode($pesodimagrimento) ?>,
                borderWidth: 1,
                fill: false,
                borderColor: 'red',
                pointRadius: 0,
            },
            {
                label: 'Dimagrimento (solo rilevazioni)',
                data: <?php
                    //array_map(callable $callback, array $array, array ...$arrays): array
                    //cicla ogni elemento dell'array e, per iterazione, esegue la funzione sul singolo elemento corrente, poi spara i risultati in un nuovo array
                    $array_no_zeri = array_map(
                    function($value) {
                        return $value == 0 ? null : $value;
                    }
                    ,$pesodimagrimento);
                    echo json_encode($array_no_zeri);
                ?>,
                borderWidth: 2,
                fill: false,
                borderColor: 'blue',
                pointRadius: 2,
                pointBackgroundColor: 'blue',
                spanGaps: true, // ricordarsi di mettere false se non si vuole  collegare i punti attraverso i null
                hidden: true,
            }
            ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                ticks: {
                    callback: function(value, index, values) {
                       
                        if (!Number.isInteger(value)) return;

                        return label_dimagrimento[value] ?? "";
                    }
                }

            }
        }
    }
});
const frequenza_feci_chart = document.getElementById('frequenza_feci').getContext('2d');
new Chart(frequenza_feci_chart, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($data_riferimento) ?>,
            datasets: [
            {
                label: 'Frequenza Feci',
                data: <?php echo json_encode($pesofrequenza_feci) ?>,
                borderWidth: 1,
                fill: false,
                borderColor: 'red',
                pointRadius: 0,
            },
            {
                label: 'Frequenza feci (solo rilevazioni)',
                data: <?php
                    //array_map(callable $callback, array $array, array ...$arrays): array
                    //cicla ogni elemento dell'array e, per iterazione, esegue la funzione sul singolo elemento corrente, poi spara i risultati in un nuovo array
                    $array_no_zeri = array_map(
                    function($value) {
                        return $value == 0 ? null : $value;
                    }
                    ,$pesofrequenza_feci);
                    echo json_encode($array_no_zeri);
                ?>,
                borderWidth: 2,
                fill: false,
                borderColor: 'blue',
                pointRadius: 2,
                pointBackgroundColor: 'blue',
                spanGaps: true, // ricordarsi di mettere false se non si vuole  collegare i punti attraverso i null
                hidden: true,
            }
            ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                ticks: {
                    callback: function(value, index, values) {
                       
                        if (!Number.isInteger(value)) return;

                        return label_frequenza_feci[value] ?? "";
                    }
                }

            }
        }
    }
});
const sangue_chart = document.getElementById('sangue').getContext('2d');
new Chart(sangue_chart, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($data_riferimento) ?>,
            datasets: [
            {
                label: 'Sangue',
                data: <?php echo json_encode($pesosangue) ?>,
                borderWidth: 1,
                fill: false,
                borderColor: 'red',
                pointRadius: 0,
            },

            {
                label: 'Sangue (solo rilevazioni)',
                data: <?php
                    //array_map(callable $callback, array $array, array ...$arrays): array
                    //cicla ogni elemento dell'array e, per iterazione, esegue la funzione sul singolo elemento corrente, poi raccoglie i risultati in un nuovo array
                    $array_no_zeri = array_map(
                    function($value) {
                        return $value == 0 ? null : $value;
                    }
                    ,$pesosangue);
                    echo json_encode($array_no_zeri);
                ?>,
                borderWidth: 2,
                fill: false,
                borderColor: 'blue',
                pointRadius: 2,
                pointBackgroundColor: 'blue',
                spanGaps: true, // ricordarsi di mettere false se non si vuole  collegare i punti attraverso i null
                hidden: true,
            }
            ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,

        scales: {
            y: {
                ticks: {
                    callback: function(value, index, values) {
                       
                        if (!Number.isInteger(value)) return;

                        return label_sangue[value] ?? "";
                    }
                }

            }
        }
    }
});
const muco_chart = document.getElementById('muco').getContext('2d');
new Chart(muco_chart, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($data_riferimento) ?>,
            datasets: [
            {
                label: 'Muco',
                data: <?php echo json_encode($pesomuco) ?>,
                borderWidth: 1,
                fill: false,
                borderColor: 'red',
                pointRadius: 0,
            },
            {
                label: 'Muco (solo rilevazioni)',
                data: <?php
                    //array_map(callable $callback, array $array, array ...$arrays): array
                    //cicla ogni elemento dell'array e, per iterazione, esegue la funzione sul singolo elemento corrente, poi raccoglie i risultati in un nuovo array
                    $array_no_zeri = array_map(
                    function($value) {
                        return $value == 0 ? null : $value;
                    }
                    ,$pesomuco);
                    echo json_encode($array_no_zeri);
                ?>,
                borderWidth: 2,
                fill: false,
                borderColor: 'blue',
                pointRadius: 2,
                pointBackgroundColor: 'blue',
                spanGaps: true, // ricordarsi di mettere false se non si vuole  collegare i punti attraverso i null
                hidden: true,
            }
            ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                ticks: {
                    callback: function(value, index, values) {
                       
                        console.log(label_muco);
                        if (!Number.isInteger(value)) return;

                        return label_muco[value] ?? "";
                    }
                }

            }
        }
    }
});
const flatulenza_chart = document.getElementById('flatulenza').getContext('2d');
new Chart(flatulenza_chart, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($data_riferimento) ?>,
        datasets: [
            {
                label: 'Flatulenza (tutti i dati)',
                data: <?php echo json_encode($pesoflatulenza) ?>,
                borderWidth: 1,
                fill: false,
                borderColor: 'red',
                pointRadius: 0,
            },
            {
                label: 'Flatulenza (senza zeri)',
                data: <?php
                    //array_map(callable $callback, array $array, array ...$arrays): array
                    //cicla ogni elemento dell'array e, per iterazione, esegue la funzione sul singolo elemento corrente, poi raccoglie i risultati in un nuovo array
                    $array_no_zeri = array_map(
                    function($value) {
                        return $value == 0 ? null : $value;
                    }
                    ,$pesoflatulenza);
                    echo json_encode($array_no_zeri);
                ?>,
                borderWidth: 2,
                fill: false,
                borderColor: 'blue',
                pointRadius: 2,
                pointBackgroundColor: 'blue',
                spanGaps: true, // ricordarsi di mettere false se non si vuole  collegare i punti attraverso i null
                hidden: true,
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: {
            y: {
                ticks: {
                    callback: function(value, index, values) {
                       
                        if (!Number.isInteger(value)) return;

                        return label_flatulenza[value] ?? "";
                    }
                }

            }
        }
    }
});


</script>

</body>
</html>


