<!-- PHP connexion -->
<?php
  $conn_string = "host=localhost port=5432 dbname=bigdata user=julie password=julie";
  $dbconn = pg_connect($conn_string)
        or die("Connexion impossible");
  echo 'Connexion réussie';
  pg_close($dbconn);

  // Requête pour la map
  $sql = '';
  $map_coord =  $bdd->exec($sql);
  //Requête pour le diagramme de pente
  $sqlt1 = 'SELECT COUNT(*) FROM pente WHERE pente_deg < 10';
  $pentest1 = $bdd->exec($sqlt1);
  $sqlt2 = 'SELECT COUNT(*) FROM pente WHERE pente_deg < 20 AND pente_deg >= 10';
  $pentest2 = $bdd->exec($sqlt2);
  $sqlt3 = 'SELECT COUNT(*) FROM pente WHERE pente_deg < 30 AND pente_deg >= 20';
  $pentest3 = $bdd->exec($sqlt3);
  $sqlt4 = 'SELECT COUNT(*) FROM pente WHERE pente_deg < 40 AND pente_deg >= 30';
  $pentest4 = $bdd->exec($sqlt4);
  $sqlt5 = 'SELECT COUNT(*) FROM pente WHERE pente_deg < 50 AND pente_deg >= 60';
  $pentest5 = $bdd->exec($sqlt5);
  //Requête pour la pente moyenne
  $sql2 = 'SELECT AVG(pente_deg) FROM pente';
  $pente_moyenne = $bdd->exec($sql2);
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
