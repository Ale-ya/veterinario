<?php
session_start();

require_once("connection/connection.php");
require_once("connection/check_vet.php");

//debug 
//var_dump($_SESSION); 
//die();

if (!isset($_SESSION["status"]) || !isset($_SESSION["username"]) || $_SESSION["status"] !== "verified"){
    header("Location: login.php");
    exit();
}
if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET"){
    if(isset($_GET["id"]) && isset($_SESSION)){
        $conn = get_conn();
        $sql = "SELECT data_di_riferimento, a.peso as peso_appetito, att.peso as peso_atteggiamento, d.peso as peso_dimagrimento, f.peso as frequenza_feci_peso, s.peso as sangue_peso, m.peso as muco_peso, flat.peso as flatulenza_peso, lamb.peso as lambimento_peso, v.peso as vomito_peso FROM `log` JOIN appetito a ON id_appetito = a.id JOIN atteggiamento att ON id_atteggiamento = att.id JOIN dimagrimento d on d.id = id_dimagrimento JOIN frequenza_feci f on id_frequenza_feci = f.id JOIN sangue s ON id_sangue=s.id JOIN muco m ON m.id = id_muco JOIN flatulenza flat ON flat.id = id_flatulenza JOIN lambimento lamb ON lamb.id = id_lambimento JOIN vomito v ON v.id = id_vomito WHERE id_paziente = {$_GET['id']}; ";
        $res = $conn->query($sql);
        if(!$res){
            $str = "errore durante la connessione al database";

        }else{
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

            }
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
<h1>Benvenuta/o, <?php echo  ($_SESSION['type'] == 'vet' ? 'dottor ' : '') . $_SESSION['username'] ?></h1><br><br>

<div style="height: 300px;">
    <canvas id="vomito"></canvas>
</div>

<div style="height: 300px;">
    <canvas id="lambimento"></canvas>
</div>

<div style="height: 300px;">
    <canvas id="appetito"></canvas>
</div>

<div style="height: 300px;">
    <canvas id="atteggiamento"></canvas>
</div>

<div style="height: 300px;">
    <canvas id="dimagrimento"></canvas>
</div>
<div style="height: 300px;">
    <canvas id="frequenza_feci"></canvas>
</div>
<div style="height: 300px;">
    <canvas id="sangue"></canvas>
</div>
<div style="height: 300px;">
    <canvas id="muco"></canvas>
</div>
<div style="height: 300px;">
    <canvas id="flatulenza"></canvas>
</div>

<!-- chart.js-->
<script>
const vomito_charts = document.getElementById('vomito').getContext('2d');
new Chart(ctx, {
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
            ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
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
            ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
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
            ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
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
            ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
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
            ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
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
            ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
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
            ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
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
            ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});
const flatulenza_chart = document.getElementById('flatulenza').getContext('2d');
new Chart(flatulenza_chart, {
    type: 'line',
    data: {
        labels: <?php echo json_encode($data_riferimento) ?>,
            datasets: [
            {
                label: 'Flatulenza',
                data: <?php echo json_encode($pesoflatulenza) ?>,
                borderWidth: 1,
                fill: false,
                borderColor: 'red',
                pointRadius: 0,
            },
            ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false
    }
});
</script>

</body>
</html>









