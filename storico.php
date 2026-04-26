<?php

require_once("connection/connection.php");
require_once("connection/check_vet.php");

//debug 
//var_dump($_SESSION); 
//die();


if(isset($_SERVER["REQUEST_METHOD"]) && $_SERVER["REQUEST_METHOD"] == "GET"){
    if(isset($_GET["id"]) && isset($_SESSION)){

        
        
        $conn = get_conn();
        $id_paziente = htmlspecialchars($_GET['id']);
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

        $sql = "SELECT data_di_riferimento, a.peso as peso_appetito, att.peso as peso_atteggiamento, d.peso as peso_dimagrimento, f.peso as frequenza_feci_peso, s.peso as sangue_peso, m.peso as muco_peso, flat.peso as flatulenza_peso, lamb.peso as lambimento_peso, v.peso as vomito_peso FROM `log` JOIN appetito a ON id_appetito = a.id JOIN atteggiamento att ON id_atteggiamento = att.id JOIN dimagrimento d on d.id = id_dimagrimento JOIN frequenza_feci f on id_frequenza_feci = f.id JOIN sangue s ON id_sangue=s.id JOIN muco m ON m.id = id_muco JOIN flatulenza flat ON flat.id = id_flatulenza JOIN lambimento lamb ON lamb.id = id_lambimento JOIN vomito v ON v.id = id_vomito WHERE id_paziente = {$id_paziente}; ";
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
<body class="d-flex justify-content-center bg-dark py-5">

    <div class="p-5 text-center bg-white text-dark rounded-3 ">
        <div class="d-flex justify-content-between align-items-center me-auto">
            <p class="h1 mb-5 fw-bold text-primary me-4">Benvenuta/o, <?php echo  ($_SESSION['usertype'] == 'vet' ? 'dottor ' : '') . $_SESSION['username'] ?></p><br><br>
            <a href="dashboard_vet.php" class="btn btn-secondary mb-5 ms-1">Torna alla home</a>
        </div>

        <div class="p-5 text-center bg-light text-secondary rounded-3 mb-5 border border-secondary border-1 rounded-3" style="height: 300px;">
            <canvas id="vomito"></canvas>
        </div>

        <div class="p-5 text-center bg-white text-secondary rounded-3 mb-5 border border-secondary border-1 rounded-3" style="height: 300px;">
            <canvas id="lambimento"></canvas>
        </div>

        <div class="p-5 text-center bg-light text-secondary rounded-3 mb-5 border border-secondary border-1 rounded-3" style="height: 300px;">
            <canvas id="appetito"></canvas>
        </div>

        <div class="p-5 text-center bg-white text-secondary rounded-3 mb-5 border border-secondary border-1 rounded-3" style="height: 300px;">
            <canvas id="atteggiamento"></canvas>
        </div>

        <div class="p-5 text-center bg-light text-secondary rounded-3 mb-5 border border-secondary border-1 rounded-3" style="height: 300px;">
            <canvas id="dimagrimento"></canvas>
        </div>
        <div class="p-5 text-center bg-white text-secondary rounded-3 mb-5 border border-secondary border-1 rounded-3" style="height: 300px;">
            <canvas id="frequenza_feci"></canvas>
        </div>
        <div  class="p-5 text-center bg-light text-secondary rounded-3 mb-5 border border-secondary border-1 rounded-3" style="height: 300px;">
            <canvas id="sangue"></canvas>
        </div>
        <div class="p-5 text-center bg-white text-secondary rounded-3 mb-5 border border-secondary border-1 rounded-3" style="height: 300px;">
            <canvas id="muco"></canvas>
        </div>
        <div class="p-5 text-center bg-light text-secondary rounded-3 mb-5 border border-secondary border-1 rounded-3" style="height: 300px;">
            <canvas id="flatulenza"></canvas>
        </div>

    </div>
<!-- chart.js documentazione per ticks
https://www.chartjs.org/docs/latest/samples/scale-options/ticks.html
-->
<script>
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
/*
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
*/
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
                    $dati_senza_zeri = array_map(function($value) {
                        return $value == 0 ? null : $value;
                    }, $pesoflatulenza);
                    echo json_encode($dati_senza_zeri);
                ?>,
                borderWidth: 2,
                fill: false,
                borderColor: 'blue',
                pointRadius: 3,
                pointBackgroundColor: 'blue',
                spanGaps: true, // ricordarsi di mettere false se non si vuole  collegare i punti attraverso i null
            }
        ]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        //todo: fare query e poi sostituire le stringhe con i valori php sortati rsort()
        scales: {
            y: {
                ticks: {
                    callback: function(value, index, values) {
                    switch(value) {
                        case 0:
                            return '0 - Assente';
                        case 1:
                            return '1 - Leggera';
                        case 2:
                            return '2 - Moderata';
                        case 3:
                            return '3 - Grave';
                        case 4:
                            return '4 - Molto grave';
                        default:
                            return value;
                        }
                    }
                }

            }
        }
    }
});


</script>

</body>
</html>









