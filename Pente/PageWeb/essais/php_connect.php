<!-- PHP connexion -->
<?php
  $conn_string = "host=localhost port=5432 dbname=bigdata user=julie password=julie";
  echo("<script>console.log('PHP: ".$conn_string."');</script>");
  $dbconn = pg_connect($conn_string)
        or die("Connexion impossible");
  echo 'Connexion réussie';
  pg_close($dbconn);

  // Requête pour la map
  $sql_map = '';
  $map_coord =  $bdd->exec($sql_map);
  //Requête pour la pente moyenne
  $sqlmoy = 'SELECT AVG(pente_deg) FROM pente';
  $pente_moyenne =  pg_query($dbconn, $sqlmoy);
  $pente_moy = pg_fetch_result($pente_moyenne, 0, 0);
  //Requête pour la pente max
  $sqlmax = 'SELECT MAX(pente_deg) AS maxpente FROM pente';
  $pente_maximale = pg_query($dbconn,  $sqlmax);
  $pente_max = pg_fetch_result($pente_maximale,0,0);
  $pente_max_diagramme = ceil($pente_max);
  echo("<script>console.log('PHP: ". $pente_max_diagramme."');</script>");

  //Requête pour le diagramme de pente
  $sqlt1 = 'SELECT COUNT(*) FROM pente WHERE pente_deg < 5';
  $pentest1 = pg_query($dbconn,  $sqlt1);
  $pent1 = pg_fetch_result($pentest1,0,0);
  $sqlt2 = 'SELECT COUNT(*) FROM pente WHERE pente_deg < 10 AND pente_deg >= 5';
  $pentest2 = pg_query($dbconn,  $sqlt2);
  $pent2 = pg_fetch_result($pentest2,0,0);
  $sqlt3 = 'SELECT COUNT(*) FROM pente WHERE pente_deg < 15 AND pente_deg >= 10';
  $pentest3 = pg_query($dbconn,  $sqlt3);
  $pent3 = pg_fetch_result($pentest3,0,0);
  $sqlt4 = 'SELECT COUNT(*) FROM pente WHERE pente_deg < 20 AND pente_deg >= 15';
  $pentest4 = pg_query($dbconn,  $sqlt4);
  $pent4 = pg_fetch_result($pentest4,0,0);
  $sqlt5 = 'SELECT COUNT(*) FROM pente WHERE pente_deg < 25 AND pente_deg >= 20';
  $pentest5 = pg_query($dbconn,  $sqlt5);
  $pent5 = pg_fetch_result($pentest5,0,0);
  $sqlt6 = 'SELECT COUNT(*) FROM pente WHERE pente_deg < 30 AND pente_deg >= 25';
  $pentest6 = pg_query($dbconn,  $sql6);
  $pent6 = pg_fetch_result($pentest6,0,0);
  $sqlt7 = 'SELECT COUNT(*) FROM pente WHERE pente_deg < 35 AND pente_deg >= 30';
  $pentest7 = pg_query($dbconn,  $sqlt7);
  $pent7 = pg_fetch_result($pentest7,0,0);
  $sqlt8 = 'SELECT COUNT(*) FROM pente WHERE pente_deg < 40 AND pente_deg >= 35';
  $pentest8 = pg_query($dbconn,  $sqlt8);
  $pent8 = pg_fetch_result($pentest8,0,0);

  $sth = $conn->prepare($sql);
  $sth->execute(array(
    ':distance' => $distance,
    ':surface' => ($surface * pow(10, -4)),
    ':xmin' => $bbox[0],
    ':ymin' => $bbox[1],
    ':xmax' => $bbox[2],
    ':ymax' => $bbox[3],
));

for ($i = 0; $i <= $num; $i++) {
  $array=pg_fetch_array($pgarray, $i);
  $arr = array('lat' => $array[0], 'lon' => $array[1]);
  array_push($arrayfinal, $arr);
 }


?>

<!-- A mettre au niveau de la jauge -->
var pente_moyenne = <?php echo json_encode($pente_moyenne); ?>;

<!-- A mettre au niveau du diagramme -->
var pentest1 = <?php echo json_encode($pentest1); ?>;
var pentest2 = <?php echo json_encode($pentest2); ?>;
var pentest3 = <?php echo json_encode($pentest3); ?>;
var pentest4 = <?php echo json_encode($pentest4); ?>;
var pentest5 = <?php echo json_encode($pentest5); ?>;
var pentes = {"0-10":pentest1, "10-20":pentest2, "20-30":pentest3, "30-40":pentest4, "40-50":pentest5 };
