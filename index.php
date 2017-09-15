<?php
        mb_internal_encoding("UTF-8");
        require_once ('Tridy/Db.php');
        require_once ('Tridy/Decode.php');
        require_once ('Tridy/Save.php');
        require_once ('Tridy/Day.php');
        Db::pripoj("127.0.0.1", "root", "", "pocasi_db");  
        
// Convert JSON to PHP array 
        $decode = new Decode();
        $phpObj = $decode->decodeJson(); 
        
// Uloží objekt do Db
        $save = new Save($phpObj);
        $save->save();
                    
//Načtení dat z databáze a vytvoření instancí dnů
        $i=0;
        $wheaterData = Db::dotazVsechny('SELECT id, date, (high+low)/2 avTemp, high, low FROM pocasi_praha ORDER BY date DESC');
        foreach (array_reverse($wheaterData) as $data)
            {
            $day[$i] = new Day();
            $dateInst = new DateTime($data['date']);
            $day[$i]->setHigh($data['high']);
            $day[$i]->setLow($data['low']);
            $day[$i]->setId($data['id']);
            $day[$i]->setDate($data['date']);
            $day[$i]->setAvTemp($data['avTemp']);
            $day[$i]->setDateInst($dateInst);
            $i=$i+1;
            }
            
?>  



<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Teploty v Praze</title>
    <link rel="stylesheet" href="styl.css" type="text/css"/> 
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script class="graf" type="text/javascript">
      google.charts.load('current', {'packages':['corechart']});
      google.charts.setOnLoadCallback(drawChart);

      function drawChart() {
        var data = google.visualization.arrayToDataTable([
        ['Den','Teplota'],
         <?php for($i=0;$i<=count($wheaterData)-1;$i++):?>[<?= $day[$i]->getDateInst()->format("d");?>,  
        <?= $day[$i]->getAvTemp();?>],<?php endfor;?>
       [<?= $day[count($wheaterData)-1]->getDateInst()->format("d");?>, 
        <?= $day[count($wheaterData)-1]->getAvTemp();?>]
        ]);

        var options = {
          title: 'Průměrná teplota v Praze ve dnech <?= $day[0]->getDate();?> - <?= $day[count($wheaterData)-1]->getDate();?>',
          curveType: 'function',
          legend: { position: 'bottom' }
        };

        var chart = new google.visualization.LineChart(document.getElementById('curve_chart'));

        chart.draw(data, options);
      }
    </script>
    <script type="text/javascript">
        function vyberDatum()
{

        var url = document.getElementById("vyber").value;
        document.getElementById("mistoZobrazeni").innerHTML = url;
    }


    </script>
    </head>

<body> 
<article>
    <header>
        <h1> Teploty v Praze</h1>
    </header>
   
           
<!--Vytvoření seznamu datumů, výběr minimální a maximální teploty v daný den-->
    <fieldset>
        <label for="vyber">Vyber datum pro získání minimální a maximální teploty:</label><br>
        <select name="vyber" id="vyber" onchange="vyberDatum();">
        <option value="">Vyberte datum</option>
        <?php for($i=0;$i<=count($wheaterData)-1;$i++):?>
        <option value="Minimální teplota: <?= $day[$i]->getLow();?>°C <br>Maximální teplota:<?= $day[$i]->getHigh();?>°C"><?= $day[$i]->getDate();?></option>
        <?php endfor;?>
        </select>
        
<!--Místo vypsání max a min teploty-->
        <div id="mistoZobrazeni">
        </div>
    </fieldset>

<!--Místo zobrazení grafu-->
        <figcaption id="curve_chart" >
        </figcaption>

<!--Logo Yahoo-->
        <img src="Foto/Yahoo.png" width="112.5" height="112.5" alt="Logo Yahoo"/>
</article>
</body>
</html>


