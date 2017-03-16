<!-- PHP connexion -->
<?php
  $conn_string = "host=localhost port=5432 dbname=bigdata user=julie password=julie";
  $dbconn = pg_connect($conn_string)
        or die("Connexion impossible");
  echo 'Connexion réussie';
  pg_close($dbconn);

  // Requête pour la map
  $sql_map = '';
  $map_coord =  $bdd->exec($sql_map);
  //Requête pour la pente moyenne
  $sqlmoy = 'SELECT AVG(pente_deg) FROM pente';
  $pente_moyenne = $bdd->exec($sqlmoy);
  //Requête pour la pente max
  $sqlmax = 'SELECT MAX(pente_deg) FROM pente';
  $pente_max = $bdd->exec($sqlmax);
  $pente_max_diagramme = ceil($pente_max);
  //Requête pour la pente moyenne
  $sqlmin = 'SELECT MIN(pente_deg) FROM pente';
  $pente_min = $bdd->exec($sqlmin);
  //Requête pour le diagramme de pente
  $sqlt1 = 'SELECT COUNT(*) FROM pente WHERE pente_deg < 5';
  $pentest1 = $bdd->exec($sqlt1);
  $sqlt2 = 'SELECT COUNT(*) FROM pente WHERE pente_deg < 10 AND pente_deg >= 5';
  $pentest2 = $bdd->exec($sqlt2);
  $sqlt3 = 'SELECT COUNT(*) FROM pente WHERE pente_deg < 15 AND pente_deg >= 10';
  $pentest3 = $bdd->exec($sqlt3);
  $sqlt4 = 'SELECT COUNT(*) FROM pente WHERE pente_deg < 20 AND pente_deg >= 15';
  $pentest4 = $bdd->exec($sqlt4);
  $sqlt5 = 'SELECT COUNT(*) FROM pente WHERE pente_deg < 25 AND pente_deg >= 20';
  $pentest5 = $bdd->exec($sqlt5);
  $sqlt6 = 'SELECT COUNT(*) FROM pente WHERE pente_deg < 30 AND pente_deg >= 25';
  $pentest6 = $bdd->exec($sql6);
  $sqlt7 = 'SELECT COUNT(*) FROM pente WHERE pente_deg < 35 AND pente_deg >= 30';
  $pentest7 = $bdd->exec($sqlt7);
  $sqlt8 = 'SELECT COUNT(*) FROM pente WHERE pente_deg < 40 AND pente_deg >= 35';
  $pentest8 = $bdd->exec($sqlt8);

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
