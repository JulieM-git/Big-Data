<!DOCTYPE html>
<html lang="fr">
	<head>
		<title>Pente</title>
		<!-- Metadonnees -->
		<meta charset="utf-8">
		<!-- Insertion des librairies -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.0.3/dist/leaflet.css" />
		<script src="https://unpkg.com/leaflet@1.0.3/dist/leaflet.js"></script>
		<script src="http://d3js.org/d3.v3.min.js" language="JavaScript"></script>
    <script src="fichiers/liquidFillGauge.js" language="JavaScript"></script>
		<script src="http://leaflet.github.io/Leaflet.heat/dist/leaflet-heat.js"></script>
		<script src="fichiers/leaflet-heat.js"></script>
		<script src="fichiers/heatmap.js"></script>
		<script src="fichiers/leaflet-heatmap.js"></script>
		<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.1.js"></script>
		<script src="http://cdn.leafletjs.com/leaflet-0.7.3/leaflet.js"></script>
		<script type="text/javascript" src="http://cdnjs.cloudflare.com/ajax/libs/jquery-csv/0.71/jquery.csv-0.71.min.js"></script>
		<script src="http://labratrevenge.com/d3-tip/javascripts/d3.tip.v0.6.3.js"></script>
		<!-- Insertion des scripts js -->
		<script src="fichiers/grid.js"></script>
		<script src="fichiers/codeColor.js"></script>

		<!-- CSS pour l'instant -->
		<style>
			body {
				margin: 0px;
				background-color: #000000;
				overflow: hidden;
			}
			.axis path,
			.axis line {
			  fill: none;
			  stroke: #000;
			  shape-rendering: crispEdges;
			}

			.bar {
			  fill: orange;
			}

			.bar:hover {
			  fill: orangered ;
			}

			.x.axis path {
			  display: none;
			}

			.d3-tip {
			  line-height: 1;
			  font-weight: bold;
			  padding: 12px;
			  background: rgba(0, 0, 0, 0.8);
			  color: #fff;
			  border-radius: 2px;
			}

			/* Creates a small triangle extender for the tooltip */
			.d3-tip:after {
			  box-sizing: border-box;
			  display: inline;
			  font-size: 10px;
			  width: 100%;
			  line-height: 1;
			  color: rgba(0, 0, 0, 0.8);
			  content: "\25BC";
			  position: absolute;
			  text-align: center;
			}

			/* Style northward tooltips differently */
			.d3-tip.n:after {
			  margin: -1px 0 0 0;
			  top: 100%;
			  left: 0;
			}
			.liquidFillGaugeText { font-family: Arial; font-weight: bold; }

			.arc text {
			  font: 10px sans-serif;
			  text-anchor: middle;
			}

			.arc path {
			  stroke: #fff;
			}
		</style>

	</head>

		<!-- Affichage Map -->


		<body >
			<div class='container-fluid'>
				<div class="row">
					<div class="col-md-8" style="padding:0">
						<div id="map"></div>
					</div>
					<div class="col-md-4">
						<div class='container-fluid'>
							<div class="row" style="margin:5%; min-height:50px;">
									<svg id="fillgaugemoy" width="50%" height="100"></svg>
									<p style="text-align:center; font-size:160%; color:	#FF8C00;">Pente moyenne</p>
									<svg id="fillgaugemax" width="50%" height="100"></svg>
									<p style="text-align:center; font-size:160%; color:	#8B0000;">Pente maximale</p>
							</div>
							<div class="row" style="margin:auto; min-height:50px; text-align:rigth;">
								<svg id="diagramme" width="100%" height="100"></svg>
							</div>
							<div class="row" style="margin:auto; min-height:50px; text-align:left; ">
								<svg id="donut" width="100%" height="400"></svg>
								<p style="text-align:center; font-size:160%; color:	#FFA500;">Diagrammes de Pentes</p>
							</div>
						</div>
					</div>
				</div>
			</div>
			<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

			<?php
					ini_set('memory_limit', '1024M');
			   $conn_string = "host=localhost port=5432 dbname=pente user=postgres password=postgres";
			   echo("<script>console.log('PHP: ".$conn_string."');</script>");
			   $dbconn = pg_connect($conn_string)
			        or die("Connexion impossible");
				 echo("<script>console.log('PHP: Connexion réussie');</script>");

				 //Requête pour les coordonnées moyennes
				$sqllat = 'SELECT AVG(ST_Y(geom)) FROM pente';
				$lat_moyenne =  pg_query($dbconn, $sqllat);
				$lat_moy = pg_fetch_result($lat_moyenne, 0, 0);
				$sqllon = 'SELECT AVG(ST_X(geom)) FROM pente';
				$lon_moyenne =  pg_query($dbconn, $sqllon);
				$lon_moy = pg_fetch_result($lon_moyenne, 0, 0);

				 //Requête pour la pente moyenne
			   $sqlmoy = 'SELECT AVG(pente_deg) FROM pente';
			   $pente_moyenne =  pg_query($dbconn, $sqlmoy);
				 $pente_moy = pg_fetch_result($pente_moyenne, 0, 0);
			   //Requête pour la pente max
			   $sqlmax = 'SELECT MAX(pente_deg) AS maxpente FROM pente';
			   $pente_maximale = pg_query($dbconn,  $sqlmax);
				 $pente_max = pg_fetch_result($pente_maximale,0,0);
				 $pente_max_diagramme = ceil($pente_max);


				 $sql = 'SELECT MIN(ST_Y(geom)), MAX(ST_Y(geom)), MIN(ST_X(geom)), MAX(ST_X(geom)) FROM pente';
				 $resultminmax = pg_query($dbconn, $sql);
				 $result = pg_fetch_row( $resultminmax);

				 $sqlcount = 'SELECT COUNT(*) FROM pente';
				 $cnum = pg_query($dbconn, $sqlcount);
				 $num = pg_fetch_result($cnum,0,0);

				 $sqlarray = 'SELECT pente_deg FROM pente';
 				 $pgarray =  pg_query($dbconn, $sqlarray);
				 $arr = pg_fetch_all($pgarray);

				?>

			<script language="JavaScript">
			var lat_moyenne = <?php echo $lat_moy; ?>;
			var lon_moyenne = <?php echo $lon_moy; ?>;
			var result = <?php echo json_encode($result); ?>;
			var arr = <?php echo json_encode($arr); ?>;
			var pente_moyenne = <?php echo $pente_moy; ?>;
			var pente_max = <?php echo $pente_max; ?>;
			var maxValue = <?php echo $pente_max_diagramme; ?>;
			var num = <?php echo $num; ?>;

			/**
				* Map
			**/

			var hauteur = document.documentElement.clientHeight;
			var mapDiv = document.getElementById('map');
			mapDiv.style.height = hauteur +'px'; // applique la hauteur de la page


				// create the tile layer with correct attribution
				var tuileUrl = 'http://{s}.tile.osm.org/{z}/{x}/{y}.png';
				var attrib='Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
				var baseLayer = L.tileLayer(tuileUrl, {
						minZoom: 8,
						maxZoom: 17,
						attribution: attrib
				});

				var center_map = new L.LatLng(lat_moyenne,lon_moyenne);
				// gridlayer
				var grid = L.layerGroup();

				var map = L.map('map').setView(center_map, 13);
				baseLayer.addTo(map);

			/**
				* Jauge Pente Moyenne
			**/

			var config_moy = liquidFillGaugeDefaultSettings();
			config_moy.maxValue=maxValue ;
			config_moy.circleColor = "#FF8C00";
			config_moy.textColor = "#FF8C00";
			config_moy.waveTextColor = "#FFAAAA";
			config_moy.waveColor = "#FF8C00";
			config_moy.circleThickness = 0.1;
			config_moy.waveAnimateTime = 1000;
			var gauge_moy = loadLiquidFillGauge("fillgaugemoy", pente_moyenne, config_moy);

			var config_max = liquidFillGaugeDefaultSettings();
			config_max.maxValue=maxValue ;
			config_max.circleColor = "#B22222";
			config_max.textColor = "#B22222";
			config_max.waveTextColor = "#FFAAAA";
			config_max.waveColor = "#B22222";
			config_max.circleThickness = 0.1;
			config_max.waveAnimateTime = 1000;
			var gauge_max = loadLiquidFillGauge("fillgaugemax", pente_max, config_max);

			/**
				* Diagramme Pente
			**/

			var margin = {top: 20, right: 10, bottom: 10, left: 20},
			    width = 100 ,
			    height = 75;

			var x = d3.scale.ordinal()
			    .rangeRoundBands([margin.left, width+margin.left], .1);

			var y = d3.scale.linear()
			    .range([margin.top+height, margin.top]);

			var xAxis = d3.svg.axis()
			    .scale(x)
			    .orient("bottom");

			var yAxis = d3.svg.axis()
			    .scale(y)
			    .orient("left");

			var tip = d3.tip()
			  .attr('class', 'd3-tip')
			  .offset([-10, 0])
			  .html(function(d) {
			    return " <span style='color:red'>" + d.number + "</span>";
			  })

			var svg = d3.select("svg[id='diagramme']");
			svg.attr("width", width + margin.left + margin.right)
    	svg.attr("height", height + margin.top + margin.bottom)
			svg.attr("transform", "translate(" + margin.left + "," + margin.top + ")");
			svg.call(tip);

			d3.tsv("data.tsv", type, function(error, data) {
			  x.domain(data.map(function(d) { return d.degre; }));
			  y.domain([0, d3.max(data, function(d) { return d.number; })]);

			  svg.append("g")
			      .attr("class", "x axis")
			      .attr("transform", "translate(0," + height + ")")
			      .call(xAxis)
						.style("fill", "white");


			  svg.append("g")
			      .attr("class", "y axis")
			      .call(yAxis);

			  svg.selectAll(".bar")
			      .data(data)
			    .enter().append("rect")
			      .attr("class", "bar")
			      .attr("x", function(d) { return x(d.degre); })
			      .attr("width", x.rangeBand())
			      .attr("y", function(d) { return y(d.number); })
			      .attr("height", function(d) { if( height - y(d.number) > 0){return height - y(d.number);} else{ return 0;} })
			      .on('mouseover', tip.show)
			      .on('mouseout', tip.hide)

			});

			function type(d) {
			  d.number = +d.number;
			  return d;
			}

			/**
				* Donut
			**/

			var margin = {top: 40, right: 20, bottom: 20, left: 40},
			    width = 400 ,
			    height = 300;
	    radius = Math.min(width, height) / 2;

			var colors = d3.scale.ordinal()
			    .range(["#98abc5", "#8a89a6", "#7b6888", "#6b486b", "#a05d56", "#d0743c", "#ff8c00"]);

			var arc = d3.svg.arc()
			    .outerRadius(radius - 10)
			    .innerRadius(radius - 70);

			var pie = d3.layout.pie()
			    .sort(null)
			    .value(function(d) { return d.number; });

			var svg = d3.select("svg[id='donut']")
			    .attr("width", width)
			    .attr("height", height)
			  .append("g")
			    .attr("transform", "translate(" + width / 2 + "," + height / 2 + ")");

			d3.tsv("datadonut.tsv", type, function(error, data) {
			  if (error) throw error;

			  var g = svg.selectAll(".arc")
			      .data(pie(data))
			    .enter().append("g")
			      .attr("class", "arc");

			  g.append("path")
			      .attr("d", arc)
			      .style("fill", function(d) { return colors(d.data.degre); });

			  g.append("text")
			      .attr("transform", function(d) { return "translate(" + arc.centroid(d) + ")"; })
			      .attr("dy", ".35em")
			      .text(function(d) { return d.data.degre; });
			});

			function type(d) {
			  d.number = +d.number;
			  return d;
			}

			/**
				* HeatMap
			**/
			var latmin = result[0];
					latmax = result[1];
					lonmin = result[2];
					lonmax = result[3];
					nb_col = 100;//Math.sqrt(num);
					nb_lig = 100; //Math.sqrt(num);


			// creation of the grid composed of rectangles
			for (var i=0; i<nb_lig; i+=10){
					for (var j=0; j< nb_col; j+=10){
						// color corresponding of the danger
						var color=heatMapColorforValue(arr[i*nb_col+j]['pente_deg'], maxValue);
						// rectangle
						var rectanglePoints = [[latmin+j*(latmax-latmin)/nb_col, lonmin+i*(lonmax-lonmin)/nb_lig],
																	[latmin+(j+1)*(latmax-latmin)/nb_col, lonmin+(i+1)*(lonmax-lonmin)/nb_lig]];
						var rectangle = new L.rectangle(rectanglePoints, {stroke: true, fillOpacity: 0.4, color: color,fillColor: color});
						// add to the gid
						rectangle.addTo(grid);
					}
				}
				grid.addTo(map);
			</script>
		</body>

</html>
